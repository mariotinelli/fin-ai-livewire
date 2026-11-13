# Plano — DEV 1016282: layout desktop e tablet

## Identidade e decisão

- DEV [#1016282](https://redmine.remsoft.com.br/issues/1016282), pai [#1016270](https://redmine.remsoft.com.br/issues/1016270).
- Fontes: [task.md](task.md), [requisito](../../feature.md), [condições CT-002, CT-003, CT-005 e CT-009](../../slices/condicoes-teste-r002.md).
- Proposta apresentada no pedido `$ralph 1016282` e aprovada pelo usuário com “aprovado”. Execução e commit da fase autorizados, sem push e sem alterar Redmine.

## Objetivo, limites e estado inspecionado

Reorganizar cabeçalho, lateral e superfície de trabalho das áreas de cliente, administração e suporte a partir de 768px conforme o design fornecido. Preservar destinos, grupos, permissões, conta, perfil, notificações, saída e resultados das operações existentes.

A identidade FinAI da DEV 1016281 já está integrada em HEAD `1653dbc` (merge da PR #1). A árvore estava limpa na inspeção inicial. O registro histórico de interrupção no plano da fornecedora foi seguido por resultado de Validação e Testes aprovados; a capacidade está presente em código, sem necessidade de refazer essa entrega.

O layout compartilhado `resources/views/layouts/app.blade.php` mantém `asideOpen` em localStorage e `mobileAsideOpen`. Hoje a navbar fica acima da lateral e do conteúdo; `x-ui.main` calcula largura e deslocamento pela lateral com variante `lg`, e a sidebar usa modo desktop a partir de 1024px. Assim, tablets abaixo de 1024px ainda recebem menu móvel. Em `resources/css/themes.css`, as larguras atuais são 20rem aberta e 5.563rem recolhida. O conteúdo não possui o invólucro contornado exigido.

`app/Livewire/Sidebar.php` delega o menu ao `SidebarMenuBuilder`; `resources/views/livewire/partials/sidebar-groups.blade.php` e `x-ui.sidebar.{group,link,links}` apresentam os destinos filtrados. `resources/js/components/sidebar.js` preserva grupos e rolagem por contexto e revela o item ativo. Os testes existentes incluem `tests/Feature/Livewire/SidebarTest.php` e `tests/JavaScript/components/SidebarTest.mjs`. Preservar essa responsabilidade e seus consumidores, sem duplicar regras de autorização na apresentação.

Fora do escopo: nova barra inferior de celular (DEV 1016283), reformulação interna das telas de acesso/perfil/gestão/suporte atribuída às demais filhas, novos destinos financeiros, dados demonstrativos, autenticação, mudanças de dependências ou permissões. Nas larguras inferiores a 768px, preservar a navegação existente e conferir integração sem exigir antecipar a composição da filha móvel.

## Referência visual e estratégia

Fonte V01: `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`. Inspecionada a cascata completa até as regras finais: o bloco tablet sobrescreve a navegação inferior anterior; o último bloco a partir de 768px define entorno branco, lateral transparente sem borda e workspace com fundo suave, contorno 1px, raio 16px, margem 8px no topo/direita/base e cabeçalho transparente. Comparar também marca, proporções, espaços e estados, sem copiar os destinos fictícios nem ocultar as ações reais da conta como o protótipo faz.

Usar componentes Blade/Alpine existentes e tema semântico `remsoft`. Separar o estado efetivo compacto do tablet da preferência de recolhimento desktop: de 768 a 1024px inclusive, lateral de 72px mais área segura e alvos de 48px; desktop a partir de 1025px com recolhimento funcional. Ajustar contêineres e rolagem para altura reduzida, sem esconder grupos, itens ou menus da conta em overflow. Manter a marca compacta no tablet e o destino ativo com nome acessível mesmo quando o texto visual estiver oculto.

Arquivos prováveis: `resources/views/layouts/app.blade.php`, `resources/views/components/ui/{navbar,main,application-logo}.blade.php`, `resources/views/components/ui/sidebar/*.blade.php`, `resources/views/livewire/sidebar.blade.php`, seu partial de grupos, `resources/css/{themes,app}.css` e `resources/js/components/sidebar.js` se necessário. Conferir consumidores antes de alterar contratos compartilhados; caminhos prováveis não obrigam editar todos os arquivos. Backend de menu e permissões devem permanecer com seus responsáveis atuais.

Riscos: o breakpoint `lg` padrão inclui 1024px, que precisa continuar tablet; preferências salvas e grupos fechados não podem esconder destinos compactos; overflow da lateral não pode cortar dropdowns ou foco; alturas devem considerar a barra de ambiente existente; classes compartilhadas afetam as três áreas e a integração móvel. Tratar isso na implementação e na evidência de Validação.

## Baseline observado e verificadores

Contexto: raiz desta worktree, PowerShell, PHP 8.4.27 e Node 26.1.0, fora do executor. Versões confirmadas com `composer show --direct`: Laravel 13.40.0, Livewire 4.4.8, Pest 5.3.5, Pest Agent 5.0.0, Browser 5.2.0. package.json contém Tailwind 4, DaisyUI 5 e Playwright. Git Bash e Codex estão disponíveis no PATH.

Comando obrigatório, também executado uma vez para observar o baseline:

```powershell
composer quality:check
```

Resultado do baseline em 13/11/2026: build Vite 8.3.6, formato CSS, 1.904 testes PHP / 6.709 asserções (TIA), 267 testes JavaScript, auditorias sem vulnerabilidades, Pint e PHPStan aprovados. O agregado terminou com código 1 no Rector: três erros de stub apontando para a worktree `1016281`, em vez de `1016282`. Nenhuma comparação visual/interação foi executada neste baseline.

Investigação e ajuste operacional: `rector --dry-run --clear-cache` repetiu os três erros. Foram encontrados caminhos `1016281` em arquivos do cache compartilhado `%TEMP%/phpstan/cache/nette.configurator`. Repetido somente o verificador afetado com TEMP/TMP exclusivos do processo em `%LOCALAPPDATA%/Temp/finai-1016282-quality`: Rector aprovado, código 0, zero erros e zero arquivos alterados. Não foi apagado cache compartilhado, modificada configuração global ou alterado verificador. O agregado não foi repetido integralmente após esse ajuste; todos os seus passos têm resultado aprovado, sendo o Rector na repetição corrigida. O gate Testes executará o agregado inteiro com o contexto corrigido.

Comando obrigatório reproduzível para Testes, PowerShell (a preparação da pasta deve falhar explicitamente se indisponível):

```powershell
$ErrorActionPreference = 'Stop'
$taskTempDirectory = Join-Path $env:LOCALAPPDATA 'Temp/finai-1016282-quality'
New-Item -ItemType Directory -Path $taskTempDirectory -Force | Out-Null
$env:TEMP = $taskTempDirectory
$env:TMP = $taskTempDirectory
composer quality:check
exit $LASTEXITCODE
```

O agregado real inclui build, checagem CSS, Pest paralelo com `--tia` e `phpunit-ci.xml`, JavaScript, auditorias Composer/npm, Pint, PHPStan e Rector dry-run. Não substituir por verificadores reduzidos. Resultados TIA devem ser identificados como tal, sem alegar execução integral sem cache.

Antes da primeira edição no Dev, executar somente `npm run build`, menor conferência de capacidade já prevista; agregado e suíte completa pertencem a Testes após Validação. Se alterar PHP, executar `vendor/bin/pint --dirty --format agent`. Alterações somente de apresentação dispensam novos testes permanentes. Se mudar lógica relevante, ler a skill testing-best-practices e acrescentar somente regressões significativas no arquivo dedicado ao responsável, seguindo testes vizinhos e `--tia`; lógica JavaScript deve usar o teste vizinho pertinente. Não criar suíte permanente de browser.

## Fase 1 — Composição desktop e tablet nas três áreas

### Dev

1. Conferir plano, Git e regras aplicáveis antes de editar; carregar skills Tailwind, componentes UI e Livewire, além de buscar documentação versionada pelo Boost quando necessário. Executar a conferência mínima acima no próprio processo.
2. Reorganizar entorno, lateral, cabeçalho e workspace conforme a cascata final da referência, mantendo marca e tokens FinAI integrados. A partir de 768px aplicar contorno 1px, raio 16px, margem 8px e cabeçalho transparente.
3. Implementar lateral tablet de 768 a 1024px, 72px mais área segura, marca compacta e alvos mínimos de 48px, com conteúdo ao lado e sem barra inferior. Preservar grupos/destinos e acesso com altura reduzida.
4. Em 1025px ou mais, manter lateral desktop aberta/recolhida, indicação ativa e acesso a todos os destinos autorizados em ambos os estados. Preservar preferência desktop sem contaminar a faixa tablet nem o menu móvel.
5. Preservar conta, perfil, notificações e saída nas três áreas com mouse/teclado, rótulos, foco visível, estados aplicáveis e contratos existentes. Não acrescentar destinos financeiros ou mensagens de simulação.
6. Carregar pest-plugin-agent antes de produzir evidência visual e funcional com browser instalado, dados isolados e usuários de teste. Não persistir usuários no banco da aplicação nem iniciar servidor de desenvolvimento: respeitar Herd e o mecanismo de testes existente. Guardar capturas/registros úteis em caminho ignorado e registrar como reproduzir/verificar. Investigar falhas de invocação antes de atribuir impedimento externo; não instalar dependências nem ampliar permissões implicitamente.

### Validação — outro processo, somente leitura

- Comparar geometria, marca, entorno, lateral, cabeçalho e workspace com as regras finais de `.app`, `.sidebar`, `.workspace` e `.topbar` do design. Conferir dimensões computadas, alinhamentos, proporções, bordas e estados, além das capturas.
- Conferir as áreas cliente, administração e suporte, com seus destinos reais e permissões: desktop aberto/recolhido a partir de 1025px; tablet entre 768 e 1024px com rail de 72px mais área segura, alvos mínimos de 48px, marca compacta e sem barra inferior. Incluir altura reduzida e conteúdo longo para provar alcance dos últimos controles.
- Matriz de integração: 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080. Sem rolagem horizontal da página ou ações encobertas. Celular mantém a composição existente, cuja nova navegação pertence à DEV 1016283.
- Conferir fronteiras 767/768 e 1024/1025 após recolhimento desktop, com menus abertos/fechados: tablet não herda estado que esconda destinos, e a faixa móvel existente continua acessível. A validação conjunta final da nova navegação móvel permanece na DEV 1016283.
- Provar navegação por mouse e teclado, foco visível, item ativo, acesso a conta/perfil/notificações/saída e preservação de grupos e destinos autorizados nas três áreas, incluindo recusa dos não autorizados. Conferir estados atuais aplicáveis de normal, hover, ativo, desabilitado, carregamento e feedback; justificar estados sem aplicação nos controles abrangidos. Capturas isoladas não provam interação nem permissões.
- Conferir que as alterações compartilhadas preservam operações existentes e os contratos de menus/overlays, sem ampliar a tarefa para outras filhas. Ausência de evidência coletável ou defeito da entrega deve voltar ao Dev como ação requerida (`rejected`), sem aprovação baseada somente em código. `blocked` exige dependência externa impeditiva demonstrada.

### Testes

Depois de Validação aprovada, executar `composer quality:check` no PowerShell com o contexto TEMP/TMP exclusivo e propagação de falha definidos acima, exigindo conclusão com código 0. Preservar todos os verificadores e hooks. Qualquer correção de implementação retorna ao Dev e passa novamente por Validação e Testes. Distinguir falha funcional, problema de invocação e dependência externa, com investigação proporcional e sem enfraquecer aceite.

### Commit

Uma entrega coerente: `feat: adequa layout desktop e tablet do FinAI (#1016282)`. Somente após Validação e Testes aprovados, incluir alterações da fase e resumo consolidado neste plano com entrega, evidências, verificações e revisor/resultado. Sem artefatos temporários, trabalho alheio, push ou alteração do Redmine.

## Execução e acompanhamento

Após aprovação, usar uma única execução de `.agents/skills/plan-issue/ralph.sh`, backend Codex, modelo e sandbox configurados no CLI; revisor somente leitura. Git Bash sem perfil de login, preservando runtime disponível; passar ao `--test-command` o bloco PowerShell obrigatório completo acima, com `--test-shell powershell --timeout-seconds 1800`. O ajuste de TEMP/TMP pertence ao processo que executa o verificador; não basta aplicá-lo apenas no shell externo do orquestrador. Ler saída incremental com esperas de até 60 segundos. Não iniciar cópia paralela.

Aprendizados operacionais do plano fornecedor: uma chamada Pest Agent perdeu aspas no PowerShell e precisou de correção; usar a invocação documentada com aspas externas simples no shell compatível, sem repetir a chamada problemática. Evidência incompleta é ação do Dev e não bloqueio externo do revisor. Em interrupção, conferir código/Git/plano antes de nova chamada e preservar alterações protegidas pelo executor; não remover locks/estado nem contornar gates para forçar avanço.

## Interrupção e recuperação operacional — execução run.zcgukLY7

A primeira execução encerrou com `RALPH_FINISHED: exit_code=1 fase=1 gate=Dev`, antes da terceira Validação. O erro `Arquivo declarado não pertence às mudanças da fase` ocorreu porque o relatório Dev incluiu arquivos ignorados de `storage/app/1016282-evidence` no campo `file=`, além dos 12 arquivos reais da entrega. O executor aceita nesse manifesto somente alterações rastreáveis da fase; capturas e roteiros temporários devem ser referenciados no resumo, sem entrar no manifesto de commit. Nenhum commit ou gate Testes foi executado; HEAD permaneceu `1653dbc`.

As duas revisões anteriores solicitaram corrigir rótulos/espacamento e completar evidências de navegação recolhida, transições com overlay aberto e saída por mouse/teclado em todas as faixas. O Dev corrigiu a apresentação e relatou build, oito testes JavaScript e Pint aprovados; a última reprodução Pest Agent passou com 1.824 asserções, incluindo 24 navegações desktop, seis travessias móvel/tablet e 24 saídas isoladas nas três áreas. Isso ainda precisa de Validação independente; não é aprovação da fase. Evidências preservadas em `storage/app/1016282-evidence`, com `README.md`, `reproduce.ps1`, `results.json` e roteiros auxiliares.

Após conferir Git, plano e o relatório final, os 12 arquivos de implementação/testes foram preservados no stash específico `e99ace36fc6574f2e1f8be2e4c8bd23d08bf0c70`, mensagem `ralph 1016282 entrega preservada run.zcgukLY7`. A árvore voltou ao HEAD somente nesses caminhos, ficando apenas este plano como arquivo não rastreado. Não havia trabalho alheio nem alterações staged. As evidências ignoradas permaneceram intactas. Não apagar nem fazer pop desse stash: ele preserva a entrega anterior durante a recuperação.

Na nova execução autorizada, o Dev deve realizar a conferência mínima prevista e recuperar a implementação dentro do próprio gate, com `git diff --binary e99ace36fc6574f2e1f8be2e4c8bd23d08bf0c70^1 e99ace36fc6574f2e1f8be2e4c8bd23d08bf0c70 | git apply` no Git Bash (sem `--index`, sem alterar HEAD). Conferir que os 12 caminhos recuperados coincidem com a entrega preservada, consultar os achados e as evidências finais e encaminhar para nova Validação independente; repetir verificações específicas se a conferência revelar necessidade. O agregado completo permanece exclusivamente no gate Testes, após aprovação da revisão.

No relatório do Dev, `file=` deve listar somente os 12 arquivos de fontes/testes alterados exibidos por `git diff --name-only`, excluindo este plano e todos os arquivos ignorados. Os roteiros e capturas são evidências referenciáveis, não arquivos da entrega para commit. A nova execução preserva escopo, aceite, verificadores, permissões e aprovação já concedida; apenas separa a entrega interrompida e corrige o manifesto inválido. Nova Validação, Testes completos e Commit continuam obrigatórios.

### Continuação solicitada após perda da sessão — run.7GjeJKrG

Na segunda execução, os 12 arquivos foram recuperados e uma Validação independente aprovou a entrega. O gate `composer quality:check` falhou no Pint paralelo por timeout interno de 120 segundos; os 269 testes JavaScript e auditorias passaram. O Dev retornou para investigação e relatou repetição isolada do comando original de formatação aprovada no mesmo PowerShell/TEMP/TMP, sem modificar configuração ou fontes. Não se deve tratar esse resultado isolado como aprovação do agregado.

Ao pedido do usuário para continuar, a sessão de acompanhamento retornou `Unknown process id`; os logs terminaram no Dev sem relatório final, e a inspeção de processos não encontrou executor Ralph ativo. Não foi recebido `RALPH_FINISHED` dessa execução. HEAD continua `1653dbc`, sem commit da fase. A comparação Git confirmou que todos os 12 arquivos continuam exatamente iguais ao stash `e99ace36fc6574f2e1f8be2e4c8bd23d08bf0c70`. Foram novamente preservados em stash específico, sem descartar a cópia anterior ou as evidências.

A continuação usa o mesmo procedimento de recuperação documentado acima, no próprio Dev, e o mesmo comando completo aprovado. Priorizar a conferência enxuta e reutilizar evidências suficientes dos arquivos idênticos; não repetir a extensa coleta visual sem necessidade. Nova Validação e agregado completo continuam obrigatórios antes de Commit. A repetição do verificador tem evidência nova: o Pint original passou na investigação isolada; não alterar suas regras nem aceitar somente um subconjunto dos verificadores. Sem mudança de escopo, dependências, permissões, modelo ou aprovação.


### Resultado Ralph — Composição desktop e tablet nas três áreas

- Entrega: Recuperados os 12 arquivos, idênticos ao stash preservado; build, oito testes JavaScript e Pint aprovados. Evidências anteriores reutilizadas em storage/app/1016282-evidence conforme plano. Pendente Validação independente e agregado completo no gate Testes; sem commit ou alteração do planning.md.
- Validação: outro processo codex, revisão 2, aprovada para a versão testada.
- Testes: verificadores aprovados; relatórios privados da execução, fase 1.
