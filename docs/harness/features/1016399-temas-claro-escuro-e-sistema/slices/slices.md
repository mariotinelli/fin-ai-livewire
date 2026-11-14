# Fatiamento de [WEB] [USUÁRIO] Escolher tema claro, escuro ou sistema

## Identidade e revisão

Pai: [#1016399](https://redmine.remsoft.com.br/issues/1016399). Projeto FinAi (65224), versão Livewire (20359). Revisão r002 aprovada por Mário, publicada e conferida após a correção sobre telas de acesso.

[Proposta r002 aprovada](r002/feature-proposta.md); [requisito canônico vigente](../feature.md); [prévia r001 preservada](slices-r001.md). A descrição remota e o requisito canônico representam a revisão r002 aprovada. As seis filhas foram publicadas e conferidas; o pai permanece New, sem implementação ou QA executada.

## Mudança funcional e impacto

Antes: visitantes escolhiam temas nas telas públicas, e a primeira DEV fornecia o seletor público. Depois: telas de acesso ficam sem seletor e acompanham automaticamente o dispositivo; a escolha manual/lembrada pertence só à área de trabalho. As telas de acesso ignoram, sem apagar, essa escolha autenticada. A política depende da superfície de acesso, inclusive quando confirmação de senha ou verificação de e-mail exigem sessão.

A mudança foi solicitada pelo responsável; esta prévia apresenta seu impacto completo. R1–R3 e CA01–CA06/CA08–CA09 mudam a política de escolha; R4–R6 e a cobertura visual/operacional CA07/CA10 continuam, com o acionamento da aparência ajustado por área.

| Entrega anterior | Revisão proposta | Horas antes → depois |
| --- | --- | ---: |
| D01 Escolha pública | D01 escolha autenticada e primeira paleta/estados; escolha pública retirada | 3,5 → 5 |
| D02 Seleção autenticada sobre base pública | D02 aparência automática de acesso sobre a base de D01 | 4 → 2 |
| D03 Sistema nos dois seletores | Sistema selecionável somente no menu autenticado | 1,5 → 1,5 |
| D04 Preferência nos dois acessos | Lembrança autenticada e separação das transições de acesso | 2,5 → 2,5 |
| Q01 Preferências | Trocar seleção pública por automático/separação entre áreas | 3 → 3 |
| Q02 Aparência/operações | Mesmo inventário; aparência de acesso acionada pelo dispositivo | 4,5 → 4 |

Consultas de todos os status por pai retornaram zero filhas. B01 e B02 estão fora do impacto, incluindo estimativas corrigidas por Mário, tarefas, CTs, DOCX e blocos. Preservar relação relates 955 com #1016270.

### Impacto por condição

| IDs anteriores | Tratamento |
| --- | --- |
| CT-001–CT-002 | Sistema selecionado exclusivo da área de trabalho |
| CT-003 | Retirada e ID reservado, sem reutilizar |
| CT-004 | Preservada: escolha pelo menu |
| CT-005–CT-007 | Escolha explícita/Sistema apenas na área de trabalho |
| CT-008–CT-011 | Lembrança autenticada separada da aparência de acesso |
| CT-012 | Obter as aparências das jornadas de acesso pelo dispositivo |
| CT-013 | Preservada: aparência autenticada |
| CT-014 | Mesmos estados, com acionamento por superfície |
| CT-015 | Três opções apenas no menu da conta |
| CT-016 | Preservada: operações, permissões e saídas das duas áreas |
| CT-017–CT-019 | Novas: automático sem seletor, mudança com preenchimento, acesso direto independente da preferência guardada |

## Inspeção e fronteiras

Layouts de acesso/trabalho ainda fixam remsoft claro e não há seleção ou lembrança implementada. Componentes usam amplamente cores semânticas e o menu existente pode receber a escolha. Não houve teste executado nesta revisão.

As quatro entregas têm resultados próprios: escolher no menu, receber aparência automática no acesso, escolher Sistema e retornar à opção lembrada. A base visual integra a primeira interação autenticada. Público automático e Sistema autenticado não são agrupados apenas por compartilharem a leitura do dispositivo.

## Prévia numerada

| Entrega | Título completo | Horas | Sequencing |
| --- | --- | ---: | ---: |
| D01 | [DEV] [WEB] [USUÁRIO] Escolher tema claro, escuro ou sistema - Escolha clara e escura no menu da conta | 5 | 45 |
| D02 | [DEV] [WEB] [USUÁRIO] Escolher tema claro, escuro ou sistema - Aparência automática nas telas de acesso | 2 | 46 |
| D03 | [DEV] [WEB] [USUÁRIO] Escolher tema claro, escuro ou sistema - Sistema como padrão e acompanhamento | 1.5 | 47 |
| D04 | [DEV] [WEB] [USUÁRIO] Escolher tema claro, escuro ou sistema - Preferência autenticada lembrada por navegador | 2.5 | 48 |
| Q01 | [QA] [WEB] [USUÁRIO] Escolher tema claro, escuro ou sistema - Preferências e transições de acesso | 3 | 49 |
| Q02 | [QA] [WEB] [USUÁRIO] Escolher tema claro, escuro ou sistema - Aparência e operações nas telas existentes | 4 | 50 |

Total: 18h. Esforço ativo incluindo verificação DEV e preparação/execução/registro/reteste dirigido nas QAs, sem espera por ambiente/aprovação.

Bloqueios: D01 → D02/D03/D04 pela base visual implementada; D01–D04 → Q01 e Q02 para campanhas completas. D02 e D03 não se bloqueiam entre si; D04 integra ambas para concluir sem bloqueios cíclicos. QAs compartilham preparação e consolidam resultados, sem bloqueio entre si. Sem novo bloqueio externo.

## Estimativas e revisão independente

Pareceres A/B após rever fronteiras: seleção autenticada 5,5h/5h; automático de acesso 2h/2h; Sistema 1,5h/1,5h; lembrança 2,5h/2,5h; QA funcional 3h/3h; QA visual 4,5h/4h. Proposta do condutor: 5h, 2h, 1,5h, 2,5h, 3h e 4h, total 18h. Reaproveitar cores semânticas e o inventário inspecionado sustenta 5h para a primeira seleção e 4h para a QA visual; não é média automática nem medição. Retirar seletor de acesso não elimina a adaptação/validação dessas telas nas duas aparências.

A referência humana de #1016270 e os números anteriores permanecem na r001. Não reestimar os Bugs corrigidos por Mário. Supor equipe familiarizada e ambiente disponível, incluindo preparo de atores/dados/contextos nas QAs.

## Cobertura

| Regra ou critério | Dono | Condições |
| --- | --- | --- |
| R1 Claro/Escuro autenticado | D01 | CT-004–CT-005 |
| R1 Sistema autenticado | D03 | CT-001–CT-002, CT-006–CT-007 |
| R1 Automático de acesso | D02 | CT-017–CT-018 |
| R2 Preferência autenticada | D04 | CT-008–CT-011, CT-019 |
| R3 Menu da conta | D01 Claro/Escuro / D03 Sistema | CT-004, CT-015 |
| R3 Sem seletor de acesso | D02 | CT-012, CT-017 |
| R4–R5 Área de trabalho e base comum | D01 | CT-013–CT-014 |
| R4–R5 Jornadas de acesso | D02 | CT-012, CT-014, CT-017–CT-018 |
| R6 Contexto em cada interação | D01 escolha / D02 automático / D03 Sistema / D04 restauração | CT-005–CT-011, CT-016, CT-018–CT-019 |
| CA01 Padrão | D02 acesso / D03 área de trabalho | CT-001–CT-002, CT-017 |
| CA02 Escolha | D01 Claro/Escuro / D03 Sistema | CT-004–CT-007 |
| CA03 Acompanhamento | D02 acesso / D03 área de trabalho | CT-006–CT-007, CT-018 |
| CA04–CA05 Continuidade/independência | D04 | CT-008–CT-010, CT-019 |
| CA06 Menu e ausência de seletor de acesso | D01/D03 menu / D02 acesso | CT-004, CT-015, CT-017 |
| CA07 Aparência/estados | D01 área de trabalho / D02 acesso | CT-012–CT-014 |
| CA08 Faixas/transições | D01/D03 menu / D02 acesso | CT-015, CT-017–CT-018 |
| CA09 Lembrança indisponível | D04 | CT-011 |
| CA10 Operações/saídas | D01 área de trabalho / D02 acesso; D03/D04 suas interações | CT-005, CT-016, CT-018 |

Nenhuma obrigação visual/operacional foi excluída. A escolha pública foi retirada por decisão expressa e a aparência automática tem dono e condições próprios. O pai só conclui após integrar três opções autenticadas, lembrança e política de acesso.

## Condições de teste

[Markdown r002](condicoes-teste-r002.md); [DOCX r002](<r002/1016399 - Condições de testes.docx>). São 18 condições ativas, CT-003 reservada e CT-017–CT-019 novas; fonte/Word r001 preservados.

Pai: [#1016399 — Escolher tema claro, escuro ou sistema](https://redmine.remsoft.com.br/issues/1016399).

Revisão: r002 — proposta funcional para revisão; ainda não executada. A revisão r001 permanece preservada.

### Contexto

Telas de acesso existentes seguem automaticamente o dispositivo, sem seletor: logins de cliente/administração/suporte, cadastro, recuperação/redefinição de senha, verificação de e-mail e confirmação de senha nas condições reais, inclusive quando houver sessão. Na área de trabalho autenticada, cliente, administrador e suporte escolhem no menu da conta conforme permissões. Preparar dispositivo em Claro/Escuro/sem preferência, campos preenchidos, escolha autenticada oposta ao dispositivo, contextos de navegador independentes e falha controlada de lembrança. Inventário visual inclui dashboard, perfil, notificações, usuários, perfis, alertas e comandos/histórico, componentes e estados existentes. Matriz: 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768 e 1366×768; transições 767/768 e 1024/1025px. Conferir marca/hierarquia de #1016270 e legibilidade; não há mockup ou paleta escura exata aprovada. Condições são verificações futuras, sem execução neste fluxo.

### CT-001 — Primeiro acesso à área de trabalho acompanha o dispositivo

Verificação: Em contexto sem escolha autenticada anterior, entrar na área de trabalho com dispositivo em Claro e repetir em Escuro.

Resultado esperado: Sistema fica selecionado no menu da conta e produz a aparência correspondente ao dispositivo.

Origem no requisito: R1, CA01.

### CT-002 — Padrão autenticado sem preferência válida

Verificação: Entrar na área de trabalho sem preferência escura do dispositivo; repetir com dados do site limpos ou preferência autenticada inválida.

Resultado esperado: Sistema é o padrão autenticado; sem preferência escura informada, a aparência é clara.

Origem no requisito: R1, CA01, CA05.

### CT-004 — Escolher tema no menu da conta

Verificação: Como cliente, administrador e suporte, abrir o menu da conta e escolher Claro e Escuro nas telas autorizadas.

Resultado esperado: O seletor fica disponível no menu da conta, altera a aparência atual e mantém os outros controles alcançáveis.

Origem no requisito: R3, R4, CA02, CA06.

### CT-005 — Preservar formulário e filtros na escolha autenticada

Verificação: Na área de trabalho, com formulário preenchido ou filtros aplicados, trocar o tema pelo menu da conta.

Resultado esperado: Campos e filtros já presentes permanecem; não é necessário salvar o perfil ou reiniciar a navegação, sem criar persistência entre recargas.

Origem no requisito: R6, CA02, CA10.

### CT-006 — Acompanhar mudança do sistema na área de trabalho

Verificação: Selecionar Sistema no menu da conta e alterar a aparência do dispositivo com a aplicação aberta.

Resultado esperado: A aparência autenticada acompanha a mudança e Sistema continua identificado como a opção selecionada.

Origem no requisito: R1, CA03.

### CT-007 — Manter escolha explícita

Verificação: Na área de trabalho, escolher Claro ou Escuro e alterar o dispositivo; depois voltar a Sistema.

Resultado esperado: A escolha explícita permanece; ao voltar a Sistema, o acompanhamento é retomado.

Origem no requisito: R1, CA03.

### CT-008 — Lembrar na navegação e no retorno autenticado

Verificação: Escolher cada opção na área de trabalho, navegar, recarregar e fechar/reabrir com dados do site preservados; voltar à área de trabalho.

Resultado esperado: A opção autenticada é restaurada; em Sistema, usa a preferência atual do dispositivo. Nenhuma persistência nova de formulário/filtros é criada.

Origem no requisito: R2, CA04.

### CT-009 — Preservar a preferência autenticada entre contas

Verificação: Escolher na área de trabalho, sair e entrar novamente com a mesma conta e com outra conta no mesmo navegador.

Resultado esperado: A tela de acesso segue o dispositivo sem apagar a preferência guardada; as entradas na área de trabalho restauram a mesma opção do navegador.

Origem no requisito: R2, CA04.

### CT-010 — Isolar navegadores e limpar dados

Verificação: Acessar a área de trabalho com a mesma conta em outro contexto sem dados e limpar os dados no contexto original.

Resultado esperado: Cada contexto sem opção própria inicia autenticado em Sistema; não há sincronização por conta. Telas de acesso seguem o dispositivo independentemente da opção guardada.

Origem no requisito: R2, CA05.

### CT-011 — Lembrança autenticada indisponível

Verificação: Impedir a lembrança no navegador e escolher um tema na área de trabalho.

Resultado esperado: A opção aplica-se à página autenticada atual e a aplicação permanece utilizável; outro acesso pode voltar ao padrão. A aparência de acesso não exige gravar uma opção.

Origem no requisito: R2, CA09.

### CT-012 — Comparar jornadas de acesso nas duas aparências automáticas

Verificação: Percorrer todas as telas de acesso abrangidas com dispositivo em Claro e Escuro, incluindo as que exigem sessão e seus estados existentes.

Resultado esperado: Sem seletor, marca, hierarquia, texto, campos, bordas, ícones e mensagens ficam coerentes e legíveis nas duas aparências automáticas.

Origem no requisito: R3, R4, R5, CA06, CA07.

### CT-013 — Comparar jornadas autenticadas em ambos os temas

Verificação: Percorrer dashboard, perfil, notificações, gestão e suporte, incluindo tabelas com dados/vazias e saída de comandos.

Resultado esperado: A identidade e a legibilidade se mantêm nas superfícies; conteúdo funcional continua reconhecível, sem áreas claras ou escuras incoerentes que impeçam o uso.

Origem no requisito: R4, R5, CA07.

### CT-014 — Conferir componentes e estados

Verificação: Abrir menus, diálogos e painéis; conferir foco, seleção, desabilitado, carregamento, sucesso, aviso, erro e vazio nas duas aparências. Nas telas de acesso usar o dispositivo; na área de trabalho usar as opções. Incluir envbar permitida.

Resultado esperado: Os estados continuam distinguíveis e legíveis, a navegação permanece alcançável e a identificação dos ambientes conserva seu significado.

Origem no requisito: R4, R5, CA07.

### CT-015 — Usar seletor autenticado na matriz responsiva

Verificação: Selecionar as três opções no menu da conta de cliente, administrador e suporte, em toda a matriz e nas transições.

Resultado esperado: O seletor autenticado e os demais controles permanecem alcançáveis, sem alargar a página ou encobrir conteúdo/ações.

Origem no requisito: R3, CA06, CA08.

### CT-016 — Conferir operações e saídas preservadas

Verificação: Executar as operações existentes nas telas de acesso, perfil, gestão e suporte abrangidas, nos dois temas; registrar por tela quais operações foram exercitadas, seus resultados e restrições, justificando os casos não aplicáveis. Conferir também impressão, PDF e exportação onde já disponíveis.

Resultado esperado: Resultados, permissões e contexto de uso são preservados; impressão, PDFs e arquivos exportados mantêm a aparência e regras anteriores, sem receber automaticamente o tema escuro.

Origem no requisito: R6, CA10.

### CT-017 — Aparência automática de acesso sem seletor

Verificação: Abrir todas as telas de acesso em dispositivo Claro, Escuro e sem preferência escura, incluindo toda a matriz e as transições.

Resultado esperado: Não há seletor em nenhuma tela/faixa. A aparência acompanha o dispositivo, com fallback claro, inclusive em telas de acesso que exigem sessão.

Origem no requisito: R1, R3, CA01, CA06, CA08.

### CT-018 — Mudança do dispositivo em acesso com campos preenchidos

Verificação: Abrir uma tela de acesso, preencher os campos e alterar a aparência do dispositivo com a página aberta.

Resultado esperado: A aparência atualiza automaticamente sem perder os campos/contexto já presentes, mantendo identidade e legibilidade; não cria persistência de campos entre acessos.

Origem no requisito: R1, R4, R5, R6, CA03, CA07, CA10.

### CT-019 — Preferência autenticada não controla acesso direto

Verificação: Guardar uma escolha autenticada oposta ao dispositivo e abrir diretamente uma tela de acesso em nova navegação e após reabrir o navegador; depois voltar à área de trabalho.

Resultado esperado: A tela de acesso segue o dispositivo, sem seletor e sem apagar a escolha autenticada. A área de trabalho restaura a opção guardada no mesmo navegador.

Origem no requisito: R1, R2, R3, CA04, CA05, CA06.

### ID retirado e reservado

CT-003 — Escolher tema nas telas públicas. Retirada porque Mário eliminou a escolha manual nas telas de acesso; não executar nem reutilizar esse ID. CT-017 e CT-018 verificam o novo comportamento automático.


## Descrições completas

### 1. [DEV] [WEB] [USUÁRIO] Escolher tema claro, escuro ou sistema - Escolha clara e escura no menu da conta

Papel: DEV. Estimativa: 5h. Sequencing: 45. Filha: [#1016408](https://redmine.remsoft.com.br/issues/1016408).

#### Entrega

Disponibilizar Claro e Escuro no menu da conta da área de trabalho autenticada, entregando junto a paleta e os estados compartilhados que tornam a escolha visível e utilizável em cliente, administração e suporte.

#### Escopo e limites

Cobrir dashboard atual, perfil, notificações, Usuários, Perfis de acesso, Alertas de erros, executor e Histórico de comandos conforme permissões existentes. A paleta e os estados comuns integram esta primeira interação real; não são preparação interna separada. A aparência automática nas telas de acesso, a opção Sistema e a lembrança por navegador têm entregas próprias. Não oferecer uma opção Sistema inoperante; o pai só estará completo com as três opções.

#### Critérios de aceite

- Cliente, administrador e suporte encontram o seletor no menu da conta das telas já autorizadas e alternam Claro/Escuro na tela atual; a opção escolhida fica identificável e os outros controles do menu continuam alcançáveis.
- Alternar com formulário preenchido ou filtros aplicados mantém campos, critérios e contexto; não exige salvar perfil ou sair e entrar novamente.
- Claro preserva marca, hierarquia e identidade FinAI; Escuro adapta superfícies, textos, bordas, ícones e estados com legibilidade em dashboard, perfil, notificações, gestão e suporte, incluindo tabelas e saída de comandos. Não há paleta escura exata ou mockup aprovado.
- Menus, diálogos, painéis laterais, seleção, foco, desabilitado, carregamento, sucesso, aviso, erro e estados vazios conservam o significado e a legibilidade.
- Conferir menu da conta e superfícies autenticadas em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768 e 1366×768, incluindo 767/768px e 1024/1025px; a seleção não alarga a página nem encobre conteúdo, navegação ou ações.
- Permissões, resultados de operações e impressão/PDF/exportações disponíveis mantêm as regras e aparência anteriores; envbar permitida conserva informações e distinções legíveis.

#### Dependências

Não há bloqueio de início nem novo fornecedor externo. Usa a identidade FinAI existente de #1016270. Fornece a base visual compartilhada implementada e verificável às demais entregas de temas.

#### Referências

[Feature #1016399](https://redmine.remsoft.com.br/issues/1016399), revisão funcional r002 proposta. [Identidade visual #1016270](https://redmine.remsoft.com.br/issues/1016270), aplicada às telas e estados existentes. Sem mockup de seletor ou paleta escura exata; seguir R4–R5 e a decisão de retirar o seletor das telas de acesso.

Cobertura: R1 Claro/Escuro; R3–R6 na área de trabalho; CA02, CA06–CA08 e CA10 nessas superfícies. Condições: CT-004, CT-005, CT-013–CT-016 na área de trabalho, revisão r002 do documento do pai #1016399.

Origem: project-slices:1016399:r002:D01.

### 2. [DEV] [WEB] [USUÁRIO] Escolher tema claro, escuro ou sistema - Aparência automática nas telas de acesso

Papel: DEV. Estimativa: 2h. Sequencing: 46. Filha: [#1016409](https://redmine.remsoft.com.br/issues/1016409).

#### Entrega

Aplicar automaticamente a aparência do dispositivo às jornadas de acesso existentes, sem seletor de tema. Reaproveitar a paleta compartilhada e adaptar as superfícies de acesso, mantendo a preferência explícita da área de trabalho fora dessas telas.

#### Escopo e limites

Abranger logins, cadastro, recuperação/redefinição de senha, verificação de e-mail e confirmação de senha conforme acesso real, inclusive quando houver sessão. A política depende da superfície de acesso, não apenas da existência de usuário autenticado. Não criar novas páginas públicas. Esta entrega não guarda nem apaga a escolha da área de trabalho.

#### Critérios de aceite

- Todas as telas de acesso abrangidas ficam sem seletor e usam a aparência atual do dispositivo; sem preferência escura informada, usam Claro.
- Alterar a aparência do dispositivo com a tela de acesso aberta atualiza a página sem perder campos, mensagens ou contexto já presentes.
- A aparência automática da tela de acesso não depende da escolha explícita usada na área de trabalho e não cria uma preferência manual própria.
- Nas duas aparências automáticas, marca, hierarquia, superfícies, textos, bordas, ícones, campos e estados de foco/seleção/desabilitado/carregamento/sucesso/aviso/erro ficam coerentes e legíveis. Manter a identidade de #1016270, sem mockup escuro inventado.
- Conferir todas as jornadas de acesso em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768 e 1366×768 e 767/768px e 1024/1025px, inclusive telas que exigem sessão: sem seletor, sem alargar a página ou encobrir conteúdo/ações.
- Operações, validações e restrições existentes são preservadas. Envbar permitida mantém informações e distinções legíveis; impressão/PDF/exportações não recebem automaticamente a aparência escura.

#### Dependências

Bloqueio de início pela base visual de “Escolher tema claro, escuro ou sistema - Escolha clara e escura no menu da conta”. Reaproveitar a observação do dispositivo com a entrega “Sistema como padrão e acompanhamento”, sem duplicar trabalho. Não aguarda a lembrança autenticada para funcionar; o caso de preferência guardada oposta ao dispositivo é integrado pela entrega de lembrança.

#### Referências

[Feature #1016399](https://redmine.remsoft.com.br/issues/1016399), revisão funcional r002 proposta. [Identidade visual #1016270](https://redmine.remsoft.com.br/issues/1016270), aplicada às telas e estados existentes. Sem mockup de seletor ou paleta escura exata; seguir R4–R5 e a decisão de retirar o seletor das telas de acesso.

Cobertura: R1 aparência de acesso; R3 sem seletor; R4–R6 nas jornadas de acesso; CA01, CA03 e CA06–CA10 nessas superfícies. Condições: CT-012, CT-014, CT-016 nas jornadas de acesso; CT-017–CT-018, revisão r002 do documento do pai #1016399.

Origem: project-slices:1016399:r002:D02.

### 3. [DEV] [WEB] [USUÁRIO] Escolher tema claro, escuro ou sistema - Sistema como padrão e acompanhamento

Papel: DEV. Estimativa: 1.5h. Sequencing: 47. Filha: [#1016410](https://redmine.remsoft.com.br/issues/1016410).

#### Entrega

Acrescentar Sistema como terceira opção no menu da conta da área de trabalho autenticada, como padrão sem escolha válida e com acompanhamento da aparência do dispositivo.

#### Escopo e limites

A escolha explícita Claro/Escuro permanece prioritária até o usuário voltar a Sistema. Não duplicar a seleção ou a paleta nem implementar a lembrança persistente, que pertence à tarefa própria.

#### Critérios de aceite

- Sem escolha autenticada anterior válida, Sistema fica selecionado no menu da conta e produz a aparência do dispositivo; sem preferência escura, produz Claro.
- O menu da conta apresenta exatamente Claro, Escuro e Sistema e identifica a opção selecionada; Sistema continua identificado mesmo quando sua aparência resultante é clara ou escura.
- Em Sistema, alterar a preferência do dispositivo com a aplicação aberta atualiza a área de trabalho. Em Claro/Escuro explícitos, manter a escolha mesmo com mudança do dispositivo.
- Voltar a Sistema retoma o acompanhamento e não limpa campos, filtros ou contexto já presentes.
- Conferir a opção nas áreas permitidas de cliente/administração/suporte em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768 e 1366×768, incluindo 767/768px e 1024/1025px, sem alargar a página ou encobrir controles. Telas de acesso permanecem sem seletor.

#### Dependências

Bloqueio de início pela primeira seleção/base visual de “Escolher tema claro, escuro ou sistema - Escolha clara e escura no menu da conta”. A aparência automática das telas de acesso compartilha o acompanhamento do dispositivo, sem bloqueio nativo adicional entre as duas entregas. Não aguarda a lembrança autenticada para a interação atual funcionar.

#### Referências

[Feature #1016399](https://redmine.remsoft.com.br/issues/1016399), revisão funcional r002 proposta. [Identidade visual #1016270](https://redmine.remsoft.com.br/issues/1016270), aplicada às telas e estados existentes. Sem mockup de seletor ou paleta escura exata; seguir R4–R5 e a decisão de retirar o seletor das telas de acesso.

Cobertura: R1 opções/padrão autenticado; R3 e R6 nessa interação; CA01–CA03, CA06 e CA08 na área de trabalho. Condições: CT-001, CT-002, CT-006, CT-007, CT-015, revisão r002 do documento do pai #1016399.

Origem: project-slices:1016399:r002:D03.

### 4. [DEV] [WEB] [USUÁRIO] Escolher tema claro, escuro ou sistema - Preferência autenticada lembrada por navegador

Papel: DEV. Estimativa: 2.5h. Sequencing: 48. Filha: [#1016411](https://redmine.remsoft.com.br/issues/1016411).

#### Entrega

Lembrar a escolha Claro, Escuro ou Sistema da área de trabalho no navegador e restaurá-la ao retornar, sem aplicar essa escolha às telas de acesso e sem vinculá-la ao perfil.

#### Escopo e limites

A persistência não sincroniza contas ou dispositivos. As escolhas e o acompanhamento do sistema têm fornecedores próprios; esta entrega integra suas três opções sem recriar os seletores.

#### Critérios de aceite

- Escolher cada opção na área de trabalho, navegar, recarregar e fechar/reabrir com dados do site preservados mantém a escolha ao voltar à área de trabalho; em Sistema, usar a preferência atual do dispositivo.
- Sair da conta não apaga a preferência guardada. A tela de acesso segue o dispositivo; entrar novamente, inclusive com outra conta no mesmo navegador, restaura a escolha autenticada.
- Com escolha autenticada oposta ao dispositivo, abrir diretamente tela de acesso em nova navegação/reabertura usa o dispositivo sem apagar a opção; retornar à área de trabalho restaura a escolha.
- Outro contexto sem dados inicia a área de trabalho em Sistema; limpar os dados também restaura esse padrão. Não sincronizar por conta ou dispositivos.
- Se não puder lembrar a opção, aplicar à página autenticada atual e manter a aplicação utilizável; no próximo acesso, pode voltar ao padrão. A aparência de acesso não exige gravar opção.
- Aplicar/restaurar tema preserva somente o estado que a página já conserva, sem nova persistência de campos/filtros entre recargas ou retornos.

#### Dependências

Bloqueio de início pela primeira seleção/base visual de “Escolher tema claro, escuro ou sistema - Escolha clara e escura no menu da conta”. Pode começar sem aguardar Sistema e aparência de acesso; para concluir, integrar as três opções de “Sistema como padrão e acompanhamento” e as transições para “Aparência automática nas telas de acesso”. São integrações de conclusão, sem bloqueios nativos entre essas tarefas.

#### Referências

[Feature #1016399](https://redmine.remsoft.com.br/issues/1016399), revisão funcional r002 proposta. [Identidade visual #1016270](https://redmine.remsoft.com.br/issues/1016270), aplicada às telas e estados existentes. Sem mockup de seletor ou paleta escura exata; seguir R4–R5 e a decisão de retirar o seletor das telas de acesso.

Cobertura: R2; R1 na restauração; R6 na continuidade; CA04, CA05, CA09. Condições: CT-008–CT-011, CT-019, revisão r002 do documento do pai #1016399.

Origem: project-slices:1016399:r002:D04.

### 5. [QA] [WEB] [USUÁRIO] Escolher tema claro, escuro ou sistema - Preferências e transições de acesso

Papel: QA. Estimativa: 3h. Sequencing: 49. Filha: [#1016412](https://redmine.remsoft.com.br/issues/1016412).

#### Entrega

Validar a escolha autenticada, Sistema e lembrança por navegador, bem como a separação entre essa preferência guardada e a aparência automática das telas de acesso.

#### Escopo e limites

Preparar contextos independentes, mudança de aparência e falha controlada de lembrança. A varredura visual completa de superfícies e operações fica na QA “Aparência e operações nas telas existentes”, sem reduzir a validação funcional desta tarefa.

#### Critérios de aceite

- Executar CT-001, CT-002, CT-004–CT-011, CT-015 e CT-017–CT-019 em suas verificações funcionais, registrando contexto, resultado e evidências de desvios; CT-003 foi retirada e seu ID está reservado.
- Conferir as três opções no menu da conta, Sistema padrão/dinâmico e prioridade das escolhas explícitas, preservando campos/filtros já presentes.
- Conferir lembrança em navegação/recarga/reabertura, entrada/saída/troca de conta, contextos independentes, limpeza de dados e falha controlada de armazenamento.
- Confirmar ausência de seletor nas telas de acesso, inclusive as que exigem sessão; usar dispositivo Claro/Escuro/sem preferência e mudança com campos preenchidos.
- Usar uma escolha autenticada oposta ao dispositivo para comprovar que acesso direto/logout seguem o dispositivo sem apagar a preferência, e que nova entrada a restaura.
- Exercitar as opções autenticadas e o automático de acesso em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768 e 1366×768 e 767/768px e 1024/1025px, mantendo controles alcançáveis.
- Usar o DOCX r002 do pai #1016399 e compartilhar resultados com a QA visual para a conferência final, sem substituir a comparação visual por testes de lógica.

#### Dependências

A campanha completa aguarda as quatro DEV do pai: escolha no menu da conta, aparência automática de acesso, Sistema e lembrança autenticada. Preparação de contextos pode ser antecipada.

#### Referências

[Feature #1016399](https://redmine.remsoft.com.br/issues/1016399), revisão funcional r002 proposta. [Identidade visual #1016270](https://redmine.remsoft.com.br/issues/1016270), aplicada às telas e estados existentes. Sem mockup de seletor ou paleta escura exata; seguir R4–R5 e a decisão de retirar o seletor das telas de acesso.

Cobertura: R1–R3 e R6; CA01–CA06, CA08–CA10 em preferências/transições. Condições: CT-001, CT-002, CT-004–CT-011, CT-015, CT-017–CT-019, revisão r002 do documento do pai #1016399.

Origem: project-slices:1016399:r002:Q01.
#### Documento de condições

[Condições de teste de #1016399 — r002](https://redmine.remsoft.com.br/attachments/download/3381/1016399%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx).

### 6. [QA] [WEB] [USUÁRIO] Escolher tema claro, escuro ou sistema - Aparência e operações nas telas existentes

Papel: QA. Estimativa: 4h. Sequencing: 50. Filha: [#1016413](https://redmine.remsoft.com.br/issues/1016413).

#### Entrega

Validar a cobertura visual de Claro e Escuro em todas as telas existentes abrangidas e a preservação das operações, consolidando o resultado com a QA de escolha e continuidade.

#### Escopo e limites

Cobertura pública: Login de cliente, administração e suporte; cadastro; recuperação e redefinição de senha; verificação de e-mail e confirmação de senha, conforme as condições reais de acesso. Cobertura autenticada: Dashboard atual, perfil, notificações, Usuários, Perfis de acesso, Alertas de erros, executor e Histórico de comandos Artisan, conforme permissões de cliente, administrador e suporte. Conferir identidade, estados e legibilidade por comparação humana, sem exigir uma paleta escura ou mockup que não foram aprovados.

#### Critérios de aceite

- Executar CT-012–CT-014 e CT-016 no inventário completo; usar CT-015 e CT-017–CT-018 para a composição visual nas faixas e transições.
- Nas telas de acesso, obter as duas aparências pelo dispositivo, sem seletor. Na área de trabalho, obter pelo menu da conta; incluir cliente, administração e suporte conforme acessos.
- Comparar a identidade clara e a hierarquia FinAI de #1016270; em Escuro, conferir adaptação legível de superfícies, bordas, textos, ícones e estados, sem paleta exata inventada.
- Conferir tabelas com dados/vazias, formulários, erros, foco, seleção, desabilitado, carregamento, sucesso, avisos, menus, diálogos, painéis, notificações, envbar permitida e saída de comandos.
- Percorrer 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768 e 1366×768 e 767/768px e 1024/1025px; as telas de acesso ficam sem seletor e a área de trabalho mantém o menu utilizável sem alargar a página ou encobrir ações.
- Registrar por tela as operações existentes exercitadas nas duas aparências, resultados/restrições e casos não aplicáveis. Impressão, PDFs e exportações mantêm suas regras e aparência anteriores.
- Consolidar com a QA de preferências o resultado integrado, registrar desvios e um reteste dirigido, sem declarar aprovação antes das duas campanhas. Usar o DOCX integral r002 do pai #1016399.

#### Dependências

A campanha completa aguarda as quatro DEV do pai. A QA “Preferências e transições de acesso” fornece seus resultados à conferência final; não há bloqueio de início entre as duas QAs.

#### Referências

[Feature #1016399](https://redmine.remsoft.com.br/issues/1016399), revisão funcional r002 proposta. [Identidade visual #1016270](https://redmine.remsoft.com.br/issues/1016270), aplicada às telas e estados existentes. Sem mockup de seletor ou paleta escura exata; seguir R4–R5 e a decisão de retirar o seletor das telas de acesso.

Cobertura: R3–R6; CA06–CA08 e CA10 na aparência/operações. Condições: CT-012–CT-018 na cobertura visual/operações, revisão r002 do documento do pai #1016399.

Origem: project-slices:1016399:r002:Q02.
#### Documento de condições

[Condições de teste de #1016399 — r002](https://redmine.remsoft.com.br/attachments/download/3382/1016399%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx).

## Publicação autorizada

- Servidor: https://redmine.remsoft.com.br. Usuário consultado: Mário Tinelli (131789).
- Atualizar só a descrição gerenciada do pai #1016399 para o conteúdo integral de Objetivo até Fora do escopo de [feature-proposta.md](r002/feature-proposta.md), preservando marcadores project-flow e conteúdo humano externo. Manter status New, versão Livewire e campos alheios.
- Na referência remota do pai, usar [#1016399](https://redmine.remsoft.com.br/issues/1016399) e a origem textual project-flow:2026-11-14-temas-e-responsividade:T01. Substituir o antigo marcador de caminho local por essa identidade; a correspondência ao requisito canônico fica apenas no documento local.
- Criar as seis filhas desta prévia: tracker Task (4), status New (1), prioridade Normal (4), projeto 65224, versão 20359, pai #1016399, sem categoria, responsável ou datas. Títulos, descrições, estimativas e Sequencing são os acima.
- Publicar integralmente Entrega, Escopo e limites, Critérios de aceite, Dependências e Referências de cada filha com sua origem textual r002, sem caminhos locais no texto remoto.
- Criar blocks: D01 → D02/D03/D04 e cada D01/D02/D03/D04 → Q01 e Q02; usar IDs confirmados. Preservar relação 955 e relações alheias. Sem bloqueio com os Bugs ou entre QAs.
- Atribuir Sequencing 45–50 às filhas e 45 ao pai, sem posição extra; preservar demais campos, status e anexos.
- Anexar o DOCX 1016399 - Condições de testes.docx, r002, às duas QAs. Q01 cobre preferências/transições e Q02 aparência/operações com consolidação final, conforme critérios; ambas recebem o documento integral.
- Após aprovação/readback, atualizar o requisito canônico local e materializar task.md por ID confirmado. Não criar planning.md nem implementar.

## Sequencing

Campo Sequencing (2). Leitura MCP completa anterior: 46/46 issues FinAi/Livewire, todos os status/trackers, maior posição 37, sem valor inválido. Esta revisão mantém seis filhas, bloco 45–50 e âncora 45. B01 38–39 e B02 40–44 não mudam. Renovar leitura integral antes de publicar; conciliar concorrência sem mudar números autorizados silenciosamente.

## Revisão e publicação

Conjunto completo aprovado por Mário nesta conversa. As operações foram executadas e relidas; IDs e resultados estão na tabela de publicação confirmada abaixo. Não há operação incerta ou bloqueio de publicação.

## Documento Word conferido

O Word r002 foi gerado com Microsoft Word 16.0 e conferido por ZIP/OpenXML: 18 condições ativas e texto equivalente integralmente à fonte Markdown após normalizar a apresentação de títulos/links. O ID CT-003 está reservado. Os arquivos r001 permanecem preservados; o Word r002 está associado às duas QAs e referenciado nas descrições.

## Resultado e pendências

Slicing integralmente publicado e conferido. [D01 #1016408](https://redmine.remsoft.com.br/issues/1016408); [D02 #1016409](https://redmine.remsoft.com.br/issues/1016409); [D03 #1016410](https://redmine.remsoft.com.br/issues/1016410); [D04 #1016411](https://redmine.remsoft.com.br/issues/1016411); [Q01 #1016412](https://redmine.remsoft.com.br/issues/1016412); [Q02 #1016413](https://redmine.remsoft.com.br/issues/1016413). Total 18h; bloco 45–50, pai espelhando 45. DOCX confirmado: [QA #1016412, anexo 3381](https://redmine.remsoft.com.br/attachments/download/3381/1016399%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx); [QA #1016413, anexo 3382](https://redmine.remsoft.com.br/attachments/download/3382/1016399%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx). Arquivos task.md por ID materializados após readback. Próximo passo: plan-issue nas DEVs, respeitando os fornecedores declarados; QAs aguardam implementação. Não houve implementação ou execução de testes do produto.

## Publicação aprovada — execução

Mário aprovou o conjunto completo nesta conversa, incluindo revisão funcional r002 de temas, estimativas corrigidas dos Bugs, Sequencing, relações e DOCX. A identidade textual portátil substitui os caminhos locais na nova publicação; a correspondência ao documento permanece aqui.

| Entrega autorizada | ID/URL confirmado | Resultado | Próximo passo |
| --- | --- | --- | --- |
| D01 | [#1016408](https://redmine.remsoft.com.br/issues/1016408) | Campos, descrição, relações e numeração conferidos | Pronta para plan-issue após fornecedor declarado |
| D02 | [#1016409](https://redmine.remsoft.com.br/issues/1016409) | Campos, descrição, relações e numeração conferidos | Pronta para plan-issue após fornecedor declarado |
| D03 | [#1016410](https://redmine.remsoft.com.br/issues/1016410) | Campos, descrição, relações e numeração conferidos | Pronta para plan-issue após fornecedor declarado |
| D04 | [#1016411](https://redmine.remsoft.com.br/issues/1016411) | Campos, descrição, relações e numeração conferidos | Pronta para plan-issue após fornecedor declarado |
| Q01 | [#1016412](https://redmine.remsoft.com.br/issues/1016412) | Campos, descrição, relações e numeração conferidos; DOCX 3381 associado | Aguardar implementação para executar QA |
| Q02 | [#1016413](https://redmine.remsoft.com.br/issues/1016413) | Campos, descrição, relações e numeração conferidos; DOCX 3382 associado | Aguardar implementação para executar QA |

Pais permanecem no status atual; anexos e relações existentes serão preservados. Nenhuma implementação autorizada por esta publicação.


## Conferência final do conjunto

Leitura completa final: 59 de 59 issues de FinAi/Livewire; bloco 38–50 sem colisões indevidas, âncoras 38/40/45 e Sequencing das issues alheias preservados. Pais e filhas relidos; descrições, estimativas, versão, prioridade, relações e anexos confirmados. Publicações usam apenas IDs/URLs remotos e identidades textuais portáteis; caminhos de código/fontes ficam no contexto local. Não foram duplicadas as capturas já acessíveis nos pais.

