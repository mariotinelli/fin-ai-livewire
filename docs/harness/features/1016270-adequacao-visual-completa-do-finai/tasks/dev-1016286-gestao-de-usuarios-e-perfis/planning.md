# Plano — DEV 1016286: gestão de usuários e perfis

## Identidade e decisão

- DEV [#1016286](https://redmine.remsoft.com.br/issues/1016286), pai [#1016270](https://redmine.remsoft.com.br/issues/1016270).
- Fontes: [task.md](task.md), [requisito](../../feature.md), [CT-012, CT-013 e CT-016](../../slices/condicoes-teste-r002.md).
- Preparado no pedido `$ralph 1016286`, apresentado na conversa e aprovado pelo usuário com “aprovado” em 16/11/2026. Execução Ralph com Codex e commits da fase autorizados, sem push ou alteração de Redmine.

## Objetivo e limites

Adequar listas, formulários, permissões, confirmações e componentes compartilhados de gestão à identidade FinAI, mantendo informações e operações existentes. Preservar busca, filtros, ordenação, paginação, criação, edição, desativação/restauração e convite onde disponíveis, validações e autorização no servidor. Não criar exclusão de perfis ou outras operações ausentes, modificar papéis/permissões, criar dados financeiros, temas ou destinos novos. A composição específica de suporte pertence à DEV 1016287; manter seus contratos ao adaptar componentes comuns.

## Estado inspecionado e estratégia

HEAD inicial `17de199`, árvore limpa. Identidade, navegação desktop/tablet/móvel, jornadas de acesso e perfil/notificações estão integrados. Reutilizar `resources/css/themes.css`, marca, estrutura e navegação existentes; não reconstruir as fornecedoras 1016281–1016283.

As classes em `app/Livewire/Admin/Management/{Users,Roles}` têm templates dedicados e testes próprios em `tests/Feature/Livewire/Admin/Management/{Users,Roles}`. Usuários têm Index/Create/Update/Delete/Restore/ResendInvitation; perfis têm Index/Create/Update. Modais existentes possuem seus componentes e autorizações. A mudança pretendida é apresentação/composição, preservando bindings, eventos, IDs necessários, métodos, endpoints relacionais e validação. Não alterar classes PHP por conveniência visual.

`Users/Index` usa `filterDraft` separado de `filters`, aplicação explícita e validação/autorização; lista inclui ativos/inativos e ações condicionais. Preservar esse contrato, limpar/aplicar filtros e descarte ao fechar. `Roles/Index` tem pesquisa, ordenação, contagem de usuários e descrições truncadas com tooltip; manter acesso ao conteúdo completo e ações à direita. Estados vazios já distinguem ausência de registros, busca sem resultados e filtros inválidos em usuários.

O `x-ui.table` atual tem busca com `min-w-64` fora de draft-filters, margens negativas na região rolável, cabeçalho de controles pouco flexível e paginação compartilhada. Formulários de usuários mantêm e-mail/perfil lado a lado; permissões de perfis usam quatro colunas a partir de lg, mesmo dentro de modal. Adequar essas composições ao espaço real disponível e ao design, sem perder informações ou ações. Conferir nomes/e-mails/descrições extensos, filtros abertos, tooltips e mensagens.

Consumidores diretos de tabela: gestão, `support/system-error-alerts/index` e `support/artisan-commands/history`. `x-ui.sidepage` é consumido por notificações. Modais, paginação, campos e botões também são compartilhados. Inspecionar todos os consumidores de qualquer componente alterado; preservar slots, props, eventos, foco, bloqueios durante salvamento, carregamento e feedback isolado. Adaptar tabela e painéis comuns quando necessário para esta entrega, sem reformular telas de suporte ou desfazer perfil/notificações. Não editar componentes já adequados sem necessidade demonstrada.

Arquivos prováveis: `resources/views/livewire/admin/management/users/*.blade.php`, `roles/*.blade.php`, `resources/views/components/ui/roles/permissions/group/*.blade.php`, `ui/table.blade.php`, `ui/table/*.blade.php`, `ui/pagination.blade.php` e, conforme inspeção, `ui/{modal,sidepage,card}.blade.php`. Não é obrigatório alterar todos. Ler regras aplicáveis antes de ampliar caminhos. Se houver mudança comportamental indispensável, justificar e cobrir no teste dedicado do responsável, seguindo as skills e convenções; estilo/layout puros não exigem testes novos. Não criar suíte permanente de browser.

## Referência visual e riscos

V01: `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`; inspecionados tokens, componentes e regras finais. Aplicar às telas sem mockup específico a linguagem de R2/R3: fundo #F5F7F8, superfície branca, texto #172622, secundário #52615C, verde #145C46, borda #D6DFDB, destaque #E4F0E9, positivo #146345 e negativo #A12B36; Georgia nos títulos de destaque, system-ui no corpo, raio 8px em controles e 16px em painéis, espaçamento 4/8/16/24/32px e alvos utilizáveis conforme referência. Usar tokens semânticos do tema remsoft e utilitários Tailwind 4. Conferir APIs reais de x-ui na implementação local.

Recompor hierarquia, superfícies, ritmo e distribuição dos controles; não limitar a entrega a recolorir. Tabelas largas podem rolar internamente, com colunas e ações alcançáveis por teclado; a página não pode rolar horizontalmente. Painéis e diálogos mantêm ações finais alcançáveis, rótulos associados e foco visível/restaurado. Preservar UTF-8, conferindo textos e rótulos no arquivo e no diff.

Riscos principais: busca/filtros alargando a página; paginação comprimida; permissões densas em modal; textos longos encobrindo controles; tooltips recortados; ações finais sob navegação/barra de ambiente; regressões em suporte/notificações após alteração compartilhada. Evidência deve cobrir esses riscos sem criar dados ou operações de produção.

## Baseline e verificadores

Contexto: raiz desta worktree, PowerShell, PHP 8.4.27 e Node 26.1.0, fora do executor. `composer show --direct` confirmou Laravel 13.40.0, Livewire 4.4.8, Pest 5.3.5, Agent 5.0.0 e Browser 5.2.0; package.json declara Tailwind 4, DaisyUI 5, Vite 8 e Playwright. Git Bash e Codex disponíveis. Consultada documentação versionada via Boost; lidas skills Livewire, Tailwind, componentes UI, Pest Agent e práticas de testes.

Baseline em 14/11/2026 com `composer quality:check` em PowerShell, concluído com código 0: build e checagem CSS aprovados; 1.905 testes PHP e 6.717 asserções aprovados (TIA fresh graph, 159.116ms); 271 testes JavaScript aprovados; auditorias Composer/npm sem vulnerabilidades; Pint aprovado; PHPStan sem erros; Rector dry-run aprovado, sem arquivos alterados ou erros. Nenhum impedimento observado nesse contexto. Não houve verificação visual/interativa no planejamento; pertence ao Dev e à Validação.

Comando obrigatório do gate Testes, preservando todos os passos do agregado e propagando sua falha:

```powershell
$ErrorActionPreference = 'Stop'
$taskTempDirectory = Join-Path $env:LOCALAPPDATA 'Temp/finai-1016286-quality'
New-Item -ItemType Directory -Path $taskTempDirectory -Force | Out-Null
$env:TEMP = $taskTempDirectory
$env:TMP = $taskTempDirectory
composer quality:check
exit $LASTEXITCODE
```

O agregado inclui build, Prettier CSS, Pest paralelo com `--tia` e `phpunit-ci.xml`, testes JavaScript, auditorias Composer/npm, Pint em checagem, PHPStan e Rector dry-run. Todos permanecem obrigatórios. Reportar execução real e resultados reaproveitados por TIA separadamente. Antes da primeira edição no Dev executar somente `npm run build`, menor conferência aplicável já prevista. Suíte completa e agregado pertencem ao gate Testes após revisão. Se editar PHP, executar `vendor/bin/pint --dirty --format agent` e testes afetados com `--tia`.

Aprendizados operacionais registrados na fornecedora 1016285: TEMP/TMP próprios evitam stubs de outra worktree sem apagar caches; Pint paralelo já atingiu limite interno de 120s, exigindo investigação proporcional, sem retirar verificador. O executor instalado mantém dois recortes `tail -c 12000`, que já cortaram Unicode em diagnóstico. Antes de executar, preparar cópia local do script no diretório Git, trocando somente esses dois recortes por `tail -n 80`, conferir o diff e preservar o restante. Ajuste operacional sem alteração de escopo, gates, hooks, testes ou permissões. Não apagar locks/estado para avançar nem repetir condições problemáticas sem ação fundamentada.

## Fase 1 — Identidade FinAI na gestão e componentes compartilhados

### Dev

1. Conferir instruções, Git e consumidores no próprio processo; executar o build mínimo antes de editar. Preservar alterações preexistentes.
2. Recompor listas de usuários/perfis, controles de busca/filtros, tabelas, paginação, estados vazios e ações conforme V01. Preservar consultas, ordenação, rascunho/aplicação de filtros e acesso ao conteúdo.
3. Adequar criação/edição de usuários e perfis, grupos de permissões e confirmações de desativação/restauração/reenvio de convite. Manter campos, modelos de permissões, seleção individual/grupo/todas, validações, confirmações/cancelamentos e efeitos autorizados.
4. Adaptar componentes comuns necessários com contratos estáveis, conferindo suporte e notificações quando afetados. Aplicar estados existentes normal, hover, foco, ativo, desabilitado, carregamento, vazio, erro e sucesso.
5. Coletar evidências visuais/interativas com Pest Agent/Browser instalados, dados isolados e fakes; não persistir usuários no banco da aplicação, enviar convites reais, iniciar servidor ou instalar dependências implicitamente. Usar Herd e mecanismos existentes. Capturas úteis ficam em pasta ignorada em `tests/Browser/Screenshots/`, referenciada no resumo, fora dos arquivos do commit.

### Validação — outro processo, somente leitura

- Conferir critérios integrais de task.md, R1/R2/R7/R8 e CA01/CA02/CA06/CA08/CA09 na gestão, CT-012/CT-013/CT-016. Comparar V01 com composição, cores, tipografia, hierarquia, proporções, ritmo, bordas, raios, sombras e estados; screenshot isolado não prova fidelidade/interação.
- Conferir listas, formulários, permissões, confirmações e painéis aplicáveis em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080. Tabelas largas rolam internamente; nomes/e-mails/descrições extensos, filtros e paginação permanecem legíveis e utilizáveis, sem overflow da página ou ações encobertas. Conferir integração nas transições 767/768 e 1024/1025, inclusive lateral recolhida.
- Exercitar listas vazias, longas e buscas sem resultado, busca/limpeza, filtros de perfil/status em usuários, descarte de rascunho, aplicação/limpeza e paginação/ordenação existentes. Não criar filtros em perfis inexistentes atualmente.
- Conferir criação/edição com entradas válidas e inválidas, escolha de perfil via pesquisa, modelo e seleção de permissões em perfis; desativação/restauração/reenvio de convite onde disponíveis; confirmação/cancelamento, processamento e feedback. Ações sem permissão continuam recusadas no servidor e privilégios não são ampliados.
- Conferir rótulos, nomes acessíveis, teclado, foco visível/contido/restaurado, Escape e bloqueios durante operações; alcançar controles após rolar tabelas/modais/painéis. Verificar Unicode e mensagens.
- Inspecionar consumidores compartilhados afetados, inclusive alertas, histórico de comandos e notificações, preservando suas operações e contratos sem executar comandos perigosos ou enviar mensagens reais. Sem reconstrução de suporte, dados financeiros, simulações ou temas adicionais.
- Defeitos ou evidências ainda coletáveis pelo Dev recebem `rejected` com ação concreta. `blocked` exige dependência externa impeditiva demonstrada. O revisor não edita a entrega.

### Testes

Após Validação aprovada, executar integralmente o bloco PowerShell obrigatório, exigir código 0 e resultado concluído. Preservar verificadores e testes existentes. Reutilizar testes dedicados de gestão, Actions/policies e consumidores compartilhados; alterações comportamentais exigem cobertura significativa e execução afetada. Correção da implementação volta a Dev, Validação e Testes antes de Commit. Investigar problemas operacionais dentro da autorização, com prazos finitos compatíveis, sem enfraquecer aceite.

### Commit

Entrega coerente: `feat: adequa gestão de usuários e perfis à identidade FinAI (#1016286)`. Após revisão independente e verificadores aprovados, incluir somente fontes/testes da fase e resumo consolidado neste plano, com entrega, evidências, verificações e resultado da revisão. Não incluir temporários, capturas ou trabalho alheio; sem push e sem alteração de Redmine.

## Execução após aprovação

Iniciar uma única execução do ralph.sh com o ajuste local Unicode descrito, backend Codex e modelo/sandbox configurados no CLI preservados; revisor somente leitura. Git Bash sem login, raiz desta worktree, caminho real deste plano, bloco completo em `--test-command`, `--test-shell powershell --timeout-seconds 1800`. O baseline fora do executor não comprova compatibilidade dentro do Dev; falha não autoriza ampliar permissões ou mudar configuração global. Acompanhar o mesmo processo até encerramento.

## Recuperação operacional — 16/11/2026

A primeira execução `run.71NxxoWY` implementou 20 templates (105 inserções, 98 remoções), sem alterar classes de negócio. Dev relatou build, Pint, 244 testes com 1.020 asserções, matriz responsiva e interações aprovados. A Validação rejeitou duas capturas feitas antes da abertura dos modais. O segundo Dev corrigiu essas evidências e verificou 29 asserções, mas incluiu os dois PNGs ignorados no relatório `file=`. O executor encerrou com código 1 em Dev: `Arquivo declarado não pertence às mudanças da fase.` Não houve nova Validação, gate Testes ou Commit após a correção. Não há aprovação final da entrega.

Após conferir processo encerrado, Git, plano, diff e relatórios, os 20 templates foram preservados no stash `5e902caa6dcae175bb5270e32201499d1938b626`, mensagem `ralph-1016286-recuperacao-templates`. Na nova execução, após o build mínimo e antes de encerrar o Dev, reaplicar com `git stash apply 5e902caa6dcae175bb5270e32201499d1938b626`. Não usar pop/drop, não refazer a implementação do zero e não commitar manualmente. O stash não contém o plano ou capturas. A árvore ficou somente com este plano não rastreado, preservado no caminho canônico. Escopo e aprovação mantidos.

As duas capturas corrigidas estão em `tests/Browser/Screenshots/finai-1016286-{users-form-360,invitation}.png` e têm cópia preservada no diretório Git, subdiretório `ralph-1016286-evidence-backup`. A coleta posterior do Pest limpou as outras capturas da execução anterior; não alegar que as 53 imagens continuam disponíveis. Para novas evidências, preservar capturas após cada chamada em diretório ignorado fora de `tests/Browser/Screenshots`, por exemplo `storage/framework/testing/finai-1016286-evidence`, conferindo `git check-ignore` antes. Relatar capturas no resumo, NUNCA em `file=`: esse campo aceita somente os templates/fontes/testes efetivamente alterados e não ignorados, sem planning.md. Não alterar guardas do executor para aceitar imagens ignoradas.

Problemas locais já resolvidos nas verificações: `public/hot` direciona para assets de desenvolvimento que falham ao inicializar Alpine no navegador de teste. Usar o build apenas no processo de teste via configuração Vite local à aplicação de teste, sem remover o arquivo hot, alterar servidor ou configuração global. Preservar aspas do snippet no transporte ao Pest Agent; usar Git Bash ou argumento estruturado quando PowerShell consumir aspas. Reproduzir no teste a configuração de sessões usada pela suíte para desativação de usuários; usar idioma pt-BR no processo de teste. Esperar assertivamente o modal e seus campos visíveis antes de capturar, cancelar ou pressionar Escape. A evidência visual pode precisar ser recomposta com dados isolados e fakes; nova Validação e o agregado completo continuam obrigatórios antes de Commit.


### Resultado Ralph — Identidade FinAI na gestão e componentes compartilhados

- Entrega: Evidências complementadas: matriz completa, permissões expandidas, tooltips por teclado, rolagem, foco restaurado e paginação; 689 asserções passaram. Preservadas 156 capturas, sete mosaicos, logs e hashes em storage/framework/testing/finai-1016286-evidence/review.json. Build e diff íntegros; 20 templates preservados. Aguarda revisão independente e gate Testes.
- Validação: outro processo codex, revisão 4, aprovada para a versão testada.
- Testes: verificadores aprovados; relatórios privados da execução, fase 1.
