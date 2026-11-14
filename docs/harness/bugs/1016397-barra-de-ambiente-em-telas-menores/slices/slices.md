# Fatiamento de [WEB] [SUPORTE] Corrigir barra de ambiente em telas menores

## Identidade

Pai: [#1016397](https://redmine.remsoft.com.br/issues/1016397); [requisito aprovado](../bug.md).

Projeto FinAi (65224), versão Livewire (20359). Revisão r001 aprovada por Mário, publicada e conferida. Filhas, relações, Sequencing e DOCX confirmados; pais mantidos em New. Nenhuma implementação ou execução QA realizada.

## Inspeção e fronteiras

`resources/views/components/dev/bar.blade.php` tem altura fixa, composição em coluna e não oferece expansão; `resources/views/livewire/dev/env-bar.blade.php` mostra ambiente e branch; `app/Dev/Livewire/EnvBar.php::branch()` fornece a branch apenas em local; `app/Dev/Livewire/Login.php` mantém autorização por withEnvBar e o login existente. Os layouts `resources/views/layouts/app.blade.php` e `guest.blade.php` subtraem --dev-bar-height da área da página. `tests/Feature/Dev/Livewire/EnvBarTest.php` e `LoginTest.php` exercitam contratos de preservação, mas não demonstram a nova expansão ou adaptação visual.

Classificação: adaptação da apresentação existente com o comportamento aprovado. Nenhum critério foi classificado como integralmente existente para omitir DEV. Testes e código foram lidos, não executados; as evidências de leitura não comprovam conformidade em navegador. Não há necessidade de Study identificada.

## Prévia numerada

| Entrega | Título completo | Horas | Sequencing |
| --- | --- | ---: | ---: |
| D01 | [DEV] [WEB] [SUPORTE] Corrigir barra de ambiente em telas menores - Barra compacta e expansão no celular | 2 | 38 |
| Q01 | [QA] [WEB] [SUPORTE] Corrigir barra de ambiente em telas menores | 1 | 39 |

Total: 3h. Todos os valores são esforço ativo, incluem verificação DEV e preparação/execução/registro/reteste dirigido QA nas respectivas tarefas; excluem espera por ambiente ou aprovação.

Relações nativas propostas: D01 → Q01 (`blocks`). Sem bloqueio externo novo. As relações `relates` dos pais com #1016270 serão preservadas; a ordem de catálogo não cria bloqueios entre os três pais.

## Estimativas e revisão independente

Avaliações independentes A/B: D01 3h/3h e QA 2h/2h. Proposta inicial do agente: 3h e 2h pela integração de altura nos dois layouts e campanha completa. A expansão, consulta de branch e acesso ao login ficam juntas porque os detalhes precisam ser utilizáveis ao abrir a barra.

Duas avaliações independentes por entrega, uma focada em resultado/trabalho restante e outra em reaproveitamento/sobreposição/testes. Referência humana local: #1016270, com 1,5h para identidade no dashboard, 2h para cada jornada/layout e QA integral de 4h, conforme seu slices.md. Os valores não foram copiados: esta proposta considera novas interações e o reaproveitamento observado. Suposições: equipe familiarizada com o projeto e ambiente de homologação disponível com dados/atores a preparar; não há medição de tempo real nem redução presumida por uso de IA.

Correção explícita de Mário nesta conversa: D01 2h e Q01 1h, total 3h. Estes são os valores vigentes, preservando escopo e cobertura; a proposta inicial de 5h e as avaliações independentes acima são mantidas como histórico. Trata-se de calibração do responsável, não medição ou nova estimativa independente.

## Cobertura

| Regra ou critério | Dono da entrega | Condições QA |
| --- | --- | --- |
| CC01 | D01 | CT-001 |
| CC02 | D01 | CT-002–CT-003 |
| CC03 | D01 | CT-004 |
| CC04 | D01 | CT-005 |
| CC05 | D01 | CT-006–CT-007 |
| CC06 | D01 | CT-004, CT-008 |

Critérios transversais são particionados por região/canal/interação, sem recriar o mesmo comportamento em várias tarefas. QA cobre o pai integralmente; nenhum critério foi excluído.

## Condições de teste

Fonte: [condicoes-teste-r001.md](condicoes-teste-r001.md). Documento Word: [1016397 - Condições de testes.docx](<r001/1016397 - Condições de testes.docx>).

Pai: [#1016397 — Corrigir barra de ambiente em telas menores](https://redmine.remsoft.com.br/issues/1016397).

Revisão: r001 — proposta para revisão; ainda não executada.

### Contexto

Usar um ambiente que já permita a envbar, uma branch longa e usuários permitidos para troca. Conferir Usuários no layout autenticado e uma tela pública que permita a barra. A regra vigente habilita a barra em local/testing, em QA/homolog com as condições existentes e a oculta nos demais contextos. Não habilitar acesso novo. Comparar a falha registrada na evidência E01 (anexo 3373) com o comportamento compacto/expansível aprovado, sem usar a captura como mockup final. Matriz: 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768 e 1366×768; conferir 767/768px. Preparação, comparações visuais, ações de login e reteste dirigido fazem parte da QA; não há resultado de teste executado neste documento.

### CT-001 — Estado inicial compacto

Verificação: Abrir a lista de Usuários nas larguras de celular, com envbar habilitada e branch longa.

Resultado esperado: Até 767px, o ambiente e o controle de expansão ficam visíveis, sem corte nem aumento da largura causado pela barra.

Origem no requisito: CC01.

### CT-002 — Expandir e consultar a branch

Verificação: Expandir a barra e consultar a identificação de branch completa, inclusive um nome longo.

Resultado esperado: O nome completo fica consultável e seleção de usuário e LOGIN são alcançáveis dentro do espaço disponível.

Origem no requisito: CC02.

### CT-003 — Recolher a barra

Verificação: Com a barra expandida, recolher e expandir novamente.

Resultado esperado: Retorna ao estado compacto e continua permitindo acessar as informações e controles ao reabrir.

Origem no requisito: CC02.

### CT-004 — Conteúdo e navegação nos dois estados

Verificação: Na tela pública e na autenticada, rolar e acessar o conteúdo e a navegação com a barra compacta e expandida.

Resultado esperado: A barra não encobre conteúdo, mensagens, navegação ou ações nem provoca rolagem horizontal global; problemas próprios da tabela ficam em B02.

Origem no requisito: CC03, CC06.

### CT-005 — Redimensionar com a barra aberta e fechada

Verificação: Percorrer a matriz de viewports e a transição 767/768px em ambos os estados, nos dois layouts.

Resultado esperado: Informações e controles continuam alcançáveis em cada composição; o espaço reservado à página acompanha a apresentação da barra.

Origem no requisito: CC04.

### CT-006 — Trocar usuário com LOGIN

Verificação: Expandir, selecionar um usuário permitido e usar LOGIN, observando conta e destino resultantes.

Resultado esperado: A ação conserva o resultado e as restrições atuais; a adaptação visual não cria novas opções de usuário ou acesso.

Origem no requisito: CC05.

### CT-007 — Barra sem branch disponível

Verificação: Usar um contexto permitido em que a branch não esteja disponível e abrir/recolher quando aplicável.

Resultado esperado: Ambiente e controles permanecem utilizáveis sem uma área de texto quebrada ou conteúdo indevido.

Origem no requisito: CC05.

### CT-008 — Condições de habilitação preservadas

Verificação: Conferir um contexto já permitido e outro no qual a envbar deve permanecer ausente.

Resultado esperado: A barra aparece apenas conforme as condições vigentes e a correção não a habilita em contextos proibidos.

Origem no requisito: CC06.


## Descrições completas

### 1. [DEV] [WEB] [SUPORTE] Corrigir barra de ambiente em telas menores - Barra compacta e expansão no celular

Papel: DEV. Estimativa: 2h. Sequencing: 38. Filha: [#1016401](https://redmine.remsoft.com.br/issues/1016401).

#### Entrega

A barra atual ocupa uma altura fixa e não permite recolher seus detalhes. Torná-la compacta no celular, permitindo expandir e recolher a identificação de branch e os controles de login, com o espaço da página ajustado nos layouts público e autenticado.

#### Escopo e limites

A consulta da branch e o uso do LOGIN integram a mesma expansão; seu acesso completo é necessário para que a interação seja útil. Preservar a aparência e o significado da identificação de ambiente, as condições de habilitação da barra e os efeitos e restrições do login. Não corrigir as tabelas nesta tarefa.

#### Critérios de aceite

- Até 767px, a barra inicia compacta com ambiente e controle de expansão visíveis, sem corte ou aumento da largura causado pela barra.
- Ao expandir, o nome completo da branch longa pode ser consultado e seleção de usuário e LOGIN ficam alcançáveis. Recolher e reabrir continuam funcionando.
- Com a barra compacta ou expandida, conteúdo e navegação dos layouts público e autenticado permanecem utilizáveis e não ficam encobertos.
- Conferir 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768 e 1366×768 e a transição 767/768px, redimensionando com a barra aberta e fechada; informações e controles permanecem alcançáveis.
- Quando a branch não estiver disponível, não apresentar uma área de texto quebrada; ambiente e controles continuam utilizáveis.
- Selecionar um usuário permitido e usar LOGIN mantém o resultado e as restrições atuais. Contextos que não permitem a envbar continuam sem exibi-la.
- Comparar a falha E01 com a correção: a composição compacta/expansível aprovada substitui o corte de conteúdo, preservando a linguagem visual existente.

#### Dependências

Não há bloqueios de início ou fornecedores externos. A integração entre a barra e o espaço disponível nos dois layouts faz parte desta entrega.

#### Referências

[Pai #1016397](https://redmine.remsoft.com.br/issues/1016397). [Identidade visual #1016270](https://redmine.remsoft.com.br/issues/1016270); identidade e componentes aplicáveis às telas existentes. Evidências do defeito: [E01 — Barra de ambiente em tela menor; captura original de 14/11/2026 às 10:27:39.](https://redmine.remsoft.com.br/attachments/download/3373/e01-envbar-tela-menor.png).

Cobertura: CC01–CC06. Condições: CT-001–CT-008, na revisão r001 do DOCX do pai 1016397. As condições e critérios visuais se aplicam às telas/estados da entrega; a captura de defeito não é mockup final.

Origem: project-slices:1016397:r001:D01.

### 2. [QA] [WEB] [SUPORTE] Corrigir barra de ambiente em telas menores

Papel: QA. Estimativa: 1h. Sequencing: 39. Filha: [#1016402](https://redmine.remsoft.com.br/issues/1016402).

#### Entrega

Validar a correção completa da barra de ambiente nos layouts público e autenticado, comparando a falha E01 ao comportamento compacto e expansível aprovado.

#### Escopo e limites

Preparar branch longa, usuário permitido e contextos com e sem habilitação da barra; executar as condições e um reteste dirigido dos defeitos encontrados. Não tratar problemas próprios da tabela como ampliação deste Bug.

#### Critérios de aceite

- Executar CT-001–CT-008 e registrar, por condição, contexto, resultado observado e evidência dos desvios encontrados.
- Conferir os estados compacto/expandido em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768 e 1366×768, a transição 767/768px e redimensionamento com a barra aberta e fechada nos dois layouts.
- Conferir branch completa e ausente, LOGIN permitido, preservação das restrições e ausência da barra onde não é habilitada.
- Confirmar que a barra não encobre conteúdo/navegação nem provoca rolagem horizontal global; comparar visualmente a região com a falha E01 e a adaptação aprovada.
- Utilizar o DOCX do pai #1016397, revisão r001, como conjunto completo de condições; registrar defeitos e resultado do reteste dirigido sem afirmar aprovação antes da execução.

#### Dependências

A execução integral aguarda “Corrigir barra de ambiente em telas menores - Barra compacta e expansão no celular”. A preparação de dados pode ocorrer antes.

#### Referências

[Pai #1016397](https://redmine.remsoft.com.br/issues/1016397). [Identidade visual #1016270](https://redmine.remsoft.com.br/issues/1016270); identidade e componentes aplicáveis às telas existentes. Evidências do defeito: [E01 — Barra de ambiente em tela menor; captura original de 14/11/2026 às 10:27:39.](https://redmine.remsoft.com.br/attachments/download/3373/e01-envbar-tela-menor.png).

Cobertura: CC01–CC06. Condições: CT-001–CT-008, na revisão r001 do DOCX do pai 1016397. As condições e critérios visuais se aplicam às telas/estados da entrega; a captura de defeito não é mockup final.

Origem: project-slices:1016397:r001:Q01.
#### Documento de condições

[Condições de teste de #1016397 — r001](https://redmine.remsoft.com.br/attachments/download/3379/1016397%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx).

## Publicação autorizada

- Servidor: https://redmine.remsoft.com.br. Identidade consultada: Mário Tinelli (131789).
- Criar 2 filhas novas sob o pai #1016397; tracker Task (4), status New (1), prioridade Normal (4), projeto FinAi (65224), versão Livewire (20359). Sem categoria, responsável, datas ou outros campos adicionais. Títulos, descrições, estimativas e Sequencing são os da prévia acima.
- As descrições remotas serão integralmente as seções Entrega, Escopo e limites, Critérios de aceite, Dependências e Referências de cada filha, preservando a origem estável. As referências de evidência são links para anexos Redmine; nenhum caminho do computador será usado como evidência.
- Filhas existentes: consultas de todos os status por pai não retornaram filhas. Nenhuma adoção, exclusão, cancelamento, alteração de status ou renumeração de issue alheia é proposta.
- Relações novas: D01 → Q01 (`blocks`). A origem é a fornecedora/bloqueadora e o destino é a consumidora/QA; substituir as chaves pelos IDs confirmados. Preservar todas as relações existentes.
- Atualizar somente Sequencing do pai #1016397 para 38, espelhando a primeira filha e sem consumir posição adicional; preservar descrição, status e demais campos do pai.
- Anexar `1016397 - Condições de testes.docx`, revisão r001, às QAs Q01 — [QA] [WEB] [SUPORTE] Corrigir barra de ambiente em telas menores. A QA executa todas as condições do documento. Preservar anexos já existentes.
- Materializar `tasks/dev-<ID>-<slug>/task.md` e `tasks/qa-<ID>-<slug>/task.md` somente após releitura integral da publicação. Não criar planning.md nem implementar neste fluxo.

## Sequencing

Campo real: Sequencing, custom field 2. Consulta MCP completa: projeto 65224, versão 20359, todos os status/trackers, uma página com 46 de 46 issues. Maior inteiro positivo ocupado: 37; nenhum valor não vazio inválido. Espelhos históricos de pai/primeira filha são mantidos como ocupados.

Bloco proposto deste pai: 38–39; âncora do pai: 38. Blocos do conjunto na ordem aprovada: envbar 38–39; tabelas 40–44; temas 45–50. Nenhuma lacuna é reutilizada e nenhum número atual será deslocado. Renovar a leitura integral antes de publicar; colisão exige conciliação, sem recalcular números já autorizados silenciosamente.

## Revisão e publicação

Conjunto completo aprovado por Mário nesta conversa. As operações foram executadas e relidas; IDs e resultados estão na tabela de publicação confirmada abaixo. Não há operação incerta ou bloqueio de publicação.

## Documento Word conferido

O DOCX r001 foi gerado com Microsoft Word 16.0 disponível nesta máquina. O pacote ZIP/OpenXML e o conteúdo legível foram conferidos: 8 condições, equivalentes integralmente ao Markdown da revisão após normalizar apenas a apresentação dos títulos e links. O arquivo aprovado foi associado às QAs previstas e seus anexos foram relidos. As condições representam verificações futuras, não testes já executados.

## Resultado consolidado e pendências

Slicing integralmente publicado e conferido. [D01 #1016401](https://redmine.remsoft.com.br/issues/1016401); [Q01 #1016402](https://redmine.remsoft.com.br/issues/1016402). Total 3h; bloco 38–39, pai espelhando 38. DOCX confirmado: [QA #1016402, anexo 3379](https://redmine.remsoft.com.br/attachments/download/3379/1016397%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx). Arquivos task.md por ID materializados após readback. Próximo passo: plan-issue nas DEVs, respeitando os fornecedores declarados; QAs aguardam implementação. Não houve implementação ou execução de testes do produto.

## Publicação aprovada — execução

Mário aprovou o conjunto completo nesta conversa, incluindo revisão funcional r002 de temas, estimativas corrigidas dos Bugs, Sequencing, relações e DOCX. A identidade textual portátil substitui os caminhos locais na nova publicação; a correspondência ao documento permanece aqui.

| Entrega autorizada | ID/URL confirmado | Resultado | Próximo passo |
| --- | --- | --- | --- |
| D01 | [#1016401](https://redmine.remsoft.com.br/issues/1016401) | Campos, descrição, relações e numeração conferidos | Pronta para plan-issue |
| Q01 | [#1016402](https://redmine.remsoft.com.br/issues/1016402) | Campos, descrição, relações e numeração conferidos; DOCX 3379 associado | Aguardar implementação para executar QA |

Pais permanecem no status atual; anexos e relações existentes serão preservados. Nenhuma implementação autorizada por esta publicação.


## Conferência final do conjunto

Leitura completa final: 59 de 59 issues de FinAi/Livewire; bloco 38–50 sem colisões indevidas, âncoras 38/40/45 e Sequencing das issues alheias preservados. Pais e filhas relidos; descrições, estimativas, versão, prioridade, relações e anexos confirmados. Publicações usam apenas IDs/URLs remotos e identidades textuais portáteis; caminhos de código/fontes ficam no contexto local. Não foram duplicadas as capturas já acessíveis nos pais.

