# Plano — DEV 1016284: jornadas de acesso

## Identidade e decisão

- DEV [#1016284](https://redmine.remsoft.com.br/issues/1016284), pai [#1016270](https://redmine.remsoft.com.br/issues/1016270).
- Fontes: [task.md](task.md), [requisito](../../feature.md), [CT-006 a CT-009](../../slices/condicoes-teste-r002.md).
- Preparado no pedido `$ralph 1016284`, apresentado na conversa e aprovado pelo usuário com “aprovado”. Execução pelo Codex e commits da entrega autorizados, sem push e sem alterar Redmine.

## Objetivo, estado atual e limites

Aplicar a identidade FinAI às telas existentes de login de cliente, administração e suporte, cadastro, recuperação e redefinição de senha, verificação e reenvio de e-mail e confirmação de senha. Preservar campos, validações, dados informados, comunicações, URLs, tokens, restrições por área e resultados das operações. Não implementar comportamentos da F02, novas operações financeiras, temas adicionais ou demonstrações.

Inspeção em HEAD `a4b7529`, árvore inicialmente limpa. A identidade fornecida pela DEV 1016281 está integrada: `resources/css/themes.css` contém o tema semântico `remsoft`, paleta FinAI, fontes system-ui e Georgia (`font-display`), foco e sombra de painel. `resources/views/components/ui/application-logo.blade.php` já apresenta FinAI. As entregas de navegação 1016282/1016283 também estão integradas; esta DEV não reformula a navegação autenticada.

`resources/views/layouts/guest.blade.php` é compartilhado pelos controllers e componentes Livewire de autenticação. Ainda usa divisão com grande painel verde, logotipo ampliado, variações `split`/`centered`, fontes externas Geist/Sora e cartões com sombras genéricas. A marca estar atualizada não comprova adequação da composição. `resources/views/livewire/auth/{login,forgot-password,reset-password}.blade.php` têm cabeçalhos e formulários comuns. `resources/views/auth/{register,verify-email,confirm-password}.blade.php` têm composição menos uniforme e ações que precisam se adaptar ao celular. Todos integram esta entrega.

`app/Livewire/Auth/BaseLogin.php` controla autenticação, limites de tentativas e tipos permitidos; os três logins especializados reutilizam a view. `ForgotPassword` preserva contexto e resposta sem enumeração de contas; `ResetPassword` preserva token e e-mail bloqueado. `routes/auth.php` contém os destinos existentes, inclusive registro, confirmação e verificação. Essas regras são contexto a preservar, não arquivos obrigatórios de alteração.

Testes existentes por responsável cobrem BaseLogin, os três logins, ForgotPassword, ResetPassword e controllers de cadastro, confirmação, verificação e reenvio, além de notificações e destinos pretendidos. Reutilizar essa cobertura. Não criar testes permanentes para simples classes visuais nem suíte de browser. Se surgir mudança de lógica necessária dentro do escopo, seguir testing-best-practices e atualizar somente a regressão significativa no teste dedicado ao responsável, com estrutura espelhada e `--tia`.

## Referência visual e estratégia

V01: `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`, considerando a cascata final. O protótipo não oferece tela individual de login: adaptar sua linguagem aos formulários reais, sem inventar regras de produto. Fundo #F5F7F8, superfície branca, texto #172622, secundário #52615C, verde #145C46, borda #D6DFDB, destaque suave #E4F0E9, sucesso #146345 e erro #A12B36. Títulos de destaque Georgia, corpo system-ui, controles com raio 8px, painéis com raio 16px e sombra da referência; botões da referência têm altura mínima 44px. Comparar hierarquia, ritmo, proporções, foco e estados, além das cores.

Recompor o layout de acesso com marca proporcional, superfície de formulário clara e hierarquia consistente, com espaçamento responsivo e rolagem vertical que mantenha todas as ações acessíveis. Usar Tailwind 4 e tokens semânticos atuais; reutilizar `x-ui.input`, password, checkbox, button e feedback existentes. Preservar variantes e consumidores do layout; conferir efeitos de qualquer alteração compartilhada fora do acesso antes de editar. Evitar alterar componentes globais se a composição local resolver a necessidade.

Arquivos prováveis: `resources/views/layouts/guest.blade.php`, as seis views de autenticação citadas e, somente se necessário, componentes UI consumidos por elas. A fonte do logotipo e o tema já existem. Não editar PHP, rotas ou dependências por conveniência visual. Ler regras adicionais de qualquer caminho que realmente entrar no escopo antes da edição. Preservar UTF-8 e conferir acentos no arquivo e no diff, inclusive rótulos acessíveis.

Riscos a conferir: cabeçalhos sem hierarquia; ações longas no reenvio de e-mail; formulário de cadastro maior que a altura do celular; barra de ambiente reduzindo espaço útil; erros ampliando cartões; foco ou conteúdo cortado; dados perdidos por alteração de bindings; regressão fora do acesso por alteração de componentes compartilhados.

## Baseline e verificadores

Contexto: raiz desta worktree, PowerShell, PHP 8.4.27, Node 26.1.0, fora do executor. `composer show --direct` confirmou Laravel 13.40.0, Livewire 4.4.8, Pest 5.3.5, Agent 5.0.0 e Browser 5.2.0. package.json usa Tailwind 4, DaisyUI 5, Playwright e Vite 8. Git Bash e Codex disponíveis. Consultada documentação pelo Boost sobre formulários, validação e estados de processamento do Livewire 4. Lidas skills Livewire, Tailwind, componentes UI, Pest Agent e práticas de testes.

Comando obrigatório para Testes e para observar o baseline, propagando o código do agregado:

```powershell
$ErrorActionPreference = 'Stop'
$taskTempDirectory = Join-Path $env:LOCALAPPDATA 'Temp/finai-1016284-quality'
New-Item -ItemType Directory -Path $taskTempDirectory -Force | Out-Null
$env:TEMP = $taskTempDirectory
$env:TMP = $taskTempDirectory
composer quality:check
exit $LASTEXITCODE
```

Baseline em 14/11/2026: `composer quality:check` concluído com código 0. Build, checagem CSS, 1.905 testes PHP / 6.717 asserções com TIA fresh graph, 271 testes JavaScript, auditorias Composer/npm sem vulnerabilidades, Pint, PHPStan sem erros e Rector dry-run sem erros ou arquivos alterados aprovados. Nenhum impedimento observado nesse contexto. Não houve verificação visual/interativa neste planejamento; ela integra a entrega e a Validação.

O agregado real inclui build, checagem CSS, Pest paralelo com `--tia` e `phpunit-ci.xml`, testes JavaScript, auditorias, Pint em checagem, PHPStan e Rector dry-run. Preservar todos os verificadores e identificar resultados TIA como tais. Antes da primeira edição no Dev, executar somente `npm run build`, menor conferência aplicável já prevista; agregado e suíte completa pertencem ao gate Testes após a revisão. Se modificar PHP, executar `vendor/bin/pint --dirty --format agent`.

Aprendizados operacionais da fornecedora 1016283: usar TEMP/TMP exclusivos evita referências de stubs de outra worktree sem apagar caches; Pint paralelo já atingiu timeout interno de 120s, exigindo investigação proporcional, sem retirar o verificador. O executor instalado ainda contém `tail -c 12000` no diagnóstico de testes, que já cortou caractere UTF-8 e impediu retorno ao Dev. Antes de iniciar, preparar cópia local no diretório Git, substituindo os dois recortes de `tail -c 12000` por `tail -n 80` para preservar linhas UTF-8 completas; manter o restante idêntico. Isso é ajuste operacional, sem alterar gates, aprovação, testes, hooks ou permissões. Não repetir as condições problemáticas conhecidas.

## Fase 1 — Identidade FinAI nas jornadas de acesso existentes

### Dev

1. Conferir Git, regras aplicáveis, skills e consumidores; executar o build mínimo antes de editar. Preservar trabalho preexistente.
2. Recompor o layout guest e uniformizar marca, títulos, campos, botões, ajuda e links nas oito apresentações: três logins, cadastro, recuperação, redefinição, verificação/reenvio e confirmação. Respeitar a linguagem V01 também onde não há mockup individual.
3. Preservar nomes, bindings, métodos de envio, CSRF, contexto de recuperação, tokens, autocomplete, campos bloqueados e obrigatórios, mensagens e destinos atuais. Não alterar autenticação, permissões, regras de senha ou destinatários das comunicações.
4. Adequar os estados existentes aplicáveis: normal, hover, foco, ativo, desabilitado, processamento, vazio, erro, sucesso, confirmação e cancelamento. Não criar estados artificiais nem afirmar funcionalidades financeiras futuras, conta local ou assistente simulado.
5. Coletar evidência visual e funcional com Pest Agent/Browser instalados, dados isolados de teste e fakes adequados, sem persistir usuários no banco da aplicação, disparar e-mails reais ou iniciar servidor. Usar Herd e o mecanismo existente. Capturas úteis ficam em caminho ignorado e são referenciadas no resumo, sem integrar o manifesto `file=` do Dev. Não instalar dependências implicitamente.

### Validação — outro processo, somente leitura

- Conferir todas as telas e estados abrangidos contra V01 e R1/R2/R8, CA01/CA02/CA06/CA08/CA09, CT-006 a CT-009. Comparar marca, fonte, cores, hierarquia, geometria, bordas, raios, sombras, espaçamentos e foco. Captura isolada não prova fidelidade nem interação.
- Conferir cada apresentação em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080. Sem corte, encobrimento ou rolagem horizontal da página, incluindo erros, mensagens longas e formulário de cadastro. Conferir rolagem e controles finais com a barra de ambiente existente.
- Exercitar teclado e mouse: ordem de foco, rótulos associados, foco visível, ações e links alcançáveis, preservação dos dados não sigilosos após erro e bindings existentes. Conferir processamento e desabilitação dos controles correspondentes.
- Conferir envio válido/inválido nas jornadas e cobertura existente: cadastro e login preservam resultados e recusas por área; recuperação mantém contexto, retorno e mensagem não enumerável; redefinição preserva token/e-mail e erro de link inválido; verificação/reenvio mantém comunicação, feedback, limite e saída; confirmação preserva erro e destino pretendido. Usar evidência em dados de teste e fakes, sem exigir alteração de regras para demonstrar.
- Conferir consumidores se componentes compartilhados mudarem, preservando telas fora do acesso. Sem alteração de escopo, URLs, autenticação/permissões ou dependências.
- Defeitos e evidência ainda coletável retornam como `rejected`, com ações concretas. `blocked` exige dependência externa demonstrada. Revisor não edita a entrega.

### Testes

Após Validação aprovada, executar integralmente o bloco PowerShell obrigatório, exigindo código 0. Executar também testes afetados no Dev quando houver alteração de lógica, sem substituir o agregado. Investigar falhas proporcionalmente e corrigir invocação somente dentro da autorização existente. Correção da implementação volta a Dev, Validação e Testes antes do Commit.

### Commit

Entrega coerente: `feat: adequa jornadas de acesso à identidade FinAI (#1016284)`. Após revisão independente e verificadores aprovados, incluir somente fontes/testes da fase e resumo consolidado neste plano, com entrega, evidências, verificações e resultado do revisor. Sem temporários, capturas, trabalho alheio, push ou alteração do Redmine.

## Execução após aprovação

Uma execução do `ralph.sh` com ajuste UTF-8 local descrito acima, backend Codex, modelo e sandbox configurados no CLI preservados; revisor somente leitura. Git Bash sem login, raiz desta worktree, caminho real do plano, bloco completo em `--test-command`, `--test-shell powershell --timeout-seconds 1800`. Limites finitos e compatíveis com verificadores; falha não autoriza ampliar permissões nem configuração global.

Acompanhar o mesmo processo em leituras incrementais de até 60s. Confirmar início somente após `RALPH_STARTED`, commit após `RALPH_COMMIT` e conclusão após `RALPH_FINISHED`, conferindo Git e resumo no plano. Não iniciar cópia paralela nem implementar fora do executor. Em interrupção, preservar trabalho e investigar relatórios pertinentes antes de nova execução.


### Resultado Ralph — Identidade FinAI nas jornadas de acesso existentes

- Entrega: Corrigidos os espaçamentos exigidos pelo Rector no kernel temporário de evidências, preservando Unicode e verificadores. Build, Pint, Rector completo e diff check passaram. Aguardando revisão independente e nova execução do agregado no gate Testes.
- Validação: outro processo codex, revisão 8, aprovada para a versão testada.
- Testes: verificadores aprovados; relatórios privados da execução, fase 1.
