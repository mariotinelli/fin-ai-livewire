import assert from 'node:assert/strict';
import test from 'node:test';
import upload from '../../../resources/js/components/multiple-upload.js';
function setup(accept = 'application/pdf') {
    const component = upload('attachments', [], 5, 10240, accept, 'Anexos', accept);
    const events = [],
        pending = [];
    component.$refs = { input: { value: 'selected' } };
    component.$dispatch = (name, detail) => events.push({ name, detail });
    component.$wire = {
        get: () => null,
        set() {},
        removeUpload() {},
        upload: (...args) => pending.push(args),
        uploadMultiple: (...args) => pending.push(args),
        cancelUpload: () => pending[0][5](),
    };
    return { component, events, pending };
}
for (const [accept, type, valid] of [
    ['application/pdf', 'application/zip', false],
    ['application/pdf', 'application/pdf', true],
    ['image/png', 'image/jpeg', false],
    ['image/png', 'image/png', true],
    [' image/png, APPLICATION/PDF ', 'application/pdf', true],
    ['image/*', 'image/jpeg', true],
    ['image/*', 'application/pdf', false],
    ['image/*', '', false],
    ['image/*', 'image/', false],
    ['', '', false],
    ['*/*', '', true],
]) {
    test(`accept ${accept} validates ${type}: ${valid}`, () => {
        const { component } = setup(accept);
        assert.equal(Boolean(component.validateFileType({ name: 'file', type })), valid);
    });
}
test('uses KB and accepts the inclusive ten MB boundary', () => {
    const { component, events } = setup();
    assert.equal(component.validateFileSize({ name: 'file', size: 10485760 }), true);
    assert.equal(component.validateFileSize({ name: 'file', size: 10485761 }), false);
    assert.match(events.at(-1).detail.message, /10 MB/);
});
test('empty selection does not upload or clear feedback', () => {
    const { component, events, pending } = setup();
    component.addFiles([]);
    component.addFiles(undefined);
    assert.equal(pending.length, 0);
    assert.equal(events.length, 0);
});
for (const callback of [3, 5]) {
    test(`callback ${callback} frees previews and allows retry`, (t) => {
        const revoked = [];
        t.mock.method(URL, 'createObjectURL', () => 'blob:test');
        t.mock.method(URL, 'revokeObjectURL', (url) => revoked.push(url));
        const { component, events, pending } = setup();
        const file = new File(['pdf'], 'report.pdf', {
            type: 'application/pdf',
        });
        component.addFiles([file]);
        pending[0][callback]();
        assert.equal(component.uploading, false);
        assert.match(events.at(-1).detail.message, /Selecione novamente/);
        assert.deepEqual(revoked, ['blob:test']);
        component.addFiles([file]);
        assert.equal(pending.length, 2);
        assert.equal(component.$refs.input.value, '');
        component.destroy();
        assert.deepEqual(revoked, ['blob:test', 'blob:test']);
    });
}

test('rejects an invalid batch atomically without creating previews', (t) => {
    const create = t.mock.method(URL, 'createObjectURL');
    const { component, pending } = setup();
    component.addFiles([
        new File(['pdf'], 'good.pdf', { type: 'application/pdf' }),
        new File(['zip'], 'wrong.zip', { type: 'application/zip' }),
    ]);
    assert.equal(pending.length, 0);
    assert.equal(create.mock.callCount(), 0);
    assert.deepEqual(component.files, []);
});
test('revokes removed and destroyed local previews but preserves remote media URLs', (t) => {
    const revoked = [];
    t.mock.method(URL, 'createObjectURL', (file) => 'blob:' + file.name);
    t.mock.method(URL, 'revokeObjectURL', (url) => revoked.push(url));
    const { component, pending } = setup();
    component.oldFiles = [{ id: 1, name: 'saved.pdf', preview: 'https://example.test/saved.pdf' }];
    component.init();
    component.addFiles([new File(['pdf'], 'first.pdf', { type: 'application/pdf' })]);
    component.addFiles([new File(['pdf'], 'queued.pdf', { type: 'application/pdf' })]);
    component.removeFile(1);
    pending[0][2](['temporary-first']);
    component.destroy();
    assert.deepEqual(revoked, ['blob:queued.pdf', 'blob:first.pdf']);
});

test('hydrates old files, handles drops and exposes preview helpers', () => {
    const { component } = setup();
    component.oldFiles = [
        {
            id: 4,
            name: 'saved.pdf',
            size: 10,
            type: 'application/pdf',
            preview: 'https://example.test/saved.pdf',
        },
    ];
    const changes = [];
    component.$refs.input.dispatchEvent = (event) => changes.push(event.type);
    component.init();
    const dropped = [new File(['pdf'], 'saved.pdf')];
    component.handleDrop(dropped);
    assert.equal(component.oldFiles[0].progress, 100);
    assert.equal(component.$refs.input.files, dropped);
    assert.deepEqual(changes, ['change']);
    assert.ok(component.getPreviewMimeTypes('image').includes('svg'));
    assert.ok(component.getPreviewMimeTypes('video').includes('mp4'));
    assert.ok(component.getPreviewMimeTypes('document').includes('pdf'));
    assert.deepEqual(component.getPreviewMimeTypes('other'), []);
    assert.equal(component.getPreviewId('file', 'image', 2), 'file-image-preview-2');
});

test('validates capacity and drives queued, uploaded and old-file removals', (t) => {
    const revoked = [];
    t.mock.method(URL, 'createObjectURL', (file) => 'blob:' + file.name);
    t.mock.method(URL, 'revokeObjectURL', (url) => revoked.push(url));
    const { component, events, pending } = setup();
    component.maxFiles = 1;
    assert.equal(component.validateMaxFiles([{}, {}]), false);
    assert.match(events.at(-1).detail.message, /1 arquivos/);
    component.maxFiles = 5;
    const file = new File(['pdf'], 'first.pdf', { type: 'application/pdf' });
    component.addFiles([file]);
    pending[0][4]({ detail: { progress: 44.6 } });
    component.handleUploadProgress(44.6);
    assert.equal(component.files[0].progress, 45);
    component.removeFile(0);
    pending[0][2](['temporary-first']);
    assert.equal(component.files[0].removalRequested, true);
    component.$wire.removeUpload = (_model, _temporary, done) => done();
    component.files[0].removalRequested = false;
    component.removeFile(0);
    component.removeFile(99);
    component.discardFile('missing');
    component.oldFiles = [{ id: 9 }];
    component.$wire.dispatch = () => {};
    component.removeFile(0, true);
    component.maxFiles = 0;
    assert.equal(component.checkAllFilesIsValid([file]), false);
    assert.deepEqual(revoked, ['blob:first.pdf']);
});

test('covers empty queues, queued removal and completion races', (t) => {
    t.mock.method(URL, 'createObjectURL', (file) => 'blob:' + file.name);
    t.mock.method(URL, 'revokeObjectURL', () => {});
    const { component, pending } = setup();
    component.init();
    component.uploading = true;
    component.uploadPendingFiles();
    component.uploading = false;
    component.uploadPendingFiles();
    const first = new File(['pdf'], 'first.pdf', { type: 'application/pdf' });
    const second = new File(['pdf'], 'second.pdf', { type: 'application/pdf' });
    component.addFiles([first]);
    component.addFiles([second]);
    component.removeFile(1);
    component.removeFile(99);
    component.files[0].removalRequested = true;
    component.$wire.removeUpload = () => {};
    pending[0][2](['temporary-first']);
    assert.equal(component.files[0].status, 'uploaded');

    const mutation = setup().component;
    mutation.checkAllFilesIsValid = (files) => {
        files.splice(0);
        return true;
    };
    mutation.addFiles([first]);
    assert.deepEqual(mutation.files, []);
});

test('rejects excessive size through atomic batch validation', () => {
    const { component } = setup();
    assert.equal(component.checkAllFilesIsValid([{ name: 'large.pdf', type: 'application/pdf', size: 10485761 }]), false);
});

test('normalizes null persisted collections', () => {
    const component = upload('attachments', null, 5, 10240, '*/*', 'Anexos', 'Todos');
    component.init();
    assert.deepEqual(component.oldFiles, []);
});
