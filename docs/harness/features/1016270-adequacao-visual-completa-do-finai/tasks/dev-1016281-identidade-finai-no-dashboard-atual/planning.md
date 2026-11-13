# DEV 1016281 — Identidade FinAI no dashboard atual

## Identidade, fontes e decisão

- DEV [1016281](https://redmine.remsoft.com.br/issues/1016281), [task.md](task.md); Feature [1016270](../../feature.md).
- Referência V01: `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`, considerando a ordem final dos estilos.
- Aceite: R1 (dashboard/base), R2, R3, R9, R10; CA01/CA02 (base), CA06, CA08 (estados-base), CA10, CA11; CT-001, CT-017 e CT-018 em [condições de teste](../../slices/condicoes-teste-r002.md).
- Proposta apresentada e aprovada pelo usuário em 13/11/2026 ("aprovado"). A aprovação autoriza execução pelo Ralph e commits das fases, sem push e sem alteração do Redmine.

## Objetivo e limites

Substituir a apresentação Rem Soft do dashboard atual pela identidade FinAI e estabelecer a base visual compartilhada de marca, cores, tipografia e estados. Preservar finalidade, conteúdo funcional, dados dos usuários, permissões, destinos, campos, validações e operações existentes.

Não criar saldo, indicadores, transações, chat, atalhos financeiros, dados demonstrativos ou mensagens de conta local/armazenamento exclusivo no navegador/assistente simulado. Não antecipar as novas composições de navegação desktop/tablet (1016282), celular/transições (1016283), nem adequar individualmente todas as telas das demais filhas. A dependência dessas duas tarefas permanece para concluir a composição compartilhada da Feature; não impede iniciar esta base sobre o dashboard existente.

## Estado inspecionado e estratégia

- Branch `feature/1016281-adequacao-visual-identidade-dashboard-atual`; árvore e índice limpos antes do planejamento. HEAD inicial `533d59e`.
- `resources/views/dashboard.blade.php` contém somente um aviso de boas-vindas ao Projeto Padrão da Rem Soft, dentro de `x-app-layout`. Não há conteúdo financeiro a reconstruir.
- `resources/css/themes.css` mantém o tema DaisyUI canônico chamado `remsoft`: azul primário, fonte Nunito, raio de campo 4px e de caixa 8px. Preservar esse identificador técnico e atualizar seus valores sem criar tema paralelo. Consumidores devem usar tokens semânticos.
- `resources/css/app.css` e `resources/css/daisyui/custom.css` já centralizam estilos e estados de controles. Reaproveitar essa organização e os contratos `x-ui.*`.
- `resources/views/components/ui/application-logo.blade.php` renderiza imagem Rem Soft e é compartilhado. Navbar usa `whiteHorizontal`, embora o componente não declare essa prop. Conferir consumidores e compatibilidade ao substituir a marca; não vazar atributos internos para HTML nem alterar dados pessoais.
- `resources/views/layouts/app.blade.php`, `components/ui/navbar.blade.php`, `components/ui/main.blade.php` e `livewire/sidebar.blade.php` compõem a área autenticada. A navbar é azul, o título da aba depende de `config('app.name')` e há fontes externas Geist/Sora. Ajustes de identidade devem ser coerentes, sem reescrever navegação, rotas ou a configuração local dos usuários.
- `components/ui/title.blade.php` centraliza títulos. Verificar seus consumidores antes de aplicar Georgia aos títulos de destaque; corpo em system-ui.
- A referência define marca com símbolo verde e lettering `finai`, hierarquia de títulos, ritmo de 4/8/16/24/32/48/64px, foco visível e sombra `0 16px 48px #17262220`. Os estilos finais de composição responsiva pertencem às filhas de layout; comparar aqui marca e elementos comuns aplicáveis.
- Há testes existentes de rotas de cliente/admin, Sidebar, notificações e logout que protegem contratos relevantes. Não criar testes de estilos nem suíte de browser permanente. Se surgir mudança de lógica necessária, ler a skill testing-best-practices, cobrir somente a regressão relevante em arquivo dedicado ao responsável e revisar o escopo.

Risco principal: tokens, logo e títulos têm consumidores fora do dashboard. Conferir impactos em telas de acesso, perfil, administração e suporte sem transformar esta fase em implementação das outras filhas. Nenhuma dependência deve ser instalada ou alterada implicitamente.

## Baseline observado

Executado na raiz desta worktree, PowerShell, PHP 8.4.27 e Node 26.1.0, fora do processo executor:

```powershell
composer quality:check
```

Resultado concluído com código 0 em 13/11/2026:

- Build Vite aprovado; formatação CSS aprovada.
- Pest: 1.904 testes, 6.709 asserções, aprovados, com TIA (resultados reexecutados/reutilizados pelo mecanismo não equivalem a execução integral sem cache).
- JavaScript: 267 testes aprovados.
- Auditorias Composer/npm aprovadas, sem vulnerabilidades reportadas.
- Pint aprovado; PHPStan sem erros; Rector dry-run aprovado, sem arquivos alterados.
- Nenhuma comparação visual ou interação em browser foi executada neste baseline. Os pacotes `pestphp/pest-plugin-agent` 5.0.0 e `pestphp/pest-plugin-browser` 5.2.0 estão instalados, assim como Playwright; sua operação real ainda precisa ser exercitada no gate pertinente.

Versões confirmadas: Laravel 13.40.0, Livewire 4.4.8, Pest 5.3.5; package.json usa Tailwind 4 e DaisyUI 5; o build reportou Vite 8.3.6 e DaisyUI 5.7.28. Instruções e regras locais lidas, incluindo tema semântico, contratos de componentes e testes com TIA.

### Conferência mínima do Dev e comandos obrigatórios

Antes da primeira edição, executar somente `npm run build` como menor conferência de capacidade prevista. Não repetir o agregado nem exigir a suíte completa verde para começar Dev. Falha operacional exige investigação proporcional no próprio gate; baseline externo não comprova permissões dentro do Codex executor.

Após implementação e Validação, o gate Testes executa exatamente `composer quality:check` no PowerShell, propagando o código de saída. O agregado inclui build, formato CSS, suíte PHP com TIA/configuração CI, JavaScript, auditorias, Pint, PHPStan e Rector em checagem. Não substituir por comando reduzido. Se houver PHP alterado, Dev também deve executar `vendor/bin/pint --dirty --format agent` conforme as instruções do projeto. Rodar testes afetados com `--tia` quando houver mudança comportamental.

## Fase 1 — Dashboard e fundação visual FinAI

### Dev

1. Conferir o plano, Git e instruções aplicáveis; usar skills UI/Tailwind/Livewire e documentação versionada quando depender de APIs. Executar a conferência mínima acima no próprio processo.
2. Mapear os consumidores dos elementos compartilhados a alterar. Manter o tema canônico `remsoft`, atualizando fundo #F5F7F8, superfícies #FFFFFF, texto #172622, secundário #52615C, principal #145C46, positivo #146345, negativo #A12B36, borda #D6DFDB e destaque #E4F0E9. Manter distinção acessível de foco e dos demais estados.
3. Aplicar system-ui no corpo, Georgia nos títulos de destaque, controles com raio 8px e painéis com raio 16px. Alinhar marca, hierarquia, espaçamentos, proporções, bordas e sombras dos elementos comuns à referência.
4. Substituir a marca Rem Soft apresentada no dashboard e em seus elementos comuns por FinAI, incluindo a identificação da aplicação na área abrangida quando necessário. Reaproveitar componentes; preferir SVG/HTML nativo para a marca existente na referência, sem geração de imagem. Preservar variantes e acessibilidade dos consumidores compartilhados.
5. Adequar a apresentação do dashboard de boas-vindas, sem incluir recursos financeiros, números, páginas ou ações futuras. Ajustar apenas a apresentação necessária de navbar/sidebar/superfícies para coerência com esta base; não implementar novos modos responsivos das outras filhas.
6. Exercitar o dashboard e elementos comuns em browser pelo Pest Agent, após carregar sua skill, com dados de teste isolados e atores pertinentes. Capturar evidências em caminho ignorado; não criar suíte de browser nem persistir usuários no banco da aplicação. Se a ferramenta falhar, investigar a invocação e recursos existentes; não instalar dependências ou ampliar permissões sem autorização.

Arquivos prováveis: `resources/css/{themes.css,app.css,daisyui/custom.css}`, `resources/views/dashboard.blade.php`, `resources/views/layouts/app.blade.php`, `resources/views/components/ui/{application-logo,title,navbar,main}.blade.php`, `resources/views/livewire/sidebar.blade.php` e componentes comuns efetivamente necessários. Caminhos não obrigam editar todos os arquivos. Conferir instruções de cada caminho antes de editar.

### Validação por outro processo, somente leitura

- Comparar implementação e evidências com o `index.html` completo, respeitando os estilos finais e as adaptações aprovadas da tarefa. Conferir marca, nove cores, fontes, hierarquia, espaços, proporções, raios, contornos e sombras aplicáveis. Screenshot isolado não comprova fidelidade.
- Conferir dashboard nas nove resoluções: 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080. Não exigir a nova navegação das outras filhas; exigir ausência de rolagem horizontal da página, controles encobertos e perda de foco, rótulos ou uso por teclado nos elementos abrangidos.
- Exercitar estados existentes aplicáveis: normal, hover, foco, ativo, desabilitado, carregamento, vazio, erro, sucesso, confirmação e cancelamento. Usar controles e fluxos reais existentes; não adicionar ações fictícias ao dashboard para demonstrar estados. Registrar quais estados/elementos foram conferidos e justificar os não aplicáveis.
- Conferir destinos e permissões preservados, identificação real da conta, perfil, notificações e saída, incluindo os efeitos dos componentes compartilhados. Nenhum conteúdo pessoal renomeado ou contrato de componente alterado por estilização.
- Conferir ausência de marca Rem Soft como produto nas superfícies abrangidas, recursos financeiros antecipados e mensagens demonstrativas proibidas. Identificadores técnicos do tema e tipos existentes podem permanecer.
- Se faltar evidência visual/funcional necessária, não aprovar por inspeção de código. Achados na entrega voltam ao Dev; problemas de invocação pertencem ao gate que os encontrou.

### Testes

Executar `composer quality:check` no PowerShell depois da Validação, com conclusão e código 0. Preservar hooks e todos os verificadores. Falha de aceite ou mudança na implementação exige novo Dev → Validação → Testes antes do commit. Em impedimento externo real, registrar comando, erro observado, tentativas relevantes e próximo passo, sem atribuir causa sem evidência.

### Commit

Um commit coerente após aprovação dos gates: `feat: aplica identidade FinAI ao dashboard (#1016281)`. Incluir somente a entrega e o resumo consolidado desta fase neste plano, com alterações, evidências, verificações, revisor e resultado. Não incluir artefatos de captura, segredos ou trabalho alheio. Sem push e sem atualização do Redmine.

## Execução e acompanhamento

Usar `.agents/skills/plan-issue/ralph.sh`, backend Codex, modelo e permissões configurados no CLI; revisor em read-only. Bash do Git disponível com Codex, PHP, Composer e Node no PATH. Invocar Bash sem perfil de login para evitar o aviso observado do Starship em terminal `dumb`; isso é ajuste operacional, sem mudar verificadores ou permissões. Passar `--test-command 'composer quality:check' --test-shell powershell --timeout-seconds 1800`. Esperas incrementais de até 60 segundos e sem cópia paralela.

Não há impedimento demonstrado para preparar a execução. Plano aprovado; a evidência de browser será produzida e revisada nos gates previstos. Falta de capacidade necessária, se confirmada após investigação, impede aprovação da fase e deve ser preservada neste documento.

## Resultado da execução de 13/11/2026 — interrompida na Validação

Uma execução pelo Codex, com sandbox configurado e prazo de 1.800 segundos por processo, encerrou com `RALPH_FINISHED: exit_code=1 fase=1 gate=Validação`. Nenhum commit de entrega foi criado; HEAD continua em `533d59e`. Alterações da implementação e evidências foram preservadas.

- **Dev:** aplicou tema FinAI, marca SVG e favicon, fontes, apresentação de boas-vindas e ajustes visuais dos consumidores compartilhados. Atualizou o teste existente de identidade da aba, preservando escape. Relatou build mínimo, Pint e dois casos do teste afetado aprovados; browser nas nove resoluções sem rolagem horizontal, abertura de conta/notificações sem erros JavaScript, acesso de cliente/admin e destino próprio de suporte. Evidências em `storage/framework/cache/data/finai-evidence` (ignorado pelo Git). A primeira invocação do Pest Agent perdeu aspas no PowerShell; o Dev corrigiu a chamada antes de obter os resultados relatados.
- **Validação independente (outro processo Codex, somente leitura):** conferiu design completo e nove capturas; confirmou paleta, marca, fontes e painel. Não aprovou a fase: `resources/views/components/ui/button.blade.php:66` ainda usa `rounded-sm`, impondo 4px em vez de 8px. Também faltam registros verificáveis de teclado/foco, destinos/permissões, perfil/saída e estados aplicáveis, com justificativas para os não aplicáveis. Imagens isoladas não comprovam esses critérios. Não houve alteração de arquivos pelo revisor.
- **Testes:** o gate obrigatório `composer quality:check` não foi executado após a implementação. O baseline anterior não substitui esse gate.
- **Commit:** não executado; sem push ou atualização do Redmine.

O revisor devolveu `status=blocked` pela evidência ausente. O executor encerra imediatamente nesse status (linha 439); somente `rejected` retorna ao Dev (linhas 440–443). Conferidos o relatório final, Git e código após a interrupção. Uma nova chamada trataria os 15 arquivos de implementação agora modificados/não rastreados como trabalho preexistente protegido (linhas 195–201), impedindo correções e sua inclusão como entrega. O executor não oferece retomada nesta interface; não foi iniciada cópia adicional, nem alterado o script, removidas proteções, descartado trabalho ou criado commit sem gates.

Próximo passo necessário: viabilizar no executor o retorno seguro desta entrega preservada ao Dev, com os achados acima. Depois, corrigir o raio e completar os registros de interação no Dev, realizar nova Validação independente e executar integralmente Testes antes de Commit. Isso não altera escopo, aceite ou verificadores aprovados; a entrega permanece pendente.

### Resultado Ralph — Dashboard e fundação visual FinAI

- Entrega: Corrigidos raios de botões e confirmação; arquivos preexistentes preservados. Build, Pint, 34 testes e verificações de browser passaram. Evidências em storage/framework/cache/data/finai-evidence/run-X3-summary.json. Aguarda Validação independente e quality:check no gate Testes.
- Validação: outro processo codex, revisão 2, aprovada para a versão testada.
- Testes: verificadores aprovados; relatórios privados da execução, fase 1.
