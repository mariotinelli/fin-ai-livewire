# Plano — DEV 1016285: perfil e notificações

## Identidade e decisão

- DEV [#1016285](https://redmine.remsoft.com.br/issues/1016285), pai [#1016270](https://redmine.remsoft.com.br/issues/1016270).
- Fontes: [task.md](task.md), [requisito](../../feature.md), [CT-010, CT-011 e CT-016](../../slices/condicoes-teste-r002.md).
- Preparado no pedido `$ralph 1016285`, apresentado na conversa e aprovado pelo usuário com “aprovado”. Execução pelo Codex e commits desta entrega autorizados, sem push e sem alterar Redmine.

## Objetivo, estado atual e limites

Aplicar a linguagem e a composição FinAI ao perfil, formulários de dados pessoais e senha, painel lateral e histórico de notificações nas áreas existentes de cliente, administração e suporte. Preservar dados, validações, titularidade, permissões, carregamento, ordenação, grupos/lotes e ações atuais. Não criar exclusão funcional de conta, operações financeiras, temas adicionais ou dados demonstrativos.

Inspeção em HEAD `8279ab5`, árvore inicialmente limpa. As entregas 1016281, 1016282 e 1016283 estão integradas: tema semântico em `resources/css/themes.css`, marca FinAI e navegação responsiva existentes. Reutilizar essas capacidades, sem reconstruí-las. As jornadas de acesso 1016284 também estão integradas.

`routes/{customer,admin,support}.php` compartilham `Auth/Profile/EditProfile` em `meu-perfil` e `Notifications/History` em `notificacoes`. Rotas confirmadas com `php artisan route:list --name=profile` e `--name=notifications`; não usar `--except-vendor` para esse inventário, pois ele omite as rotas Livewire. `/perfil` redireciona à área do usuário.

O perfil Livewire usa título isolado, containers aninhados e cartões sem borda/sombra, com formulários de nome/e-mail e senha. As classes `UpdateProfileInformationForm` e `UpdatePasswordForm` já delegam às Actions próprias, validam, mostram toast e preservam efeitos de segurança. A alteração visual deve manter bindings, métodos, nomes dos campos, restrições e feedbacks. A apresentação legada `resources/views/profile/edit.blade.php` e seus três partials não tem consumidor roteado encontrado; preservá-la e adequá-la sem conectar novos destinos. Seus campos readonly e o trecho apenas textual de exclusão não devem virar operações.

O painel `resources/views/livewire/notifications.blade.php` usa `x-ui.sidepage`, paginação, abertura/carregamento via Alpine, falha com repetição e ações de leitura/limpeza. O histórico usa lotes com cursor e `HistoryBatch`; os itens compartilhados exibem título, ícone opcional, data, descrição, detalhes, link opcional, estado de leitura e exclusão. A composição atual tem recuos fixos e linhas flexíveis vulneráveis a texto longo. Preservar IDs, eventos, contratos Alpine/Livewire, paginação, distinção entre vista e lida, confirmações/cancelamentos e atualização do contador. Não reinterpretar a semântica de limpeza ou exclusão nesta entrega.

Há testes dedicados de perfil/senha, Actions, notificações, histórico/lotes, isolamento e JavaScript do painel/central. Reutilizar a cobertura comportamental existente. Estilo e composição não exigem testes permanentes novos; se uma mudança de lógica for indispensável ao aceite, justificar, cobrir no teste dedicado do responsável e ler suas regras antes de editar.

## Referência e estratégia visual

V01: `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`, considerando a cascata final. Inspecionados os tokens e a composição do documento: fundo #F5F7F8, superfície branca, texto #172622, secundário #52615C, verde #145C46, borda #D6DFDB, destaque suave #E4F0E9, sucesso #146345 e erro #A12B36; Georgia para títulos de destaque e system-ui no corpo; controles de raio 8px e painéis 16px, alvos de pelo menos 44px, espaçamentos em escala de 4/8/16/24/32px. Adaptar essa linguagem às telas sem mockup próprio, sem importar mensagens sobre armazenamento local ou assistente simulado.

Recompor a hierarquia das páginas, seções e ações; usar superfícies, contornos, espaços e tipografia coerentes. Dar aos formulários largura legível e ações alcançáveis; reorganizar cabeçalhos e conteúdo das notificações, permitir quebra de textos extensos e manter áreas de rolagem internas e rodapé utilizáveis. Preferir ajustes locais com Tailwind 4 e tokens existentes. Reutilizar APIs reais de `x-ui.*`; verificar implementação local antes de usar props, slots e atributos. Mudança compartilhada exige inspeção dos consumidores e prova de ausência de regressão fora destas telas.

Arquivos prováveis: `resources/views/livewire/auth/profile/edit-profile.blade.php`, seus dois partials, `resources/views/profile/edit.blade.php` e seus três partials, `resources/views/livewire/notifications.blade.php`, `resources/views/livewire/notifications/{history,history-batch}.blade.php` e `resources/views/components/notifications/{item,actions,empty,loading}.blade.php`. Não é obrigatório alterar todos. Sem alteração de dependências, rotas ou classes PHP por conveniência visual. Ler regras de qualquer caminho adicional antes de editar. Preservar UTF-8 e conferir texto e rótulos acessíveis no diff e nos arquivos gravados.

Riscos: textos sem espaços alargando a página; botões de leitura/limpeza comprimidos; foco ou ações finais encobertos pela navegação/barra de ambiente; painel com rolagem e rodapé concorrentes; perda de atributos usados pelo JavaScript; regressões nos consumidores compartilhados e apresentação legada.

## Baseline e verificadores

Contexto: raiz desta worktree, PowerShell, PHP 8.4.27 e Node 26.1.0, fora do executor. `composer show --direct` confirmou Laravel 13.40.0, Livewire 4.4.8, Pest 5.3.5, Agent 5.0.0 e Browser 5.2.0. package.json usa Tailwind 4, DaisyUI 5, Vite 8 e Playwright. Git Bash e Codex disponíveis. Consultada documentação versionada pelo Boost e lidas skills de Livewire, Tailwind, componentes UI, Pest Agent e práticas de testes.

Comando obrigatório do gate Testes e do baseline, propagando qualquer falha do agregado:

```powershell
$ErrorActionPreference = 'Stop'
$taskTempDirectory = Join-Path $env:LOCALAPPDATA 'Temp/finai-1016285-quality'
New-Item -ItemType Directory -Path $taskTempDirectory -Force | Out-Null
$env:TEMP = $taskTempDirectory
$env:TMP = $taskTempDirectory
composer quality:check
exit $LASTEXITCODE
```

Baseline em 14/11/2026: `composer quality:check` concluído com código 0. Build, checagem CSS, suíte PHP com 1.905 testes e 6.717 asserções (TIA fresh graph), 271 testes JavaScript, auditorias Composer/npm sem vulnerabilidades, Pint, PHPStan sem erros e Rector dry-run sem erros ou arquivos alterados aprovados. Nenhum impedimento observado nesse contexto. Não foi realizada verificação visual/interativa neste planejamento: ela pertence ao Dev e à Validação da entrega. O resultado fora do executor não comprova compatibilidade dentro do processo Dev.

O agregado inclui build, checagem CSS, Pest paralelo com `--tia` e `phpunit-ci.xml`, testes JavaScript, auditorias Composer/npm, Pint em checagem, PHPStan e Rector dry-run. Todos são obrigatórios, sem substituições. Identificar resultados reaproveitados pelo TIA. Antes da primeira edição no Dev, executar somente `npm run build`, menor conferência aplicável já prevista; agregado e suíte completa ficam após implementação e revisão. Se editar PHP, executar `vendor/bin/pint --dirty --format agent` e os testes afetados.

Aprendizados operacionais da fornecedora 1016284: TEMP/TMP próprios evitam referências de stubs de outra worktree sem apagar caches; Pint paralelo já atingiu timeout interno de 120s, exigindo investigação proporcional sem retirar o verificador. O executor instalado ainda usa dois recortes `tail -c 12000`, que já cortaram caractere UTF-8 no diagnóstico. Antes da execução, preparar cópia local do script no diretório Git, trocando somente esses recortes por `tail -n 80`; conferir o diff e preservar o restante. Ajuste operacional sem mudança de escopo, gates, testes, hooks ou permissões. Não iniciar nas mesmas condições problemáticas conhecidas.

## Fase 1 — Identidade FinAI no perfil e nas notificações

### Dev

1. Conferir Git, regras aplicáveis, skills e consumidores; executar o build mínimo antes de editar e preservar trabalho preexistente.
2. Recompor perfil e formulários pessoais/senha nas três áreas, mantendo seus dados, validações, efeitos e feedbacks. Adequar a apresentação legada sem habilitar campos readonly ou criar exclusão de conta.
3. Adaptar painel, histórico/lotes e itens de notificações à linguagem V01. Preservar dados próprios, contadores, ordenação, grupos existentes, marcação de vista/lida, ações individuais/coletivas, paginação, carregamento incremental, links, confirmação/cancelamento e fechamento/restauração de foco.
4. Tratar estados existentes aplicáveis: normal, hover, foco, ativo, desabilitado, vazio, texto longo, processamento, erro com tentativa novamente, sucesso, confirmação e cancelamento. Não inventar estados ou funcionalidades para demonstrar conclusão.
5. Coletar evidência visual/interativa com Pest Agent/Browser instalados, usando dados isolados e fakes, sem persistir usuários no banco da aplicação, enviar comunicações reais, iniciar servidor ou instalar dependências implicitamente. Usar Herd e mecanismos existentes. Capturas úteis ficam em caminho ignorado, referenciadas no resumo; não entram no manifesto `file=`. Não criar suíte permanente de browser.

### Validação — outro processo, somente leitura

- Conferir task.md integralmente, R1/R2/R7/R8, CA01/CA02/CA06/CA08/CA09, CT-010/CT-011 e CT-016 nas superfícies desta entrega. Comparar com V01 cores, tipografia, hierarquia, proporções, superfícies, bordas, raios, sombras, ritmo e estados; screenshots isolados não comprovam interação ou fidelidade.
- Conferir perfil, painel e histórico nas áreas disponíveis em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080. Conteúdo legível, sem rolagem horizontal da página e com todas as ações alcançáveis, incluindo dados extensos e transição entre faixas da navegação existente. Verificar foco e conteúdo junto à barra inferior e à barra de ambiente.
- Exercitar teclado/mouse: rótulos associados, ordem e indicação de foco, abertura, fechamento, Escape e restauração de foco do painel, rolagem até ações finais e estados pendentes/desabilitados. Não permitir que menus encubram campos, mensagens ou ações.
- Conferir envio válido/inválido de dados pessoais e senha, erro da senha atual, confirmação da nova senha, processamento e feedback de sucesso. Preservar titularidade, efeitos da mudança de e-mail/senha e restrições atuais. A apresentação legada mantém seus limites, sem nova operação de exclusão.
- Conferir notificações vazias, curtas/extensas e com mais de uma página/lote; ícones/detalhes/links quando presentes; leitura e visualização; carregamento, falha/repetição; exclusão individual; limpeza confirmada e cancelada; atualização de contadores e fim do histórico. Preservar isolamento entre usuários, áreas e permissões, sem alterar regras para coletar evidência.
- Conferir consumidores quando houver mudança compartilhada. Sem novos destinos financeiros, dados fictícios ou mensagens de armazenamento local/assistente simulado. Conferir Unicode inclusive nos rótulos acessíveis.
- Defeito ou evidência ainda coletável pelo Dev exige `rejected` com ação concreta. `blocked` exige dependência externa demonstrada. O revisor não edita a entrega.

### Testes

Após Validação aprovada, executar integralmente o bloco PowerShell obrigatório e exigir código 0. Preservar todos os verificadores do agregado e testes existentes; não adicionar testes apenas de estilo. Mudança de comportamento exige cobertura significativa no arquivo dedicado do responsável e execução afetada com `--tia`. Investigar falhas proporcionalmente; correção da implementação retorna a Dev, Validação e Testes antes do Commit.

### Commit

Entrega coerente: `feat: adequa perfil e notificações à identidade FinAI (#1016285)`. Depois da revisão independente e dos verificadores aprovados, incluir somente fontes/testes da fase e resumo consolidado neste plano, com mudanças, evidências, verificações e resultado do revisor. Sem temporários, capturas, trabalho alheio, push ou alteração do Redmine.

## Execução após aprovação

Iniciar uma única execução do `ralph.sh` com o ajuste local UTF-8 acima, backend Codex, modelo e sandbox configurados no CLI preservados; revisor somente leitura. Git Bash sem login, raiz desta worktree, caminho real deste plano, bloco completo em `--test-command`, `--test-shell powershell --timeout-seconds 1800`. Limites finitos e compatíveis com os verificadores; falha não autoriza ampliar permissões ou mudar configuração global.

Acompanhar o mesmo processo em leituras de até 60s. Início somente após `RALPH_STARTED`, commit após `RALPH_COMMIT` e conclusão após `RALPH_FINISHED`, conferindo Git e resumo no plano. Não implementar em paralelo nem substituir o executor por gates manuais. Em interrupção, preservar trabalho e investigar Git, plano e relatórios pertinentes antes de nova execução.

## Interrupção e recuperação operacional

A primeira execução implementou 12 templates e teve revisão independente aprovada após complementar evidências de interação, responsividade, erro e confirmação. As evidências locais estão em `tests/Browser/Screenshots/1016285-evidence/evidence-index.json`; permanecem ignoradas e não fazem parte da entrega versionada. O gate Testes falhou no Pint porque dois scripts temporários PHP nessa pasta também foram examinados. O Dev formatou os auxiliares, mas incluiu indevidamente seus caminhos ignorados no manifesto `file=`; o executor interrompeu com `Arquivo declarado não pertence às mudanças da fase`, código 1, sem commit. As alterações da aplicação foram preservadas. A revisão anterior não substitui o agregado completo ainda pendente.

Durante o acompanhamento, o usuário solicitou e aprovou uma lista fixa de exclusões equivalente aos diretórios relevantes do `.gitignore` no Pint, Rector e PHPStan. Esse ajuste de ferramentas será registrado separadamente, preservando os verificadores e as regras existentes. A lista é explícita, sem sincronização automática de futuras alterações do `.gitignore`.

Para uma nova execução, separar reversivelmente apenas os 12 templates desta entrega em um stash identificado e preservado. O Dev deve executar o build mínimo e reaplicar esse stash pelo hash registrado abaixo, sem `--index`, antes de conferir a entrega existente e completar o trabalho. Isso permite que o executor reconheça as alterações como pertencentes à nova execução, mantendo a proteção de outros arquivos e o índice original. Não descartar o stash, não recriar as evidências nem repetir a implementação já concluída sem defeito demonstrado. O revisor confere novamente a versão reaplicada, e o script executa o mesmo agregado completo antes de qualquer commit da entrega. Scripts e capturas ignorados nunca entram em `file=`; apenas os arquivos versionáveis efetivamente alterados na fase.

- Ajuste das ferramentas concluído no commit `004f843`: lista fixa no Pint, Rector e PHPStan; os três verificadores passaram, inclusive com PHP inválido temporário em `app/Livewire/Exclude` para comprovar sua exclusão. O arquivo de conferência já foi removido.
- Entrega visual preservada no stash `2b454c1e29d040c4a248de8514d535c32c99963d`, mensagem `ralph-1016285-recuperacao-templates`, contendo exatamente os 12 templates (143 inserções, 83 remoções). Reaplicar no Dev com `git stash apply 2b454c1e29d040c4a248de8514d535c32c99963d`, após o build mínimo e antes de encerrar a implementação. Não usar pop ou drop. O plano aprovado permanece no diretório canônico, e as evidências ignoradas continuam disponíveis.


### Resultado Ralph — Identidade FinAI no perfil e nas notificações

- Entrega: Recuperados e conferidos os 12 templates do stash aprovado, preservando Unicode, contratos e evidências em tests/Browser/Screenshots/1016285-evidence/evidence-index.json. Build, Pint, 80 testes PHP com 323 asserções e 8 testes JavaScript passaram; TIA executou seleção parcial diretamente. Pronto para revisão independente e agregado do gate Testes.
- Validação: outro processo codex, revisão 2, aprovada para a versão testada.
- Testes: verificadores aprovados; relatórios privados da execução, fase 1.
