import { spawnSync } from 'node:child_process';
import { existsSync, lstatSync, mkdtempSync, readFileSync, realpathSync, rmSync, symlinkSync, unlinkSync } from 'node:fs';
import { homedir, tmpdir } from 'node:os';
import path from 'node:path';
import { pathToFileURL } from 'node:url';

function run(command, args, options = {}) {
    const result = spawnSync(command, args, { stdio: 'inherit', ...options });
    if (result.error || result.status !== 0) {
        if (result.stderr) process.stderr.write(result.stderr);
        throw new Error(`${command} failed (${result.status ?? result.error?.message}).`);
    }
    return result.stdout;
}

function git(args) {
    return run('git', args, {
        encoding: 'utf8',
        stdio: ['ignore', 'pipe', 'pipe'],
    });
}

function paths(output) {
    return output.split('\0').filter(Boolean);
}

function php() {
    const binary = process.env.HERD_PHP || (process.platform === 'win32' ? path.join(homedir(), '.config/herd/bin/php84/php.exe') : 'php');
    run(binary, ['-r', 'exit(PHP_VERSION_ID >= 80400 ? 0 : 1);']);
    return binary;
}

async function prettierCheck(directory, files, root) {
    const supported = files.filter((file) => /\.(?:[cm]?js|jsx|ts|tsx|json|css|scss|less|html|md|mdx|ya?ml)$/i.test(file));
    if (!supported.length) return;
    const prettier = await import(pathToFileURL(path.join(root, 'node_modules/prettier/index.mjs')));
    let failed = false;
    for (const file of supported) {
        const absolute = path.join(directory, file);
        if (!lstatSync(absolute).isFile()) continue;
        const config = await prettier.resolveConfig(absolute, {
            editorconfig: true,
        });
        const info = await prettier.getFileInfo(absolute, {
            ignorePath: path.join(directory, '.prettierignore'),
            plugins: config?.plugins,
        });
        if (info.ignored || !info.inferredParser) continue;
        if (
            !(await prettier.check(readFileSync(absolute, 'utf8'), {
                ...config,
                filepath: absolute,
            }))
        ) {
            console.error(`Prettier: ${JSON.stringify(file)} needs formatting.`);
            failed = true;
        }
    }
    if (failed) throw new Error('Format the reported files, then stage only the intended hunks and retry.');
}

async function preCommit(root) {
    const files = paths(git(['diff', '--cached', '--name-only', '-z', '--diff-filter=ACMR']));
    if (!files.length) return;
    // Check an export of the index: neither formatters nor Git write to the real index/worktree.
    const snapshot = mkdtempSync(path.join(realpathSync(tmpdir()), 'rsp-hook-'));
    const dependencies = path.join(snapshot, 'node_modules');
    try {
        run('git', ['checkout-index', '--all', `--prefix=${snapshot.replaceAll('\\', '/')}/`]);
        if (existsSync(path.join(root, 'node_modules'))) {
            symlinkSync(path.join(root, 'node_modules'), dependencies, process.platform === 'win32' ? 'junction' : 'dir');
        }
        const regular = files.filter((file) => lstatSync(path.join(snapshot, file)).isFile());
        const phpFiles = regular.filter((file) => file.endsWith('.php') && !file.endsWith('.blade.php'));
        if (phpFiles.length) {
            const binary = php();
            const pint = path.join(root, 'vendor/bin/pint');
            if (!existsSync(pint)) throw new Error('Pint is missing. Install Composer dependencies from the lock file.');
            for (const file of phpFiles) {
                run(binary, [pint, '--test', '--config', path.join(snapshot, 'pint.json'), '--', path.join(snapshot, file)], {
                    cwd: snapshot,
                });
            }
        }
        // Blade policy belongs to RSP-5; neither formatter opts Blade in here.
        await prettierCheck(snapshot, regular, root);
    } finally {
        if (existsSync(dependencies) && lstatSync(dependencies).isSymbolicLink()) unlinkSync(dependencies);
        rmSync(snapshot, { recursive: true, force: true });
    }
}

async function prePush(root) {
    const updates = readFileSync(0, 'utf8')
        .split(/\r?\n/)
        .filter(Boolean)
        .map((line) => line.split(/\s+/));
    const outgoing = updates.filter(([, local, , remote]) => !/^0+$/.test(local) && local !== remote);
    if (!outgoing.length) return; // Deletions and unchanged refs do not introduce code.
    const head = git(['rev-parse', 'HEAD^{tree}']).trim();
    for (const [ref, local] of outgoing) {
        if (git(['rev-parse', `${local}^{tree}`]).trim() !== head) {
            throw new Error(`Cannot validate ${ref} from this checkout. Check out that ref and push it separately.`);
        }
    }
    // One full canonical pipeline per push, even for force pushes/new branches/multiple refs.
    // Require the tested checkout to match every outgoing tree, including staged changes.
    if (git(['status', '--porcelain', '--untracked-files=all']).length) {
        throw new Error('Pre-push requires a clean checkout. Commit or stash changes and untracked files, then retry.');
    }
    await prettierCheck(root, paths(git(['ls-files', '-z'])), root);
    const binary = php();
    const env = { ...process.env };
    if (path.isAbsolute(binary)) {
        const key = Object.keys(env).find((key) => key.toLowerCase() === 'path') || 'PATH';
        env[key] = `${path.dirname(binary)}${path.delimiter}${env[key] || ''}`;
    }
    console.log('Pre-push: composer quality:check (frontend, essential tests with TIA, audits and static checks).');
    // The command is constant. sh also resolves Composer's Windows shell launcher.
    run('sh', ['-c', 'composer run quality:check --no-interaction'], {
        env,
    });
}

try {
    const root = git(['rev-parse', '--show-toplevel']).trim();
    process.chdir(root);
    if (process.argv[2] === 'pre-commit') await preCommit(root);
    else if (process.argv[2] === 'pre-push') await prePush(root);
    else throw new Error('Expected pre-commit or pre-push.');
} catch (error) {
    console.error(`Quality hook: ${error.message}`);
    process.exitCode = 1;
}
