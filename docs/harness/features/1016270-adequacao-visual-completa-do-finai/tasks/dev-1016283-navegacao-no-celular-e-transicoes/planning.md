# Plano — DEV 1016283: navegação no celular e transições

## Identidade e decisão

- DEV [#1016283](https://redmine.remsoft.com.br/issues/1016283), pai [#1016270](https://redmine.remsoft.com.br/issues/1016270).
- Fontes: [task.md](task.md), [requisito](../../feature.md), [CT-004, CT-005 e CT-009](../../slices/condicoes-teste-r002.md).
- Preparado no pedido `$ralph 1016283`, apresentado na conversa e aprovado pelo usuário com “Aprovado”. Execução pelo Codex e commits da fase autorizados, sem push e sem alterar Redmine.

## Objetivo, estado atual e limites

Entregar a composição móvel FinAI até 767px: marca no topo e navegação principal fixa na base. Preservar os destinos e grupos autorizados e as ações de conta, perfil, notificações e saída nas áreas cliente, administração e suporte. Integrar as transições com os modos tablet e desktop já existentes.

Inspeção em HEAD `495f0e1`, árvore inicialmente limpa. As fornecedoras 1016281 e 1016282 estão integradas: `resources/views/layouts/app.blade.php` já possui workspace contornado a partir de 768px e `resources/js/components/sidebar.js` mantém a preferência desktop separada do modo tablet. O tablet usa lateral compacta de 768 a 1024px; desktop inicia em 1025px. Não há dependência funcional pendente dessas entregas observada no código.

O móvel ainda usa drawer lateral em `resources/views/livewire/sidebar.blade.php`, acionado pelo botão do cabeçalho em `resources/views/components/ui/navbar.blade.php`. O cabeçalho já contém notificações e conta. `x-ui.main` é o contêiner rolável; ainda não reserva espaço para barra inferior. O componente `app/Livewire/Sidebar.php` obtém os grupos filtrados pelo `SidebarMenuBuilder`; o partial `livewire/partials/sidebar-groups` e os componentes `x-ui.sidebar.*` apresentam esses grupos. Reutilizar essa fonte autorizada; não replicar regras de autorização na interface.

Há testes dedicados em `tests/Feature/Livewire/SidebarTest.php` e `tests/JavaScript/components/SidebarTest.mjs`. Os componentes compartilhados de modal, sidepage, dropdown, toast e notificações têm contratos próprios de foco, fechamento e empilhamento; conferir seus consumidores antes de ajustar geometria compartilhada.

Fora do escopo: novos destinos financeiros, dados demonstrativos, mudanças de autenticação/permissões, novas operações, reformulação interna das demais telas atribuída às filhas irmãs, alteração de dependências ou configuração global. Preservar a geometria desktop/tablet integrada, exceto ajustes estritamente necessários à transição móvel.

## Referência visual e estratégia

V01: `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`. A cascata final define navegação inferior com largura total, base 56px acrescida de `env(safe-area-inset-bottom,0px)`, ícones de 24px, alvos mínimos 44px, sem legenda visual, borda superior e superfície branca. As regras posteriores de tablet retiram a barra inferior a partir de 768px. Considerar a cascata completa, não o primeiro bloco móvel.

Usar o tema semântico `remsoft`, a marca existente e utilitários Tailwind 4, incluindo valores arbitrários para `calc()`/`env()`, conforme as regras do projeto. Manter nome acessível, foco visível e destino ativo. Adaptar a quantidade de itens aos destinos reais de cada área: acesso direto e menu complementar agrupado quando necessário, mantendo todos os destinos existentes sem obrigar o número de três itens do protótipo. Preservar os controles reais da conta no cabeçalho ou em composição acessível equivalente; não copiar a ocultação da conta do protótipo.

Reservar espaço no contêiner rolável e no alcance do foco; conferir notificações, menus, mensagens, diálogos e painéis para que a barra e a área segura não encubram ações. Tratar foco quando um controle desaparecer ao cruzar breakpoints e encerrar/reposicionar menus conforme o modo efetivo, preservando a preferência desktop. Manter o funcionamento por mouse, toque e teclado e os contratos de Escape/restauração de foco existentes.

Arquivos prováveis: `resources/views/layouts/app.blade.php`, `resources/views/livewire/sidebar.blade.php`, `resources/views/livewire/partials/sidebar-groups.blade.php`, `resources/views/components/ui/{navbar,main}.blade.php`, componentes `ui/sidebar`, `resources/js/components/sidebar.js` e seu teste dedicado. Ajustar componentes de overlays ou `resources/css/themes.css` somente se a integração demonstrar necessidade. Alterar PHP apenas se composição de dados for necessária, no responsável existente, sem transformação significativa no Blade. Caminhos prováveis não obrigam editar todos os arquivos.

Riscos observados: overflow de grupos numerosos; barra sobreposta ao final da rolagem ou a menus; foco deixado em navegação oculta ao redimensionar; preferência desktop afetando os outros modos; atualização `wire:navigate` deixando destino ativo incorreto; contratos compartilhados afetando as três áreas. A evidência de Validação deve cobrir esses riscos.

## Baseline e verificadores

Contexto: raiz desta worktree, PowerShell, PHP 8.4.27, Node 26.1.0, fora do processo executor. `composer show --direct` confirmou Laravel 13.40.0, Livewire 4.4.8, Pest 5.3.5, Agent 5.0.0 e Browser 5.2.0; package.json declara Tailwind 4, DaisyUI 5 e Playwright. Git Bash e Codex disponíveis. Consultada documentação versionada pelo Boost sobre breakpoints Tailwind 4 e integração Alpine/Livewire 4.

Comando obrigatório reproduzível para o gate Testes, executado também uma vez para observar o baseline:

```powershell
$ErrorActionPreference = 'Stop'
$taskTempDirectory = Join-Path $env:LOCALAPPDATA 'Temp/finai-1016283-quality'
New-Item -ItemType Directory -Path $taskTempDirectory -Force | Out-Null
$env:TEMP = $taskTempDirectory
$env:TMP = $taskTempDirectory
composer quality:check
exit $LASTEXITCODE
```

Resultado do baseline em 13/11/2026: `composer quality:check` concluído com código 0. Build Vite 8.3.6 e checagem CSS aprovados; 1.904 testes PHP / 6.709 asserções com TIA (fresh graph) aprovados; 269 testes JavaScript aprovados; auditorias Composer/npm sem vulnerabilidades; Pint, PHPStan (zero erros) e Rector dry-run (zero erros e zero arquivos alterados) aprovados. Nenhum impedimento operacional observado com o contexto TEMP/TMP exclusivo. Não houve verificação visual/interativa neste planejamento; ela pertence à entrega e à Validação da fase.

O agregado obrigatório contém build, checagem CSS, Pest paralelo com `--tia` e `phpunit-ci.xml`, JavaScript, auditorias Composer/npm, Pint, PHPStan e Rector dry-run. Não substituir o comando por subconjunto. Identificar resultados TIA como tais, sem alegar execução integral sem cache.

Antes da primeira edição no Dev, executar somente `npm run build`, menor conferência de capacidade já prevista. O agregado e a suíte completa ficam no gate Testes, depois de implementação e revisão. Se alterar PHP, executar `vendor/bin/pint --dirty --format agent`. Para testes afetados, seguir `--tia` e a estrutura dedicada ao responsável. Alterações puramente visuais não exigem testes permanentes; lógica relevante exige regressão significativa no teste dedicado, após ler testing-best-practices. Não criar suíte permanente de browser.

Aprendizados operacionais das fornecedoras: cache compartilhado pode apontar stubs para outra worktree; TEMP/TMP exclusivos do próprio processo verificador evitam essa condição sem apagar caches. Pint paralelo já atingiu timeout interno de 120s em execução anterior; isso não autoriza remover o verificador nem atribuir causa sem investigação. Pest Agent requer aspas preservadas pelo shell; usar a invocação documentada e investigar a passagem de argumentos se necessário. Arquivos ignorados de evidências não entram nos campos `file=` do relatório Dev, que devem conter somente fontes/testes alterados e rastreáveis da fase; capturas são referenciadas no resumo. Não repetir condições problemáticas sem ação fundamentada.

## Fase 1 — Navegação móvel integrada nas três áreas

### Dev

1. Ler regras aplicáveis e skills Tailwind, componentes UI, Livewire e Pest Agent; conferir Git e executar o build mínimo no próprio processo antes da primeira edição. Preservar trabalho preexistente. Não repetir o agregado como condição para implementar.
2. Substituir a apresentação móvel atual pela marca no topo e barra inferior, até 767px, conforme V01: largura total, 56px mais área segura, ícones 24px, alvos mínimos 44px, sem legendas visuais, nomes acessíveis, foco e estado ativo.
3. Preservar todos os grupos/destinos autorizados nas áreas cliente/administração/suporte, adaptando menus numerosos sem criar destinos futuros. Manter conta, perfil, notificações e saída alcançáveis e funcionais.
4. Integrar espaço reservado, rolagem, foco e empilhamento de menus/notificações/diálogos/painéis/mensagens. Preservar os contratos existentes de acessibilidade e operações, inclusive com conteúdo longo e área segura inferior.
5. Integrar transições 767/768 e 1024/1025 após recolher a lateral desktop, com menus abertos e fechados, preservando ações, foco e preferência desktop. A barra inferior desaparece a partir de 768px; tablet e desktop mantêm a composição já entregue.
6. Produzir evidências funcionais e visuais com Pest Agent/Browser já instalados e dados isolados de teste, sem persistir usuários no banco da aplicação nem iniciar servidor de desenvolvimento. Usar Herd e o mecanismo de testes existente. Guardar capturas/roteiros úteis em caminho ignorado, por exemplo `storage/app/1016283-evidence`, com reprodução identificada no resumo. Evidências não integram o manifesto de commit.

### Validação — outro processo, somente leitura

- Comparar a composição com a cascata final de V01: marca, proporções, espaçamento, cores semânticas, borda/sombra, altura base/área segura, ícones, alvos, ausência de legenda visual, foco e destino ativo. Inspecionar capturas e dimensões computadas; screenshot isolado não prova fidelidade ou interação.
- Conferir as três áreas em 360×800, 390×844, 430×932 e 600×960: percorrer destinos e grupos, conta, perfil, notificações e saída; exercer teclado e mouse/toque, Escape e restauração de foco. Conferir recusa/ausência de destinos sem autorização e estado ativo após navegar.
- Rolar páginas longas até o fim, focar os últimos controles e abrir menus, notificações, diálogos e painéis existentes. Comprovar conteúdo, feedback e ações livres da barra e da área segura; incluir texto longo e grupos numerosos. Conferir área segura por emulação/capacidade disponível e geometria calculada, sem declarar área segura comprovada somente porque existe `env()` no código.
- Conferir a integração em 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, além das fronteiras 767/768 e 1024/1025 nas três áreas, com menus abertos/fechados e lateral desktop previamente recolhida. Sem barra inferior nas faixas maiores, perda de ações/foco ou rolagem horizontal da página.
- Conferir estados atuais aplicáveis da navegação e feedback: normal, hover, foco, ativo, carregamento, desabilitado, vazio, sucesso/erro e confirmação/cancelamento quando presentes. Não inventar estados sem aplicação ou modificar dados, operações, validações e permissões para demonstrá-los. Sem mensagens de armazenamento local ou assistente simulado.
- Revisar escopo, contratos compartilhados, qualidade e regressões relevantes. Evidência coletável ausente e defeitos retornam ao Dev como `rejected`; `blocked` exige dependência externa impeditiva demonstrada. Revisor não edita a implementação.

### Testes

Após Validação aprovada, executar o bloco PowerShell obrigatório completo acima, com TEMP/TMP exclusivos e propagação de falhas, exigindo código 0. Preservar verificadores e hooks. Uma correção retorna a Dev, Validação e Testes antes de Commit. Investigar falhas de forma proporcional, distinguindo defeito, invocação inconclusiva e dependência externa.

### Commit

Entrega coerente: `feat: adequa navegação móvel e transições do FinAI (#1016283)`. Após Validação e Testes aprovados, incluir somente arquivos da fase e resumo consolidado neste plano com entrega, evidências, verificações e revisor/resultado. Sem capturas/temporários, trabalho alheio, push ou alteração do Redmine.

## Execução autorizada após aprovação

Usar uma única execução de `.agents/skills/plan-issue/ralph.sh`, backend Codex, preservando modelo e sandbox configurados no CLI; revisor somente leitura. Git Bash sem login, raiz desta worktree, plano real e bloco completo acima em `--test-command`, com `--test-shell powershell --timeout-seconds 1800`. O prazo é finito por processo e deve comportar os verificadores internos; uma falha não autoriza ampliar permissões/configuração global.

Acompanhar o mesmo processo com leituras incrementais e esperas de até 60s; confirmar início somente após `RALPH_STARTED` e commits somente após `RALPH_COMMIT`. Em interrupção, conferir Git, código, plano e relatórios pertinentes, preservando trabalho e evidências; não apagar locks/estado nem iniciar cópia paralela.

## Interrupção e recuperação operacional — run.0ucvqrW6

A primeira execução chegou à segunda Validação, aprovada. A implementação e as evidências complementares foram revisadas: 87 capturas, 1.389 asserções de navegador relatadas, incluindo nove resoluções, 48 transições, percursos por teclado e toque e inset simulado de 34px. O índice `storage/app/1016283-evidence/results.json` registra reprodução e limitações. A simulação não comprova área segura em hardware físico. As evidências ignoradas permanecem preservadas; não refazer essa coleta extensa sem necessidade decorrente de mudança ou achado novo.

O gate Testes executou o agregado obrigatório e falhou no PHPStan com cinco erros em `app/Livewire/Sidebar.php:39–40`: acesso à propriedade computada `$this->groups` não reconhecido pela análise e consequentes erros de inferência de `collect`/`flatMap`. Build, checagem CSS, testes PHP/JavaScript, auditorias e Pint precederam essa falha; Rector não foi executado nessa rodada. A aprovação da revisão não substitui o agregado pendente. Corrigir a causa da tipagem no Dev sem supressões, executar verificações afetadas e retornar a Validação e ao agregado completo.

No retorno ao Dev, o Codex recusou o prompt antes de trabalhar: `input is not valid UTF-8`. A inspeção estrita confirmou que ambos os logs originais de Testes são UTF-8 válidos, mas `5-prompt.md` contém bytes de continuação `9C 94` no início do trecho de diagnóstico. O `tail -c 12000` do executor cortou o símbolo de aprovação dos testes JavaScript no meio do caractere. Não foi falha de permissões ou codificação da aplicação. O processo encerrou com `RALPH_FINISHED: exit_code=1 fase=1 gate=Dev`, sem commit; HEAD permaneceu `495f0e1`.

Correção operacional local: cópia do executor original em `<git-dir>/remsoft-ralph/ralph-utf8.sh`, com uma única substituição no diagnóstico de falhas de Testes: `tail -c 12000 "$stdout_file" "$stderr_file"` por `tail -n 80 "$stdout_file" "$stderr_file"`. O recorte passa a preservar linhas UTF-8 completas. Nenhum gate, comando de testes, aprovação, manifesto, hook, permissão ou configuração global foi alterado; a skill instalada permanece intacta. A continuação usa essa cópia com os mesmos argumentos e timeout de 1800s.

Os 11 arquivos de fontes/testes da entrega, sem trabalho alheio ou staged preexistente, foram preservados no stash `473a71bae949516cf351992440e1db1ed816effc`, mensagem `ralph 1016283 entrega preservada run.0ucvqrW6`. A árvore foi conferida: resta somente este plano não rastreado. Não apagar nem fazer pop do stash; ele preserva a entrega anterior.

Na nova execução, o Dev deve fazer o build mínimo previsto e recuperar a entrega no próprio gate com `git diff --binary 473a71bae949516cf351992440e1db1ed816effc^1 473a71bae949516cf351992440e1db1ed816effc | git apply` no Git Bash, sem `--index` e sem alterar HEAD. Conferir os 11 caminhos recuperados, corrigir os erros PHPStan descritos e verificar o comportamento afetado. Reutilizar evidências suficientes, observando quais fontes mudaram após a coleta; uma correção apenas da forma de acesso tipada não exige repetir toda a matriz se o comportamento permanecer equivalente. Nova Validação independente e agregado completo continuam obrigatórios antes do Commit. Não incluir o plano ou os arquivos ignorados no manifesto `file=` do Dev.


### Resultado Ralph — Navegação móvel integrada nas três áreas

- Entrega: Entrega recuperada em 11 arquivos; tipagem computada corrigida sem supressões. Build, Pint, PHPStan focalizado, 5 testes PHP (32 asserções) e 10 JavaScript passaram. Evidências em storage/app/1016283-evidence/results.json reutilizadas: fontes idênticas exceto PHPDoc. Aguarda revisão independente e agregado obrigatório.
- Validação: outro processo codex, revisão 2, aprovada para a versão testada.
- Testes: verificadores aprovados; relatórios privados da execução, fase 1.
