# Fatiamento de [WEB] [USUÁRIO] Escolher tema claro, escuro ou sistema

## Identidade

Pai: [#1016399](https://redmine.remsoft.com.br/issues/1016399); [requisito aprovado](../feature.md).

Projeto FinAi (65224), versão Livewire (20359). Revisão r001, proposta para revisão. Nenhuma filha publicada, Sequencing atribuído ou QA executada nesta etapa. Os pais continuam New; esta proposta não autoriza implementação.

## Inspeção e fronteiras

`resources/css/themes.css` define apenas remsoft claro e tokens semânticos. Os layouts app/guest fixam data-theme e `resources/views/components/ui/navbar.blade.php` contém perfil/saída sem seletor. `resources/js/app.js` não registra comportamento de tema; a busca por prefers-color-scheme/data-theme/localStorage não encontrou seleção ou lembrança de tema (a lembrança existente em sidebar.js é de outra finalidade). As telas usam amplamente cores semânticas; atenção à saída de comandos em `resources/views/livewire/support/artisan-commands/history.blade.php` e à cor fixa da envbar. `resources/views/components/layouts/pdf.blade.php` tem aparência própria a preservar. `tests/Feature/View/Components/LayoutComponentsTest.php` cobre identidade, não temas.

Classificação: criação de escolha/Sistema/lembrança e adaptação visual de consumidores existentes. Nenhum critério foi classificado como integralmente existente para omitir DEV. Testes e código foram lidos, não executados; as evidências de leitura não comprovam conformidade em navegador. Não há necessidade de Study identificada.

## Prévia numerada

| Entrega | Título completo | Horas | Sequencing |
| --- | --- | ---: | ---: |
| D01 | [DEV] [WEB] [USUÁRIO] Escolher tema claro, escuro ou sistema - Escolha clara e escura nas telas públicas | 3.5 | 45 |
| D02 | [DEV] [WEB] [USUÁRIO] Escolher tema claro, escuro ou sistema - Escolha clara e escura no menu da conta | 4 | 46 |
| D03 | [DEV] [WEB] [USUÁRIO] Escolher tema claro, escuro ou sistema - Sistema como padrão e acompanhamento | 1.5 | 47 |
| D04 | [DEV] [WEB] [USUÁRIO] Escolher tema claro, escuro ou sistema - Preferência lembrada por navegador | 2.5 | 48 |
| Q01 | [QA] [WEB] [USUÁRIO] Escolher tema claro, escuro ou sistema - Escolha e continuidade da preferência | 3 | 49 |
| Q02 | [QA] [WEB] [USUÁRIO] Escolher tema claro, escuro ou sistema - Aparência e operações nas telas existentes | 4.5 | 50 |

Total: 19h. Todos os valores são esforço ativo, incluem verificação DEV e preparação/execução/registro/reteste dirigido QA nas respectivas tarefas; excluem espera por ambiente ou aprovação.

Relações nativas propostas: D01 → D02 (`blocks`); D01 → D03 (`blocks`); D01 → D04 (`blocks`); D01 → Q01 (`blocks`); D02 → Q01 (`blocks`); D03 → Q01 (`blocks`); D04 → Q01 (`blocks`); D01 → Q02 (`blocks`); D02 → Q02 (`blocks`); D03 → Q02 (`blocks`); D04 → Q02 (`blocks`). Sem bloqueio externo novo. As relações `relates` dos pais com #1016270 serão preservadas; a ordem de catálogo não cria bloqueios entre os três pais.

## Estimativas e revisão independente

Fronteiras revisadas antes das horas: seleção pública e autenticada possuem canais/atores demonstráveis; Sistema e lembrança são objetivos independentes. A primeira seleção pública inclui a paleta e os estados comuns indispensáveis para o usuário perceber o tema, sem preparação interna separada. A seleção autenticada reaproveita a base e adapta suas superfícies. Avaliações independentes A/B: público 3,5h/3,5h; autenticado 4h/3h; Sistema 2h/1,5h; lembrança 2,5h/2h; QA preferências 3h/3h; QA visual 4,5h/4h. Proposta final: 3,5h, 4h, 1,5h, 2,5h, 3h e 4,5h. O inventário autenticado e a falha de lembrança justificam a maior parcela dessas entregas; Sistema permanece uma interação estreita porque paleta/seletores e armazenamento têm donos próprios. Não se aplicou média automática.

Duas avaliações independentes por entrega, uma focada em resultado/trabalho restante e outra em reaproveitamento/sobreposição/testes. Referência humana local: #1016270, com 1,5h para identidade no dashboard, 2h para cada jornada/layout e QA integral de 4h, conforme seu slices.md. Os valores não foram copiados: esta proposta considera novas interações e o reaproveitamento observado. Suposições: equipe familiarizada com o projeto e ambiente de homologação disponível com dados/atores a preparar; não há medição de tempo real nem redução presumida por uso de IA.

## Cobertura

| Regra ou critério | Dono da entrega | Condições QA |
| --- | --- | --- |
| R1 — Claro/Escuro | D01 público / D02 autenticado | CT-003–CT-004 |
| R1 — Sistema, padrão e acompanhamento | D03; D04 somente restauração da opção | CT-001–CT-002, CT-006–CT-008 |
| R2 | D04 | CT-008–CT-011 |
| R3 — Seletor público | D01; D03 adiciona Sistema | CT-003, CT-015 |
| R3 — Menu da conta | D02; D03 adiciona Sistema | CT-004, CT-015 |
| R4–R5 — Superfícies públicas e estados compartilhados | D01 | CT-012, CT-014 |
| R4–R5 — Superfícies/estados autenticados | D02 | CT-013–CT-014 |
| R6 — Contexto na escolha pública/autenticada | D01/D02 em seus canais | CT-005, CT-016 |
| R6 — Continuidade em Sistema e restauração | D03/D04 em suas interações | CT-006–CT-011 |
| CA01 | D03 | CT-001–CT-002 |
| CA02 — Claro/Escuro por canal | D01 público / D02 autenticado | CT-003–CT-005 |
| CA02 — Sistema selecionável | D03 | CT-006–CT-007 |
| CA03 | D03 | CT-006–CT-007 |
| CA04–CA05 | D04 | CT-008–CT-010 |
| CA06 — Local e acesso | D01 público / D02 autenticado; D03 terceira opção | CT-003–CT-004, CT-015 |
| CA07 — Aparência e estados | D01 público/compartilhado / D02 autenticado | CT-012–CT-014 |
| CA08 — Seletores e faixas | D01 público / D02 autenticado; D03 na opção Sistema | CT-015 |
| CA09 | D04 | CT-011 |
| CA10 — Operações e saídas | D01 público / D02 autenticado; D03/D04 preservam contexto de suas interações | CT-005, CT-016 |

Critérios transversais são particionados por região/canal/interação, sem recriar o mesmo comportamento em várias tarefas. QA cobre o pai integralmente; nenhum critério foi excluído. A escolha parcial de temas só cumpre o pai após integração das três opções, Sistema padrão e preferência lembrada.

## Condições de teste

Fonte: [condicoes-teste-r001.md](condicoes-teste-r001.md). Documento Word: [1016399 - Condições de testes.docx](<r001/1016399 - Condições de testes.docx>).

Pai: [#1016399 — Escolher tema claro, escuro ou sistema](https://redmine.remsoft.com.br/issues/1016399).

Revisão: r001 — proposta para revisão; ainda não executada.

### Contexto

Usar visitante e contas de cliente, administrador e suporte com acessos existentes. Cobertura pública: logins das áreas, cadastro, recuperação/redefinição de senha, verificação de e-mail e confirmação de senha nas condições reais de acesso. Cobertura autenticada: dashboard atual, perfil, notificações, Usuários, Perfis de acesso, Alertas de erros e comandos/histórico de suporte; incluir formulários, navegação, menus, diálogos, painéis laterais, feedbacks e envbar quando habilitada. Preparar contextos independentes de navegador, preferência de sistema clara/escura/sem preferência e indisponibilidade controlada da lembrança. Matriz: 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768 e 1366×768; transições 767/768 e 1024/1025px. Comparar identidade clara e hierarquia FinAI à referência #1016270; não há mockup ou paleta escura exata aprovada. Não há execução de testes neste documento.

### CT-001 — Primeiro acesso acompanha o dispositivo

Verificação: Em contexto sem escolha anterior, abrir a aplicação com dispositivo em claro e repetir em escuro.

Resultado esperado: Sistema fica selecionado e produz a aparência clara ou escura correspondente ao dispositivo.

Origem no requisito: R1, CA01.

### CT-002 — Padrão sem preferência válida

Verificação: Acessar sem preferência escura do dispositivo; repetir com dados do site limpos ou preferência anterior inválida.

Resultado esperado: Sistema é o padrão e a aparência é clara quando não houver preferência escura informada.

Origem no requisito: R1, CA01, CA05.

### CT-003 — Escolher tema nas telas públicas

Verificação: Como visitante, acessar os seletores das telas públicas abrangidas e escolher Claro e Escuro.

Resultado esperado: A opção selecionada é identificável e a aparência muda na tela atual, sem exigir autenticação nem salvar perfil.

Origem no requisito: R3, R4, CA02, CA06.

### CT-004 — Escolher tema no menu da conta

Verificação: Como cliente, administrador e suporte, abrir o menu da conta e escolher Claro e Escuro nas telas autorizadas.

Resultado esperado: O seletor fica disponível no menu da conta, altera a aparência atual e mantém os outros controles alcançáveis.

Origem no requisito: R3, R4, CA02, CA06.

### CT-005 — Preservar formulário e filtros

Verificação: Com formulário preenchido ou filtros aplicados, trocar o tema nos acessos disponíveis.

Resultado esperado: Campos e filtros permanecem; não é necessário reiniciar a navegação nem salvar o perfil.

Origem no requisito: R6, CA02, CA10.

### CT-006 — Acompanhar mudança do sistema

Verificação: Selecionar Sistema e alterar a preferência do dispositivo com a aplicação aberta; repetir nos seletores público/autenticado.

Resultado esperado: A aparência acompanha a mudança e Sistema continua identificado como a opção selecionada.

Origem no requisito: R1, CA03.

### CT-007 — Manter escolha explícita

Verificação: Escolher Claro ou Escuro e alterar a preferência do dispositivo; depois voltar a Sistema.

Resultado esperado: A escolha explícita permanece; ao voltar a Sistema, o acompanhamento é retomado.

Origem no requisito: R1, CA03.

### CT-008 — Lembrar na navegação e no retorno

Verificação: Escolher cada uma das três opções, navegar, recarregar e fechar/reabrir o navegador preservando os dados do site.

Resultado esperado: A opção escolhida é restaurada e aplicada; em Sistema, a aparência corresponde à preferência atual do dispositivo.

Origem no requisito: R2, CA04.

### CT-009 — Preservar entre contas no mesmo navegador

Verificação: Escolher um tema como visitante, entrar, sair e entrar com outra conta no mesmo navegador.

Resultado esperado: A preferência do navegador é mantida; a troca de conta não introduz uma preferência própria de perfil.

Origem no requisito: R2, CA04.

### CT-010 — Isolar navegadores e limpar dados

Verificação: Acessar a mesma conta em outro navegador/contexto sem dados do site e limpar os dados no contexto original.

Resultado esperado: Cada contexto sem escolha própria inicia em Sistema; não há sincronização por conta.

Origem no requisito: R2, CA05.

### CT-011 — Armazenamento indisponível

Verificação: Impedir a lembrança no navegador e escolher um tema pela interface.

Resultado esperado: A escolha ainda se aplica à página atual e o sistema continua utilizável; o próximo acesso pode voltar ao padrão.

Origem no requisito: R2, CA09.

### CT-012 — Comparar jornadas públicas em ambos os temas

Verificação: Percorrer todas as telas públicas abrangidas em Claro e Escuro, incluindo seus estados normais e mensagens existentes.

Resultado esperado: Marca, hierarquia, texto, campos, bordas, ícones e mensagens ficam coerentes e legíveis; Claro preserva a identidade vigente e Escuro a adapta sem inventar referência aprovada.

Origem no requisito: R4, R5, CA07.

### CT-013 — Comparar jornadas autenticadas em ambos os temas

Verificação: Percorrer dashboard, perfil, notificações, gestão e suporte, incluindo tabelas com dados/vazias e saída de comandos.

Resultado esperado: A identidade e a legibilidade se mantêm nas superfícies; conteúdo funcional continua reconhecível, sem áreas claras ou escuras incoerentes que impeçam o uso.

Origem no requisito: R4, R5, CA07.

### CT-014 — Conferir componentes e estados

Verificação: Abrir menus, diálogos e painéis laterais; conferir foco, seleção, desabilitado, carregamento, sucesso, aviso, erro e estado vazio nos dois temas; incluir envbar permitida.

Resultado esperado: Os estados continuam distinguíveis e legíveis, a navegação permanece alcançável e a identificação dos ambientes conserva seu significado.

Origem no requisito: R4, R5, CA07.

### CT-015 — Usar seletores na matriz responsiva

Verificação: Selecionar as três opções nas telas públicas e no menu da conta em toda a matriz, inclusive transições.

Resultado esperado: Seletores não alargam a página, não encobrem conteúdo/ações e preservam o acesso aos controles existentes.

Origem no requisito: R3, CA06, CA08.

### CT-016 — Conferir operações e saídas preservadas

Verificação: Executar as operações existentes nas telas de acesso, perfil, gestão e suporte abrangidas, nos dois temas; registrar por tela quais operações foram exercitadas, seus resultados e restrições, justificando os casos não aplicáveis. Conferir também impressão, PDF e exportação onde já disponíveis.

Resultado esperado: Resultados, permissões e contexto de uso são preservados; impressão, PDFs e arquivos exportados mantêm a aparência e regras anteriores, sem receber automaticamente o tema escuro.

Origem no requisito: R6, CA10.


## Descrições completas

### 1. [DEV] [WEB] [USUÁRIO] Escolher tema claro, escuro ou sistema - Escolha clara e escura nas telas públicas

Papel: DEV. Estimativa: 3.5h. Sequencing: 45.

#### Entrega

Criar uma escolha utilizável de Claro e Escuro nas telas públicas, com alteração imediata e identificação da opção. A primeira interação entrega junto a paleta e os estados compartilhados necessários para que o visitante perceba a mudança completa nessas telas.

#### Escopo e limites

Cobertura: Login de cliente, administração e suporte; cadastro; recuperação e redefinição de senha; verificação de e-mail e confirmação de senha, conforme as condições reais de acesso. A paleta não é uma preparação isolada: é aceita pela seleção real nessas jornadas. A integração autenticada, Sistema e a lembrança entre acessos pertencem às outras entregas; não apresentar Sistema inoperante. O pai só estará completo com as três opções e o padrão Sistema.

#### Critérios de aceite

- Visitantes encontram um seletor identificável nas telas públicas e alternam Claro/Escuro sem autenticar ou salvar perfil; a aparência muda na tela atual e a opção escolhida é identificável.
- A troca preserva campos preenchidos, mensagens e o contexto da jornada pública; não reinicia a navegação nem muda resultados, permissões ou restrições existentes.
- Claro preserva marca, hierarquia e identidade FinAI da referência #1016270. Escuro adapta fundos, superfícies, texto, bordas e estados com legibilidade; não há paleta escura exata aprovada a reproduzir.
- Conferir os formulários, botões, ícones, menus/diálogos/feedbacks públicos existentes nos estados aplicáveis de foco, seleção, desabilitado, carregamento, sucesso, aviso e erro; permanecem distinguíveis e legíveis.
- Conferir o seletor e as telas públicas em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768 e 1366×768, incluindo 767/768px e 1024/1025px: o seletor não alarga a página nem encobre conteúdo ou controles.
- Quando a envbar estiver permitida nessas telas, suas informações e distinções de ambiente permanecem legíveis; impressão, PDFs e exportações não recebem automaticamente a aparência escura.

#### Dependências

Não há bloqueios de início nem fornecedor de nova funcionalidade externa. A identidade FinAI atual e os componentes existentes são a base de adaptação. Esta entrega fornece paleta e estados compartilhados implementados e visualmente verificáveis às demais tarefas de temas.

#### Referências

[Pai #1016399](https://redmine.remsoft.com.br/issues/1016399); requisito canônico: `docs/harness/features/1016399-temas-claro-escuro-e-sistema/feature.md`. [Identidade visual #1016270](https://redmine.remsoft.com.br/issues/1016270); fonte compartilhada: `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, `index.html`, identidade e componentes aplicáveis às telas existentes. Sem mockup de seletor ou paleta escura exata; usar as decisões visuais R4–R5 do requisito, preservando a identidade FinAI.

Cobertura: R3–R6 e CA02/CA06–CA08/CA10 nas telas públicas; R1 Claro/Escuro. Condições: CT-003, CT-005, CT-012, CT-014, CT-015, CT-016 na cobertura pública, na revisão r001 do DOCX do pai 1016399. As condições e critérios visuais se aplicam às telas/estados da entrega; a captura de defeito não é mockup final.

Origem estável: `docs/harness/features/1016399-temas-claro-escuro-e-sistema/slices/slices.md — D01, revisão r001`.

### 2. [DEV] [WEB] [USUÁRIO] Escolher tema claro, escuro ou sistema - Escolha clara e escura no menu da conta

Papel: DEV. Estimativa: 4h. Sequencing: 46.

#### Entrega

Disponibilizar Claro e Escuro no menu da conta e aplicar a aparência às jornadas autenticadas de cliente, administração e suporte. Consumir a paleta e os estados compartilhados da seleção pública, adaptando as superfícies próprias dessas áreas.

#### Escopo e limites

Cobertura: Dashboard atual, perfil, notificações, Usuários, Perfis de acesso, Alertas de erros, executor e Histórico de comandos Artisan, conforme permissões de cliente, administrador e suporte. Não recriar a paleta compartilhada nem transferir sua conferência pública para esta tarefa. A troca de aparência e o uso das superfícies autenticadas formam a mesma entrega; a aparência das telas é necessária para demonstrar o resultado da escolha. Sistema e persistência são integrados pelas respectivas tarefas.

#### Critérios de aceite

- Cliente, administrador e suporte encontram o seletor no menu da conta das telas já autorizadas e alternam Claro/Escuro na tela atual; a opção escolhida fica identificável e os outros controles do menu continuam alcançáveis.
- Alternar com formulário preenchido ou filtros aplicados mantém campos, critérios e contexto; não exige salvar perfil ou sair e entrar novamente.
- Dashboard, perfil, notificações, gestão e suporte apresentam identidade coerente em Claro e Escuro, com textos, ícones, superfícies, bordas e estados legíveis; conferir especialmente tabelas e saída de comandos.
- Menus, diálogos, painéis laterais, seleção, foco, desabilitado, carregamento, sucesso, aviso, erro e estados vazios conservam o significado e a legibilidade.
- Conferir menu da conta e superfícies autenticadas em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768 e 1366×768, incluindo 767/768px e 1024/1025px; a seleção não alarga a página nem encobre conteúdo, navegação ou ações.
- Permissões, resultados de operações e impressão/PDF/exportações disponíveis mantêm as regras e aparência anteriores; envbar permitida conserva informações e distinções legíveis.

#### Dependências

Bloqueio de início pela base visual implementada de “Escolher tema claro, escuro ou sistema - Escolha clara e escura nas telas públicas”. Para o resultado final de três opções, integrar também “Sistema como padrão e acompanhamento” e “Preferência lembrada por navegador”; esses resultados não são recriados aqui.

#### Referências

[Pai #1016399](https://redmine.remsoft.com.br/issues/1016399); requisito canônico: `docs/harness/features/1016399-temas-claro-escuro-e-sistema/feature.md`. [Identidade visual #1016270](https://redmine.remsoft.com.br/issues/1016270); fonte compartilhada: `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, `index.html`, identidade e componentes aplicáveis às telas existentes. Sem mockup de seletor ou paleta escura exata; usar as decisões visuais R4–R5 do requisito, preservando a identidade FinAI.

Cobertura: R3–R6 e CA02/CA06–CA08/CA10 nas áreas autenticadas. Condições: CT-004, CT-005, CT-013, CT-014, CT-015, CT-016 na cobertura autenticada, na revisão r001 do DOCX do pai 1016399. As condições e critérios visuais se aplicam às telas/estados da entrega; a captura de defeito não é mockup final.

Origem estável: `docs/harness/features/1016399-temas-claro-escuro-e-sistema/slices/slices.md — D02, revisão r001`.

### 3. [DEV] [WEB] [USUÁRIO] Escolher tema claro, escuro ou sistema - Sistema como padrão e acompanhamento

Papel: DEV. Estimativa: 1.5h. Sequencing: 47.

#### Entrega

Acrescentar Sistema como terceira opção funcional, iniciando com ela quando não houver escolha anterior válida e acompanhando mudanças de aparência do dispositivo na tela aberta.

#### Escopo e limites

A escolha explícita Claro/Escuro permanece prioritária até o usuário voltar a Sistema. Não duplicar a seleção ou a paleta nem implementar a lembrança persistente, que pertence à tarefa própria.

#### Critérios de aceite

- Sem preferência anterior válida, Sistema fica selecionado; produz Claro ou Escuro conforme o dispositivo. Sem preferência escura informada, produz Claro.
- Os seletores público e do menu da conta apresentam exatamente Claro, Escuro e Sistema e identificam a opção escolhida; Sistema continua identificado mesmo quando produz aparência clara ou escura.
- Selecionar Sistema e alterar a preferência do dispositivo com a aplicação aberta atualiza a aparência. Em Claro ou Escuro explícitos, a mudança do dispositivo não substitui a escolha.
- Voltar de uma escolha explícita a Sistema retoma o acompanhamento sem perder campos preenchidos, filtros ou contexto da tela.
- Conferir o acompanhamento e o acesso à opção nos canais público e autenticado em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768 e 1366×768, incluindo 767/768px e 1024/1025px, com os mesmos limites visuais dos seletores existentes.

#### Dependências

Bloqueio de início pela primeira seleção/paleta utilizável de “Escolher tema claro, escuro ou sistema - Escolha clara e escura nas telas públicas”. Pode avançar sem aguardar a seleção autenticada; para concluir, integrar ao menu da conta entregue por “Escolha clara e escura no menu da conta”. Não há bloqueio de início pela tarefa de preferência lembrada.

#### Referências

[Pai #1016399](https://redmine.remsoft.com.br/issues/1016399); requisito canônico: `docs/harness/features/1016399-temas-claro-escuro-e-sistema/feature.md`. [Identidade visual #1016270](https://redmine.remsoft.com.br/issues/1016270); fonte compartilhada: `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, `index.html`, identidade e componentes aplicáveis às telas existentes. Sem mockup de seletor ou paleta escura exata; usar as decisões visuais R4–R5 do requisito, preservando a identidade FinAI.

Cobertura: R1; R3 e R6 no modo Sistema; CA01, CA03; CA02/CA06/CA08 na terceira opção. Condições: CT-001, CT-002, CT-006, CT-007, CT-015 no modo Sistema, na revisão r001 do DOCX do pai 1016399. As condições e critérios visuais se aplicam às telas/estados da entrega; a captura de defeito não é mockup final.

Origem estável: `docs/harness/features/1016399-temas-claro-escuro-e-sistema/slices/slices.md — D03, revisão r001`.

### 4. [DEV] [WEB] [USUÁRIO] Escolher tema claro, escuro ou sistema - Preferência lembrada por navegador

Papel: DEV. Estimativa: 2.5h. Sequencing: 48.

#### Entrega

Lembrar a opção Claro, Escuro ou Sistema no mesmo navegador e reaplicá-la na navegação, recarga e retorno, sem vincular a preferência ao perfil da conta.

#### Escopo e limites

A persistência não sincroniza contas ou dispositivos. As escolhas e o acompanhamento do sistema têm fornecedores próprios; esta entrega integra suas três opções sem recriar os seletores.

#### Critérios de aceite

- Escolher cada uma das três opções, navegar, recarregar e fechar/reabrir o navegador com dados do site preservados mantém a opção. Em Sistema, a aparência usa a preferência atual do dispositivo.
- Entrar, sair ou trocar de conta no mesmo navegador mantém a preferência do navegador; não carregar uma aparência própria da conta nem exigir salvar o perfil.
- Outro navegador ou contexto sem escolha anterior inicia em Sistema, mesmo para a mesma conta. Limpar os dados do site também devolve o padrão Sistema.
- Quando não for possível lembrar a preferência, aplicar a escolha à página atual e manter a aplicação utilizável; um próximo acesso pode voltar ao padrão.
- Aplicar ou restaurar o tema não limpa o estado já presente na página nem altera permissões ou resultados. Manter as regras atuais de navegação e recarga, sem acrescentar persistência de campos ou filtros; integrar as três opções nos seletores público e autenticado.

#### Dependências

Bloqueio de início pela primeira seleção/paleta utilizável de “Escolher tema claro, escuro ou sistema - Escolha clara e escura nas telas públicas”. Pode começar sem esperar as demais tarefas; para concluir, integrar a opção Sistema de “Sistema como padrão e acompanhamento” e o seletor de “Escolha clara e escura no menu da conta”. Esses são fornecedores de integração, sem bloqueios nativos adicionais entre eles.

#### Referências

[Pai #1016399](https://redmine.remsoft.com.br/issues/1016399); requisito canônico: `docs/harness/features/1016399-temas-claro-escuro-e-sistema/feature.md`. [Identidade visual #1016270](https://redmine.remsoft.com.br/issues/1016270); fonte compartilhada: `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, `index.html`, identidade e componentes aplicáveis às telas existentes. Sem mockup de seletor ou paleta escura exata; usar as decisões visuais R4–R5 do requisito, preservando a identidade FinAI.

Cobertura: R2; R1 na restauração/padrão; R6 na continuidade; CA04, CA05, CA09. Condições: CT-002, CT-008, CT-009, CT-010, CT-011, na revisão r001 do DOCX do pai 1016399. As condições e critérios visuais se aplicam às telas/estados da entrega; a captura de defeito não é mockup final.

Origem estável: `docs/harness/features/1016399-temas-claro-escuro-e-sistema/slices/slices.md — D04, revisão r001`.

### 5. [QA] [WEB] [USUÁRIO] Escolher tema claro, escuro ou sistema - Escolha e continuidade da preferência

Papel: QA. Estimativa: 3h. Sequencing: 49.

#### Entrega

Validar a escolha das três opções nos canais público e autenticado, o acompanhamento da aparência do dispositivo e a lembrança independente por navegador.

#### Escopo e limites

Preparar contextos independentes, mudança de aparência e falha controlada de lembrança. A varredura visual completa de superfícies e operações fica na QA “Aparência e operações nas telas existentes”, sem reduzir a validação funcional desta tarefa.

#### Critérios de aceite

- Executar CT-001–CT-011 e a interação dos seletores de CT-015; registrar contexto, resultado e evidências dos desvios.
- Conferir primeiro acesso em Sistema, fallback claro, opção identificável, mudança dinâmica e prioridade das escolhas explícitas nos dois canais.
- Conferir preservação de formulário/filtros, navegação, recarga, reabertura, entrada/saída/troca de conta, independência de contextos, limpeza dos dados e armazenamento indisponível.
- Exercitar as três opções como visitante e pelos menus autorizados de cliente/administração/suporte em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768 e 1366×768 e 767/768px e 1024/1025px, mantendo os controles alcançáveis.
- Usar o DOCX do pai #1016399 r001 e compartilhar os resultados com a QA visual para a conferência integrada final, sem substituir a varredura visual por testes de lógica.

#### Dependências

A campanha integral aguarda as quatro entregas DEV do pai: seleção pública, seleção no menu da conta, Sistema e preferência por navegador. Preparação de contextos pode ser antecipada.

#### Referências

[Pai #1016399](https://redmine.remsoft.com.br/issues/1016399); requisito canônico: `docs/harness/features/1016399-temas-claro-escuro-e-sistema/feature.md`. [Identidade visual #1016270](https://redmine.remsoft.com.br/issues/1016270); fonte compartilhada: `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, `index.html`, identidade e componentes aplicáveis às telas existentes. Sem mockup de seletor ou paleta escura exata; usar as decisões visuais R4–R5 do requisito, preservando a identidade FinAI.

Cobertura: R1–R3, R6; CA01–CA06, CA08–CA09 e preservação de contexto de CA10. Condições: CT-001–CT-011, CT-015, na revisão r001 do DOCX do pai 1016399. As condições e critérios visuais se aplicam às telas/estados da entrega; a captura de defeito não é mockup final.

Origem estável: `docs/harness/features/1016399-temas-claro-escuro-e-sistema/slices/slices.md — Q01, revisão r001`.

### 6. [QA] [WEB] [USUÁRIO] Escolher tema claro, escuro ou sistema - Aparência e operações nas telas existentes

Papel: QA. Estimativa: 4.5h. Sequencing: 50.

#### Entrega

Validar a cobertura visual de Claro e Escuro em todas as telas existentes abrangidas e a preservação das operações, consolidando o resultado com a QA de escolha e continuidade.

#### Escopo e limites

Cobertura pública: Login de cliente, administração e suporte; cadastro; recuperação e redefinição de senha; verificação de e-mail e confirmação de senha, conforme as condições reais de acesso. Cobertura autenticada: Dashboard atual, perfil, notificações, Usuários, Perfis de acesso, Alertas de erros, executor e Histórico de comandos Artisan, conforme permissões de cliente, administrador e suporte. Conferir identidade, estados e legibilidade por comparação humana, sem exigir uma paleta escura ou mockup que não foram aprovados.

#### Critérios de aceite

- Executar CT-012–CT-014 e CT-016 no inventário completo e usar a matriz de CT-015 para conferir a composição visual dos seletores e telas.
- Em Claro, comparar marca, hierarquia e linguagem visual com a identidade FinAI de #1016270; em Escuro, conferir a adaptação legível de fundos, superfícies, bordas, textos e estados.
- Conferir tabelas com dados/vazias, formulários, erros, foco, seleção, desabilitado, carregamento, sucesso, avisos, menus, diálogos, painéis, notificações, envbar permitida e saída de comandos.
- Percorrer 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768 e 1366×768 e 767/768px e 1024/1025px, confirmando que seletores não alargam a página nem encobrem conteúdo ou ações.
- Conferir operações e restrições atuais nos dois temas; impressão, PDFs e exportações mantêm suas regras e aparência anteriores.
- Na conferência integrada final, combinar os resultados da QA de escolha/continuidade com a cobertura visual e registrar os desvios e um reteste dirigido, sem anunciar aprovação do pai antes de ambas as campanhas.

#### Dependências

A campanha integral aguarda as quatro entregas DEV do pai. A QA “Escolha e continuidade da preferência” fornece seus resultados à conferência final; não há bloqueio de início entre as duas QAs, que podem compartilhar preparação.

#### Referências

[Pai #1016399](https://redmine.remsoft.com.br/issues/1016399); requisito canônico: `docs/harness/features/1016399-temas-claro-escuro-e-sistema/feature.md`. [Identidade visual #1016270](https://redmine.remsoft.com.br/issues/1016270); fonte compartilhada: `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, `index.html`, identidade e componentes aplicáveis às telas existentes. Sem mockup de seletor ou paleta escura exata; usar as decisões visuais R4–R5 do requisito, preservando a identidade FinAI.

Cobertura: R3–R6; CA02 na preservação de contexto visual; CA06–CA08, CA10. Condições: CT-012–CT-016 na cobertura visual/operações, na revisão r001 do DOCX do pai 1016399. As condições e critérios visuais se aplicam às telas/estados da entrega; a captura de defeito não é mockup final.

Origem estável: `docs/harness/features/1016399-temas-claro-escuro-e-sistema/slices/slices.md — Q02, revisão r001`.

## Publicação proposta

- Servidor: https://redmine.remsoft.com.br. Identidade consultada: Mário Tinelli (131789).
- Criar 6 filhas novas sob o pai #1016399; tracker Task (4), status New (1), prioridade Normal (4), projeto FinAi (65224), versão Livewire (20359). Sem categoria, responsável, datas ou outros campos adicionais. Títulos, descrições, estimativas e Sequencing são os da prévia acima.
- As descrições remotas serão integralmente as seções Entrega, Escopo e limites, Critérios de aceite, Dependências e Referências de cada filha, preservando a origem estável. As referências de evidência são links para anexos Redmine; nenhum caminho do computador será usado como evidência.
- Filhas existentes: consultas de todos os status por pai não retornaram filhas. Nenhuma adoção, exclusão, cancelamento, alteração de status ou renumeração de issue alheia é proposta.
- Relações novas: D01 → D02 (`blocks`); D01 → D03 (`blocks`); D01 → D04 (`blocks`); D01 → Q01 (`blocks`); D02 → Q01 (`blocks`); D03 → Q01 (`blocks`); D04 → Q01 (`blocks`); D01 → Q02 (`blocks`); D02 → Q02 (`blocks`); D03 → Q02 (`blocks`); D04 → Q02 (`blocks`). A origem é a fornecedora/bloqueadora e o destino é a consumidora/QA; substituir as chaves pelos IDs confirmados. Preservar todas as relações existentes.
- Atualizar somente Sequencing do pai #1016399 para 45, espelhando a primeira filha e sem consumir posição adicional; preservar descrição, status e demais campos do pai.
- Anexar `1016399 - Condições de testes.docx`, revisão r001, às QAs Q01 — [QA] [WEB] [USUÁRIO] Escolher tema claro, escuro ou sistema - Escolha e continuidade da preferência; Q02 — [QA] [WEB] [USUÁRIO] Escolher tema claro, escuro ou sistema - Aparência e operações nas telas existentes. O mesmo documento integral será anexado às duas QAs; Q01 executa CT-001–CT-011/CT-015, Q02 executa CT-012–CT-016 em sua cobertura visual e consolida o resultado integrado. Preservar anexos já existentes.
- Materializar `tasks/dev-<ID>-<slug>/task.md` e `tasks/qa-<ID>-<slug>/task.md` somente após releitura integral da publicação. Não criar planning.md nem implementar neste fluxo.

## Sequencing

Campo real: Sequencing, custom field 2. Consulta MCP completa: projeto 65224, versão 20359, todos os status/trackers, uma página com 46 de 46 issues. Maior inteiro positivo ocupado: 37; nenhum valor não vazio inválido. Espelhos históricos de pai/primeira filha são mantidos como ocupados.

Bloco proposto deste pai: 45–50; âncora do pai: 45. Blocos do conjunto na ordem aprovada: envbar 38–39; tabelas 40–44; temas 45–50. Nenhuma lacuna é reutilizada e nenhum número atual será deslocado. Renovar a leitura integral antes de publicar; colisão exige conciliação, sem recalcular números já autorizados silenciosamente.

## Revisão e publicação

| Operação proposta | ID/URL conhecido | Resultado | Próximo passo |
| --- | --- | --- | --- |
| Criar filhas D01, D02, D03, D04, Q01, Q02 | Ainda não existem | Não autorizada nem executada | Revisão do conjunto completo |
| Relações e Sequencing acima | Pai #1016399 | Não autorizados nem executados | Aplicar somente após aprovação |
| Associar DOCX às QAs previstas | Arquivo r001 preparado para revisão | Não enviado | Conferir arquivo real e anexar após aprovação |

## Documento Word conferido

O DOCX r001 foi gerado com Microsoft Word 16.0 disponível nesta máquina. O pacote ZIP/OpenXML e o conteúdo legível foram conferidos: 16 condições, equivalentes integralmente ao Markdown da revisão após normalizar apenas a apresentação dos títulos e links. O arquivo é uma prévia real para revisão, ainda não enviado ao Redmine. As condições representam verificações futuras, não testes já executados.

## Resultado consolidado e pendências

Proposta completa de tarefas, cobertura, condições, descrições, relações, estimativas e numeração pronta para revisão do responsável. Nenhum comportamento foi implementado. Após autorização, renovar contexto/filhas/bloco e publicar exclusivamente as operações acima pelo MCP, conferindo o resultado antes de materializar task.md.
