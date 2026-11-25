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

## Funcionalidades existentes na base

Ao levantar ou revisar qualquer escopo, inspecione o destino mesmo que ninguém tenha mencionado uma base padrão. Um projeto novo pode começar com funcionalidades prontas de um template, de um produto copiado ou da própria equipe. Percorra os pontos de entrada e seus consumidores (telas, menus, rotas, permissões, integrações ou rotinas aplicáveis). Agrupe por funcionalidade reconhecível pelo usuário e registre também o que o escopo aproveita. Se o projeto começa vazio, prossiga com o catálogo.

Compare a base com o **escopo do produto**. Uma capacidade já atendida pode ficar registrada como existente, com sua evidência, sem abrir nova tarefa. Se o pedido abrange apenas uma área de uma aplicação existente, confronte as capacidades afetadas nessa área; a ausência de um módulo independente na descrição de uma Feature não o torna candidato à retirada. Em uma migração, considere também o legado: deixar de portar uma funcionalidade da origem e retirar uma que já está instalada no destino são decisões diferentes.

Para cada possível retirada, mostre **o que existe, onde aparece, por que parece fora do escopo e o que seria afetado ou preservado**. Pergunte explicitamente se o usuário quer remover aquela funcionalidade, mantê-la, adaptá-la ou decidir depois. Quando o escopo for omisso, diga “não encontrei esse uso no escopo”. A aprovação geral do catálogo ou de outra retirada não decide esse item.

Por exemplo: “A base oferece login e painel para clientes. O escopo descreve acesso pela equipe interna. Retirar a área do cliente fecharia esse acesso; perfil e notificações também atendem à administração. Podemos planejar a retirada **da área do cliente**, preservando esses usos?” Se o cadastro público também for candidato, apresente sua própria pergunta: ele cria contas e pode atender a outro fluxo. Dê o mesmo tratamento a dados existentes e integrações quando seu destino exigir uma decisão distinta.

Registre em `scope.md` a capacidade, a evidência, a decisão do usuário e seus limites. Reaproveite decisões explícitas que já cubram o mesmo item. Enquanto a resposta faltar, deixe a retirada pendente e siga com itens independentes. Se o usuário decidir manter, registre a preservação. Se pedir adaptação, registre o limite acordado. Se aprovar a retirada, inclua-a no catálogo como entrega própria ou parte identificada de um requisito, com aceite observável: o acesso ou efeito que deve desaparecer e o fluxo compartilhado que precisa continuar funcionando.

“Fora do escopo” ou “item retirado do catálogo” descreve o que fica fora da entrega. Para retirar algo que já existe no produto, registre a decisão específica. Em catálogo já publicado, apresente a diferença e vincule-a aos IDs existentes. A decisão de retirar autoriza **planejar o trabalho**; as tarefas seguem a prévia habitual antes da publicação. Excluir contas, apagar histórico ou eliminar dados exige decisão específica sobre esses dados.

**Concluído quando** cada possível retirada tem uma resposta atribuída ou uma pendência visível, e cada retirada aprovada tem um requisito responsável e um resultado verificável.

Use as decisões ao conferir o [mapa do produto](functional-map.md), inclusive se o primeiro mapa tiver sido preparado antes do catálogo.
