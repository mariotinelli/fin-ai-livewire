# Mapa funcional do projeto

Para incorporar uma Feature ou Bug aprovado, uma nova revisão ou um conflito ao mapa existente, siga a [atualização por requisito](map-approval.md).

## Encontrar e conhecer as jornadas

No início de um escopo, Feature ou Bug, procure o mapa nas referências do projeto, no README e em `docs/engineering/`. Abra o documento e suas fontes. O mapa acompanha quem usa o produto, o que faz e o resultado que encontra. O catálogo de escopo e seu grafo de dependências servem para organizar a entrega.

Reutilize o mapa canônico e o formato que a equipe mantém. Se for válido, referencie-o no requisito ou escopo e siga a coleta. Preserve capítulos, IDs, caminhos, notas e trabalho em andamento. Se só existir um PDF, procure sua fonte antes de gerar outra edição. Se dois mapas divergirem, apresente a página, a etapa e as evidências conflitantes para decidir qual representa o produto. Continue o levantamento independente enquanto a origem do trecho estiver pendente.

Para um primeiro mapa, percorra as jornadas do produto, inclusive as que precedem o escopo atual. Confronte documentação, telas, comandos, APIs, integrações, código, testes e decisões confirmadas. Aproveite as fontes do catálogo, quando houver. Identifique atores, gatilho, decisões, dados compartilhados, exceções e resultado observável. No registro local de fontes, indique a referência e o que ela comprova. Use **Em uso** quando houver evidência de disponibilidade ao público, **Previsto** para um requisito aprovado ainda sem entrega comprovada e **A confirmar** para uma dúvida pontual sobre uma jornada identificada. Um projeto novo pode ter apenas jornadas previstas. Se ainda não há sequer um requisito aprovado ou fluxo comprovado, preserve as anotações e indique a informação que falta.

**Concluído quando** o mapa existente foi identificado ou as jornadas do primeiro mapa têm fonte, situação e limites conhecidos.

## Preparar o guia

Na ausência de mapa, use `docs/engineering/functional-map.html` como fonte editável e `docs/engineering/functional-map.pdf` como edição para leitura. Trabalhe dentro da raiz do projeto, verificando links simbólicos, junctions e conflitos antes de criar ou substituir arquivos. Para a primeira geração, copie o [modelo HTML](../templates/functional-map.html). Nas seguintes, leia e preserve a fonte da equipe.

Preencha o bloco `map-data` com:

- `product`, `overview`: nome do produto e como as jornadas se conectam.
- `journeys`: uma entrada por jornada, com `id` estável (letras minúsculas, números e hífen, começando por letra), `title`, `status`, `intro`, `steps` e `example`. Cada passo tem `actor` e `action`. A ordem dos passos conta a jornada até o resultado. IDs técnicos e caminhos novos ficam em inglês.
- `alternatives` e `failures`: listas de caminhos alternativos e falhas reais, quando aplicáveis. Se uma mudança de situação afetar o que pode ser feito, inclua `states.intro` e `states.transitions`, cada uma com `from`, `event` e `to`. Escape o caractere `<` nos dados JSON como `\u003c`.

Escreva em português e use os nomes do próprio produto. Antes de cada desenho explique quem começa, por quê, o que precisa decidir e como percebe o resultado. Use raias para distribuir as ações entre pessoas e sistemas. Complete o capítulo com um exemplo concreto antes de começar o próximo. Para uma API ou CLI, descreva o pedido ou comando, os dados recebidos, a resposta ou saída e a retomada após falha. Notas de desenvolvimento, commits, tarefas de QA e andamento da implementação pertencem às suas fontes técnicas.

Use o azul RemSoft `#1988CC` nos destaques de todos os projetos, com raias claras contínuas e caixas que crescem com o texto. Quando a jornada for longa, deixe-a continuar na próxima página. Preserve o tamanho das letras, o espaço entre passos e as proporções das setas do modelo.

O PDF mostra o comportamento, a situação e os exemplos. Para registrar referências, use `journey.sources` (lista de textos) e `journey.evidence` (nota opcional): o modelo permite consultá-las no HTML e as oculta ao imprimir. Reserve caminhos de arquivos, commits, testes inspecionados e instruções de manutenção para essas notas ou para o requisito. Mantenha no PDF os links funcionais das mudanças e os links de navegação.

**Concluído quando** a equipe consegue identificar cada jornada pelo índice e percorrê-la sem conhecer a conversa do agente.

## Gerar e conferir o PDF

Na raiz do projeto, execute `remsoft skills:render-map`. Para uma fonte em outro caminho, use `remsoft skills:render-map "caminho/fonte.html" --output="caminho/mapa.pdf"`. Em uma instalação de desenvolvimento, use o mesmo launcher do RemSoft que preparou as skills. O comando usa o navegador validado pelo `remsoft init` e grava primeiro um PDF temporário.

Se já houver uma edição válida e a fonte precisar de reparo, exporte a candidata com `--output` para um PDF temporário ao lado do original. Abra o PDF real. Siga o índice, confira a ordem dos capítulos, os nomes, acentos, texto selecionável, setas, exemplos e legibilidade das raias, inclusive nas que atravessam páginas. Somente depois dessa conferência aplique a edição no destino previsto, preservando revisões citadas. Uma renderização inválida mantém a edição anterior. Se o navegador estiver ausente, preserve a fonte para retomada e informe o requisito indicado pelo comando. Quando houver escopo ou requisito, registre nele a referência ao mapa. A primeira geração é local e independe do Redmine.

**Concluído quando** a fonte editável e o PDF estão acessíveis, a navegação e o conteúdo foram conferidos ou o impedimento específico foi registrado.
