---
name: ralph
description: Execute uma filha DEV pelos gates Dev, Validação por outro agente, Testes e Commit. Use para implementar fases de um planning.md revisado pelas ferramentas do agente.
---

# Ralph

Leia [comunicação](references/user-communication.md) uma vez por conversa. Responda em pt-BR. O agente conduz a execução sem runner próprio.

## Preparar a execução

Receba o ID DEV e localize task.md, requisito pai e planning.md. Confira instruções, Git, dependências e alterações existentes; preserve trabalho alheio. ID ausente/ambíguo ou filha QA/Study impede implementação por este fluxo. Não altere Redmine.

Sem plano, siga [novo planejamento](references/new-planning.md); para mudança material, siga [substituição](references/replace-planning.md). Apresente o plano para revisão antes de implementar; reutilize revisão e autorização já dadas ao mesmo conteúdo, sem repetir perguntas. Aprovar o conteúdo não é solicitar sua execução. Ao solicitar a execução do plano revisado, o usuário autoriza os commits das fases, sem nova confirmação por gate; instruções explícitas do projeto prevalecem. Essa autorização não inclui push.

Planos existentes continuam válidos sem conversão: incorpore verificações antigas de host, diagnóstico ou investigação aos quatro gates abaixo, preservando aceite e trabalho concluído. Mudança material de escopo volta ao usuário.

**Concluído quando:** uma DEV e seu plano revisado estão identificados, execução autorizada e situação real do código conhecida.

## Executar cada fase

Siga as dependências do plano e somente estes quatro gates, em ordem. Preparação de ambiente, diagnóstico, investigação e captura de evidências são atividades do gate que precisar delas; não criam etapas, aprovações ou registros próprios. Um impedimento externo que não possa ser resolvido dentro do escopo interrompe o gate com causa e próximo passo, preservando o trabalho.

### 1. Dev

Implemente a mudança prevista, mantendo limites e comportamento a preservar. Investigue falhas com evidência atual e corrija dentro do escopo; não altere aceite ou testes para esconder defeitos. Uma tarefa de negócio consome a fundação visual comprovada do fornecedor, sem absorver trabalho compartilhado fora de seu escopo.

**Concluído quando:** implementação da fase está pronta para revisão contra seus critérios de aceite.

### 2. Validação

Outro agente revisa a mudança sem editar a implementação. Forneça task.md, plano, critérios, base de comparação e alterações atuais. A revisão confere qualidade, aderência e os critérios funcionais/visuais aplicáveis; compare a UI com as referências aprovadas quando necessário.

Identifique revisor, versão/base examinada, achados e resultado. Achado impeditivo retorna para Dev. Revisão indisponível ou evidência necessária ausente mantém este gate pendente; autorrevisão não substitui o outro agente.

**Concluído quando:** outro agente revisou a versão atual e nenhum achado impeditivo permanece.

### 3. Testes

Execute os verificadores obrigatórios do plano e do projeto e confira seus resultados reais. Baseline vermelho não autoriza aceitar testes obrigatórios falhando. Uma falha volta para Dev; após qualquer correção na implementação, repita Validação e Testes antes de avançar.

Ferramenta ausente ou execução não realizada mantém o gate pendente, sem declarar sucesso por inspeção. Preserve evidências úteis; um verde posterior sozinho não demonstra a causa de uma falha anterior.

**Concluído quando:** todos os verificadores obrigatórios da fase passaram na versão validada.

### 4. Commit

Consolide uma vez no próprio planning.md a entrega, as verificações e o resultado do revisor. Confira o diff e prepare somente alterações da fase e esse resumo, preservando arquivos, hunks e mudanças já staged de outros trabalhos. Se não for possível separar o conteúdo com segurança, registre o impedimento em vez de incluir trabalho alheio.

Crie o commit automaticamente, respeitando as instruções do projeto e os hooks, sem nova pergunta. Não faça push. O resumo não precisa conter o hash do próprio commit nem um histórico por gate.

Falha operacional no commit mantém a fase neste gate: preserve código e índice, informe a causa e tente novamente quando resolvida. Não remova locks alheios nem ignore hooks. Se a solução exigir mudar a implementação, retorne para Dev e repita Validação e Testes.

**Concluído quando:** commit da fase criado com sucesso e seu conteúdo conferido, sem alterações alheias incluídas.

## Continuar ou encerrar

Depois do commit, prossiga para a próxima fase autorizada. Em interrupção, informe o gate pendente e o próximo passo seguro; retome por documentos, código e Git, sem estados, locks ou contadores próprios. Uma fase já entregue é reconhecida pela evidência existente, sem gerar commit vazio.

Ao final, informe mudanças, verificações, commits e limitações. Preserve evidências e trabalho anterior.

**Concluído quando:** todas as fases solicitadas têm commit e resultado verificável, ou o impedimento concreto está exposto sem alegar conclusão.
