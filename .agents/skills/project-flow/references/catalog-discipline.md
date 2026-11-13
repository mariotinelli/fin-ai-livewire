# Catálogo do escopo

Leia todas as fontes e inspecione contexto antes de decompor. Identifique capacidades de produto, não tarefas técnicas. Cada candidato recebe ID estável, nome, Feature/Bug, objetivo, limites, aceite resumido, fontes e destino: item próprio, coberto por outro ou exclusão justificada pelo usuário.

Uma Feature entrega um fluxo ou resultado observável que o QA consiga executar e conferir no canal real do produto quando a entrega terminar. Em aplicações com interface, use as telas; quando o próprio produto é uma CLI ou API pública, use esse canal. O caminho pode existir ou ser incluído na própria Feature, apoiado por dependências anteriores disponíveis na conclusão. Métodos internos, testes automatizados e mocks apoiam a DEV, mas não substituem esse aceite funcional.

Explicite ator, ação, resultado percebido e caminho de validação nos campos atuais de objetivo, entrega/limites e aceite resumido. Isso basta para avaliar a fronteira do catálogo, sem antecipar a entrevista detalhada. Uma capacidade exclusivamente interna acompanha a primeira Feature consumidora que entrega o resultado ao usuário; preserve suas regras e rastreabilidade, em vez de promovê-la a Feature independente apenas por ser compartilhada.

Compare fluxo, critérios e exclusões: não aceitar uma Feature cujo único caminho de demonstração está fora de seu escopo e pertence a um consumidor futuro. Se esse consumidor depende da candidata, adiar toda a QA para ele cria circularidade de aceite mesmo sem ciclo nas relações técnicas. Proponha corrigir a fronteira no catálogo; não invente tela de gestão, endpoint ou consumidor demonstrativo apenas para justificar a separação.

Quando design exigir identidade visual compartilhada, delimite Feature de fundação com aceite próprio e consumidores dependentes; não esconder seu trabalho dentro de Feature de negócio. Ela tem aceite funcional quando o QA pode navegar nas telas abrangidas e comparar a aparência entregue, sem precisar das funcionalidades futuras. Fontes visuais não comprovam regras funcionais de protótipo.

Em scope.md, apresente catálogo, grafo de dependências por capacidade, ordem topológica sugerida e grupos independentes. Bloqueios precisam de motivo real; relação não pode formar ciclo. Consulte domínio para termos e pergunte só decisões de produto. Catálogo não é entrevista detalhada de todos os itens.

Revise catálogo completo com o usuário na etapa existente, sem novo gate ou questionário. Mudança material de limites/dependências volta à revisão; preserve IDs e trabalho iniciado/publicado. Encontrar fronteira inadequada em Feature já aprovada exige uma decisão específica antes de alterar documentos, issues ou relações. Remover item proposto não apaga issue remota nem autorização histórica.

Durante processamento, consolide ao concluir cada item: requisito/documento/ID, publicação e relações confirmadas, slicing e implementação apenas quando comprovados. Não use publicação como progresso de implementação. Fontes compartilhadas têm um dono e links, sem duplicação mecânica.

**Concluído quando:** nenhum candidato/fonte relevante está omitido, cada Feature tem fluxo e caminho de aceite funcional identificáveis para sua conclusão, limites/dependências foram revisados, itens têm destino e resumo final lista resultados/pendências e próximo passo.
