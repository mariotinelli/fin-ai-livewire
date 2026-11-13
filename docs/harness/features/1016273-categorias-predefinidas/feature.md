# Categorias predefinidas

## Identidade e situação

- Item F03 do [catálogo aprovado](../../scopes/2026-11-13-finai-mvp/scope.md).
- Situação: requisito completo e publicação aprovados pelo responsável. Feature #1016273 publicada e relida, com referência definitiva e relação com F01 conferidas. Não implementada.
- Destino escolhido: projeto FinAi (65224), versão Livewire (20359).
- Referência estável: `docs/harness/.runs/2026-11-13-finai-mvp/f03-categorias/feature.md`.

## Objetivo

Disponibilizar um conjunto predefinido e comum de categorias de receitas e despesas para classificar transações de forma consistente no cadastro manual, no histórico e nas interações com a IA.

## Resultado esperado

Todos os usuários dispõem das mesmas quatro categorias de receita e oito de despesa. Cada transação utiliza uma categoria compatível com seu tipo, e os mesmos nomes e significados aparecem em todos os consumidores. Os usuários não criam, editam ou excluem categorias no MVP.

## Atores e permissões

- Usuários com acesso financeiro liberado conforme F02 podem utilizar o catálogo nas funcionalidades financeiras disponíveis.
- O catálogo é comum a todos; isso não compartilha transações, totais ou conversas entre pessoas.
- Nenhum ator recebe nesta Feature uma função de manutenção de categorias.

## Histórias de usuário

1. Como usuário, quero selecionar uma categoria adequada ao tipo da transação para organizar meus registros.
2. Como usuário, quero reconhecer os mesmos nomes no formulário e no histórico para localizar movimentações de uma categoria.
3. Como usuário do assistente, quero que as propostas e consultas usem o mesmo catálogo do cadastro manual para manter a classificação consistente.

## Fluxo principal

1. Ao iniciar um registro manual de receita ou despesa na funcionalidade disponível, escolher o tipo da transação.
2. Apresentar as categorias compatíveis com o tipo selecionado, com os nomes do catálogo aprovado.
3. Selecionar uma categoria e concluir o registro conforme as regras da Feature de transações. Ao consultar o registro, reconhecer a categoria associada.
4. Ao filtrar o histórico por categoria ou consultar registros pelo assistente, utilizar a mesma classificação, sempre limitada aos dados do titular.
5. Quando o assistente propuser uma transação, apresentar uma categoria existente e compatível com seu tipo. A revisão e a confirmação seguem a Feature de registro por IA.

## Fluxos alternativos e exceções

- Ao trocar o tipo de uma transação em criação ou edição, reapresentar as categorias compatíveis. Uma categoria exclusiva do tipo anterior não pode ser gravada no novo tipo; a categoria que será salva deve estar visível para revisão.
- Uma categoria inexistente ou incompatível, inclusive recebida em uma proposta da IA ou em uma solicitação alterada, não permite persistir a classificação inválida. Informar a necessidade de selecionar uma categoria válida.
- Quando nenhuma categoria específica representar o registro, o usuário pode escolher Outras receitas ou Outras despesas, conforme o tipo. A existência dessas alternativas não permite criar categorias livres.
- Categoria disponível sem transações do usuário é uma situação válida; não remover a categoria nem inventar registros ou valores para preencher resultados.
- A indisponibilidade do catálogo deve ser apresentada como falha quando impedir a escolha; não fingir que não há categorias nem gravar uma categoria improvisada.

## Regras de negócio

**R1 — Catálogo aprovado.** Disponibilizar exatamente os seguintes nomes e vínculos de tipo no MVP:

| Tipo    | Categorias                                                                         |
| ------- | ---------------------------------------------------------------------------------- |
| Receita | Salário; Freelance; Rendimentos; Outras receitas                                   |
| Despesa | Alimentação; Moradia; Transporte; Saúde; Educação; Lazer; Compras; Outras despesas |

**R2 — Conjunto comum.** As categorias estão disponíveis para todos os usuários e não são personalizadas por conta. A classificação comum não altera a titularidade dos registros financeiros.

**R3 — Compatibilidade.** Uma transação tem uma categoria válida do seu próprio tipo. Não permitir categoria de receita em despesa, nem o inverso. Essa regra vale igualmente para criação, edição e confirmação de proposta da IA.

**R4 — Vocabulário consistente.** Preservar grafia, acentos e distinção entre Outras receitas e Outras despesas. Formulário, histórico, filtros e assistente usam os mesmos nomes. O assistente pode interpretar a linguagem natural do usuário, mas não transforma essa interpretação em categoria nova ou rótulo livre persistido.

**R5 — Sem manutenção de categorias.** O MVP não oferece criação, edição, exclusão ou personalização de categorias, inclusive por pedido ao assistente. Não criar uma tela de gestão de categorias apenas para demonstrar a Feature.

**R6 — Fronteira dos consumidores.** F03 possui o catálogo e suas regras de classificação. F04 entrega a seleção no formulário, a edição e a apresentação/filtro do histórico; F06 usa as categorias nas consultas; F07 usa o catálogo nas propostas e confirmações. A interpretação automática e a decisão de pedir esclarecimento pertencem aos requisitos da IA.

**R7 — Apresentação.** Onde houver apresentação das categorias, usar a base visual de F01 e os controles das respectivas telas consumidoras, com nomes legíveis e estado de seleção reconhecível. Não apresentar novas operações ou destinos fora do catálogo aprovado.

## Dados percebidos pelo usuário

Tipo da transação, lista de nomes compatíveis, categoria selecionada ou exibida no registro e categoria usada no filtro ou na proposta do assistente. As categorias não acrescentam valores financeiros, registros demonstrativos ou classificações particulares de outra pessoa.

## Critérios de aceite

**CA01 — Receitas.** O catálogo de receita disponibiliza Salário, Freelance, Rendimentos e Outras receitas, sem categorias adicionais nem categorias de despesa.

**CA02 — Despesas.** O catálogo de despesa disponibiliza Alimentação, Moradia, Transporte, Saúde, Educação, Lazer, Compras e Outras despesas, sem categorias adicionais nem categorias de receita.

**CA03 — Consistência entre contas.** Duas contas dispõem dos mesmos nomes e vínculos de tipo. As categorias em comum não permitem acessar transações, totais ou conversas da outra pessoa.

**CA04 — Classificação válida.** Nas operações consumidoras disponíveis, aceitar apenas categoria existente e compatível com o tipo. Tentar salvar categoria inexistente ou do tipo oposto é recusado sem persistir a classificação inválida, tanto no formulário quanto na confirmação pela IA.

**CA05 — Troca de tipo.** Na criação ou edição entregue por F04, trocar receita por despesa e vice-versa. A seleção resultante apresenta apenas opções compatíveis, e a categoria que será salva está visível antes da conclusão; não permanece uma categoria incompatível oculta.

**CA06 — Mesma linguagem nos canais.** Ao criar, consultar e filtrar uma transação nas Features consumidoras, reconhecer a mesma categoria e grafia. Uma proposta da IA utiliza o catálogo aprovado, sem categoria livre ou nome inventado.

**CA07 — Alternativas gerais.** Classificar uma receita em Outras receitas e uma despesa em Outras despesas é permitido; usar a alternativa geral do tipo oposto é recusado como qualquer incompatibilidade.

**CA08 — Ausência de registros e falha.** Uma categoria sem registros continua disponível. Consultas sem correspondências não produzem movimentações fictícias. Uma falha que impeça obter as opções não é apresentada como catálogo vazio nem permite salvar categoria improvisada.

**CA09 — Sem manutenção.** Não há criação, edição, exclusão ou personalização de categorias pelo usuário, nem por solicitação ao assistente. A entrega não cria uma tela de gestão ou um destino vazio.

**CA10 — Aplicação visual e integração.** Nos consumidores entregues, a seleção e a exibição seguem o design fornecido e F01 em celular, tablet e desktop, mantendo nomes legíveis e seleção reconhecível. F03 pode entregar o catálogo comum sem antecipar as telas de F04, F06 e F07; os critérios relativos a essas jornadas são conferidos também na entrega que as introduz.

## Dependências

- F01 — [Adequação visual completa do FinAI, #1016270](https://redmine.remsoft.com.br/issues/1016270): apresentação compartilhada, quando o catálogo aparecer nas telas consumidoras.
- F03 não depende de categorias personalizadas ou da criação de dados financeiros. F04, F06 e F07 consomem o conjunto aprovado e demonstram sua aplicação nas próprias jornadas, respeitando F02.

## Designs e evidências

O design fornecido apresenta as categorias no formulário de transações, nos filtros e nas propostas do assistente. A lista e os vínculos de tipo foram confirmados pelo responsável. A identidade visual segue F01; a aplicação nas jornadas consumidoras é verificada por CA05, CA06 e CA10.

## Dentro do escopo

Catálogo comum de quatro categorias de receita e oito de despesa, nomes e tipos aprovados, compatibilidade da classificação e consistência entre consumidores manuais e IA.

## Fora do escopo

Manutenção ou personalização de categorias, subcategorias, importação de categorias e criação de transações ou telas consumidoras nesta Feature. Não inclui regras de inferência automática de categoria, que serão definidas em F07, nem a criação de uma tela de gestão do catálogo.

## Decisões e revisão

- Q4 resolvida: o responsável respondeu “podemos usar essa” à lista completa apresentada, com categorias vinculadas ao tipo e disponíveis para todos, sem criação/edição no MVP conforme o catálogo aprovado.
- Este documento consolida a lista decidida e os comportamentos propostos de compatibilidade e integração. A aprovação da lista não substitui a revisão do requisito completo.
- Preferência editorial preservada: mencionar apenas o design fornecido, sem sua origem pessoal.
- O responsável aprovou o requisito completo e a publicação apresentada respondendo “aprovado” nesta conversa, incluindo materialização definitiva e relação F01 bloqueia F03.

## Publicação proposta

- Projeto FinAi (65224), versão Livewire (20359), escolhida pelo responsável.
- Criar Feature (tracker 2), título **[WEB] [USUARIO] Categorias predefinidas**, status inicial New (1), sem categoria, pai, responsável, datas, estimativa ou Sequencing; prioridade padrão do servidor.
- Descrição integral: seções de **Objetivo** até **Fora do escopo**, dentro de `<!-- project-flow:start -->` e `<!-- project-flow:end -->`, acrescidas da referência estável identificada no início deste documento.
- Após ID confirmado, materializar em `docs/harness/features/<ID>-categorias-predefinidas/feature.md`, corrigir referências relativas e acrescentar o caminho definitivo à descrição remota, preservando a referência estável inicial.
- Relação proposta: F01 #1016270 **bloqueia** a nova F03 pela apresentação na base visual compartilhada. Não criar relação com F02, pois o catálogo é comum e não personalizado, nem com registros da Sprint 1. Não criar tarefas DEV/QA.
- Similaridade: a consulta da versão Livewire retornou apenas F01 #1016270 e F02 #1016271; não há Feature de categorias nessa versão. O inventário anteriormente consultado do projeto não apresentou Feature própria de categorias na Sprint 1; suas demandas anteriores permanecem preservadas.
- Publicação autorizada e confirmada como [Feature #1016273](https://redmine.remsoft.com.br/issues/1016273), com descrição integral e referência definitiva relidas. Projeto FinAi (65224), versão Livewire (20359), tracker Feature e status New conferidos; sem pai, categoria, responsável, datas, estimativa, Sequencing ou filhas. Relação #878 confirmada nos dois endpoints: F01 #1016270 bloqueia F03 #1016273. Nenhum resultado incerto de publicação.

## Resultado da publicação

| Operação autorizada                           | Identidade                                                         | Resultado                                                                 | Pendência |
| --------------------------------------------- | ------------------------------------------------------------------ | ------------------------------------------------------------------------- | --------- |
| Criar F03 com o requisito aprovado            | #1016273, projeto FinAi, versão Livewire                           | Criação e leitura final confirmadas                                       | Nenhuma   |
| Materializar requisito e atualizar referência | `docs/harness/features/1016273-categorias-predefinidas/feature.md` | Documento materializado, fontes preservadas e referência remota conferida | Nenhuma   |
| F01 bloqueia F03                              | #1016270 → #1016273, relação #878                                  | Criada e relida nos dois endpoints                                        | Nenhuma   |

## Passagem

Entrada pronta para `project-slices`: este requisito aprovado, pai #1016273 confirmado na versão Livewire e dependência F01 #1016270 registrada. Design fornecido preservado nas fontes do escopo. Sem slicing, tarefas DEV/QA ou implementação nesta etapa.
