# O trecho do fluxo de cada tarefa

## Localizar a revisão de origem

Leia a comparação aprovada, o capítulo do mapa e o registro de [publicação do pai](../../project-flow/references/pdf-publication.md). Em escopo, faça isso para cada Feature ou Bug. Releia o pai pelo MCP com `redmine_get_issue` incluindo `attachments`. Confira projeto, ID do pai, ID e `content_url` dos dois anexos, revisão da comparação e edição do mapa. Confronte com o registro local e abra os documentos para localizar a jornada e o passo. Use o par que fundamentou aquele fatiamento, inclusive quando o projeto já tiver uma edição mais recente.

Se um link abrir o arquivo de outra tarefa, estiver inacessível ou divergir da revisão, mantenha o texto local e indique qual referência precisa ser confirmada. Recupere o anexo certo no próprio pai. Se faltar publicação no pai, registre a dependência para o `project-flow`. A prévia local pode avançar; a publicação das filhas afetadas permanece pendente até a conferência dos links corretos.

**Concluído quando** o responsável consegue localizar o trecho nos dois documentos do pai ou identificar a pendência específica.

## Escrever a entrega antes dos links

Na descrição de cada filha, dê nome ao capítulo e ao passo ou transição em linguagem do produto. Escreva o suficiente para entender a tarefa antes de abrir o PDF.

- **DEV.** Comece pelo ator e pela situação inicial. Explique como funciona hoje, o que a pessoa passa a fazer, qual dado ou decisão muda e qual resultado encerra essa entrega. Onde o comportamento anterior for desconhecido, preserve a dúvida registrada no requisito. Se outra DEV receber a próxima etapa, identifique apenas a passagem necessária.
- **QA.** Indique o cenário e o resultado que distingue o caminho anterior do aprovado. Relacione cada verificação aos critérios de origem e aos IDs das condições que ela cobre. Se houver várias QAs, distribua as condições e identifique onde conferir o percurso integrado. O DOCX continua sendo o documento de condições da QA.
- **QA-only, trabalho interno ou Study.** Se o resultado já existe, descreva em uma frase a jornada em uso e o que deve continuar observável. QA-only verifica a cobertura aprovada. Uma atividade interna identifica o comportamento preservado. Em Study, formule a hipótese e a evidência que permitirá voltar ao fatiamento.

Em seguida, ofereça os dois links diretos, por exemplo **Fluxo da mudança · revisão 2** e **Mapa do projeto · edição r003**, no formatador da instância. A DEV e a QA podem abrir os mesmos arquivos, mesmo com entregas distintas. Na prévia e no documento local, registre o capítulo, o passo e os critérios/CTs pertinentes a cada uma.

Por exemplo, ao fatiar uma renovação com resposta posterior, a primeira DEV termina quando o leitor vê “Pedido recebido”. A segunda começa com o pedido pendente e termina quando o leitor vê a nova data após a confirmação. Na QA, a verificação observa a data original durante a espera e a nova data depois da resposta. Use os critérios e CTs do próprio requisito para identificar esses dois resultados.

**Concluído quando** a pessoa consegue explicar o que entrega ou verifica, o que fica a cargo das outras tarefas e qual edição consultar.

## Quando gerar um PDF próprio

Use os anexos do pai quando o capítulo e o nome do passo localizarem todo o recorte. Acrescente um desenho se uma exceção, sequência ou transição **já aprovada** estiver resumida no desenho do pai e for necessária para entender a responsabilidade da filha. Detalhe somente esse trecho, com explicação antes do desenho e um exemplo de resultado. Se o ponto depender de nova regra de produto, retorne ao requisito.

Copie o [modelo HTML](../../project-flow/templates/functional-map.html) para `flow-slice.html` no rascunho daquela filha. Use o [formato de comparação](../../project-flow/references/flow-comparison.md) com `kind: "comparison"`. Indique a Feature ou Bug, a revisão de origem, a edição do mapa e a revisão do recorte em `revision`. Identifique o capítulo em `intro`. Preencha `parentDocuments.comparison` e `parentDocuments.map` com os dois `content_url` confirmados. Na preparação offline, conserve a fonte e indique os links pendentes.

Rode `remsoft skills:render-map "caminho/da/filha/flow-slice.html"`. Abra `flow-slice.pdf`, confira o trecho, a revisão e ambos os links. Inclua na prévia o arquivo, o papel, a filha de destino e a apresentação do terceiro link. Após autorização e confirmação do ID da filha, associe o PDF pelo MCP conforme a [regra de anexos](../../project-flow/references/published-evidence.md). Use nome como `321-fluxo-r001.pdf` e registre a revisão, o SHA-256 dos bytes enviados, ID e URL retornados. Releia os anexos da filha antes de completar a descrição. Se perder a resposta, concilie o envio pela identidade e conteúdo na filha correta e continue apenas pela operação pendente.

**Concluído quando** cada desenho adicional resolve uma necessidade do recorte, abre na filha certa e permite retornar ao fluxo completo e ao mapa.

## Conferir e retomar

Releia a descrição da filha, suas referências e os anexos da QA. Confira com a prévia tanto os destinos quanto a explicação anterior a eles. Registre separadamente associação, link na descrição e abertura do arquivo quando houver pendência. Depois da conferência integral, materialize em `task.md` os IDs, revisões, capítulo, passo, critérios e links confirmados. Leve `flow-slice.html` e `flow-slice.pdf`, quando houver, para a pasta do `task.md` e ofereça links relativos aos dois arquivos somente no documento local. Ao revisar, conserve o par anteriormente citado em sua revisão antes de substituí-lo.

Se o pai mudar, compare os passos e resultados cobertos por cada filha. Aplique a [revisão por impacto](change-review.md) apenas onde houver diferença. Uma filha concluída conserva o texto, o recorte, as condições e os links históricos. Adoção simples conserva a descrição existente; encaminhe eventual correção necessária para revisão específica.

**Concluído quando** o artefato por ID corresponde ao remoto conferido e as revisões históricas continuam recuperáveis.
