# Gestão de transações

## Identidade e situação

- Item F04 do [catálogo aprovado](../../scopes/2026-11-13-finai-mvp/scope.md).
- Situação: requisito completo e publicação aprovados pelo responsável; Feature #1016274 publicada e relida, com referência definitiva e três relações conferidas. Não implementada.
- Destino: projeto FinAi (65224), versão Livewire (20359).
- Referência estável: `docs/harness/.runs/2026-11-13-finai-mvp/f04-transacoes/feature.md`.

## Objetivo

Permitir ao usuário registrar, editar, excluir e consultar receitas e despesas realizadas, com categorias e histórico pesquisável, mantendo seus registros persistidos e separados dos demais usuários.

## Resultado esperado

O titular registra suas movimentações manualmente e encontra os mesmos dados ao voltar ao sistema ou acessar sua conta em outro navegador. Pode consultar detalhes, corrigir um registro ou excluí-lo após confirmação. Histórico, dashboard e consultas posteriores da IA refletem os dados atuais quando essas capacidades estiverem disponíveis.

## Atores e permissões

- Titular autenticado e com e-mail confirmado: cria e consulta suas próprias transações; edita e exclui apenas registros próprios.
- Visitantes e contas com e-mail pendente não acessam dados ou ações financeiras, conforme F02.
- Administração e suporte não recebem permissão de consultar ou manter finanças de terceiros por esta Feature.

## Histórias de usuário

1. Como titular, quero registrar uma receita ou despesa realizada para manter meu histórico financeiro.
2. Como titular, quero localizar registros por descrição, tipo, categoria e mês para consultar minhas movimentações.
3. Como titular, quero ver os detalhes e editar uma transação para corrigir seus dados.
4. Como titular, quero excluir um registro após confirmar o efeito para removê-lo do histórico e dos cálculos.
5. Como titular, quero saber quando uma operação falhar para retomar o trabalho sem acreditar que uma alteração não salva foi concluída.

## Fluxo principal

1. Abrir Transações. Apresentar o histórico do mês corrente do titular, com filtros e ação Nova transação.
2. Iniciar o cadastro. Apresentar tipo, valor em reais, descrição, categoria e data. A data inicial é hoje, e o usuário pode informar uma data anterior válida.
3. Escolher receita ou despesa, informar valor positivo, descrição, categoria compatível de F03 e data não futura.
4. Salvar. Validar todos os dados e a autorização antes de persistir; após sucesso, confirmar o registro e atualizar a consulta conforme os filtros ativos.
5. Localizar a transação no histórico e abrir detalhes. Mostrar tipo, valor, descrição, categoria e data, com ações de editar e excluir.
6. Editar qualquer um desses cinco campos, mantendo as mesmas validações do cadastro e a titularidade original. Confirmar a atualização somente após o salvamento.
7. Para excluir, apresentar confirmação de que o registro sairá do histórico e dos totais, sem desfazer. Somente a confirmação aplica a exclusão.

## Fluxos alternativos e exceções

- Cancelar ou fechar o formulário de criação ou edição não persiste as alterações ainda não salvas.
- Cancelar a confirmação de exclusão ou fechar o diálogo mantém o registro e seus efeitos financeiros.
- Dados inválidos impedem gravar e apresentam erros associados aos campos, mantendo o preenchimento corrigível.
- Trocar o tipo reapresenta as categorias compatíveis. Uma categoria do tipo anterior não pode ser salva no novo tipo.
- Um registro salvo pode não pertencer ao mês ou aos filtros atuais. Informar o sucesso sem fingir que o salvamento falhou; a consulta permanece fiel ao recorte escolhido.
- Sem transações, mostrar estado inicial com ação de cadastro. Com registros existentes, mas sem correspondência aos filtros, informar ausência de resultados e oferecer ajuste ou limpeza dos filtros.
- Falha ao carregar dados é exibida como erro, com possibilidade de tentar novamente; não apresentar a falha como histórico vazio.
- Falha ao salvar, editar ou excluir não apresenta mensagem de sucesso nem aplica alteração parcial. Manter os dados de formulário necessários à nova tentativa enquanto a tela permanecer aberta.
- Durante um envio em processamento, apresentar esse estado e impedir que o mesmo envio seja disparado repetidamente pela interface. Se o resultado estiver incerto, consultar o estado atual antes de induzir a repetição; não confundir duas movimentações legítimas de mesmos dados com duplicação do mesmo envio.
- Um registro já excluído ou indisponível ao abrir detalhes ou concluir edição não pode ser recriado silenciosamente. Informar indisponibilidade e atualizar a consulta; não exibir dados de outra conta.

## Regras de negócio

**R1 — Dados obrigatórios.** Toda transação possui tipo (receita ou despesa), valor, descrição, categoria e data. Nenhum dos cinco campos pode ser omitido. A descrição não pode conter apenas espaços.

**R2 — Valores e moeda.** O MVP usa real brasileiro (BRL), com apresentação em R$ e precisão de centavos. O valor informado é maior que zero, com no máximo duas casas decimais, até R$ 999.999.999,99. O tipo define entrada ou saída; não aceitar valor negativo para representar despesa. Não arredondar silenciosamente um valor com mais de duas casas. Reconhecer a escrita brasileira, como 35,90 e 1.234,56.

**R3 — Descrição.** Aceitar de 1 a 120 caracteres após retirar espaços nas extremidades, mantendo o texto informado pelo usuário. Textos maiores são recusados com orientação, sem truncar silenciosamente.

**R4 — Datas de realização.** Aceitar datas de calendário válidas entre 01/01/1900 e hoje, inclusive. Recusar data futura na criação e na edição. Hoje e mês corrente são determinados pelo fuso America/Sao_Paulo para todos os usuários do MVP. O dado financeiro é uma data, sem exigir que o usuário informe horário.

**R5 — Categorias.** Usar exatamente as categorias compatíveis aprovadas em F03. Rejeitar categoria inexistente ou do tipo oposto em criação e edição. A edição do tipo só pode ser concluída com uma categoria válida para o novo tipo.

**R6 — Titularidade e persistência.** Associar o registro ao usuário autenticado, sem aceitar escolha de outro titular. A titularidade não é campo editável. Consultas, detalhes e alterações respeitam F02, inclusive em acessos diretos. A mesma conta reencontra os registros ao retornar ou trocar de navegador.

**R7 — Histórico.** A consulta inicial usa mês corrente. Permitir pesquisar parte da descrição e filtrar por tipo, categoria e mês; combinar os filtros com a pesquisa. A pesquisa ignora diferenças de maiúsculas e acentos e trata os caracteres digitados como texto literal. Os filtros só restringem os registros do titular.

**R8 — Limpeza, ordem e paginação.** Limpar filtros remove descrição, tipo, categoria e mês, passando a consultar todo o histórico. Ordenar por data da transação da mais recente para a mais antiga; para a mesma data, os registros criados mais recentemente aparecem primeiro, com desempate estável. Exibir até 50 registros por página, contagem de resultados, página atual e controles anterior/próxima quando necessários. Alterar um filtro ou pesquisa retorna à primeira página. Após edição ou exclusão, manter uma página válida do recorte.

**R9 — Detalhes e edição.** Os detalhes apresentam os cinco campos obrigatórios integralmente. A edição atualiza o mesmo registro, sem criar cópia, e permite alterar tipo, valor, descrição, categoria e data respeitando as regras. Criar duas transações legítimas com os mesmos dados é permitido.

**R10 — Exclusão confirmada.** Exigir confirmação explícita antes de excluir. Explicar que o registro deixa o histórico e os totais e que não existe desfazer no produto. Após sucesso, o registro não aparece em consultas financeiras ativas nem contribui para saldo, totais ou balanços. A regra define o efeito percebido pelo usuário, sem impor mecanismo interno de armazenamento.

**R11 — Atualização dos consumidores.** Criação, edição e exclusão bem-sucedidas atualizam as informações financeiras apresentadas na sessão, sem exigir novo login. F05 apresenta os indicadores; F06/F07 usam os dados atuais em consultas novas. Mensagens históricas já respondidas pela IA não são reescritas por uma alteração posterior.

**R12 — Apresentação.** Seguir o design fornecido para Transações, formulário, detalhes, confirmação e estados aplicáveis, usando F01. No celular, campos ocultos na linha resumida continuam disponíveis nos detalhes. Manter os nomes das categorias de F03 e as informações de valor, tipo e data compreensíveis.

## Dados percebidos pelo usuário

Tipo, valor em reais, descrição, categoria, data da movimentação; pesquisa, filtros ativos, mês ou todo o histórico, quantidade de resultados, página e estado das operações. Não exibir movimentações de demonstração como dados reais. Na listagem, distinguir receitas e despesas por sinal e identificação do tipo, além da cor.

## Critérios de aceite

**CA01 — Cadastro e permanência.** Criar receita e despesa com dados válidos; confirmar uma única gravação para cada envio concluído. Reabrir a tela e acessar a mesma conta em outro navegador mantém os registros e seus dados.

**CA02 — Validação.** Tentar omitir cada campo, usar descrição vazia ou maior que 120 caracteres, tipo inválido, categoria inexistente ou incompatível, valor zero, negativo, acima do limite ou com mais de duas casas. Recusar com erros corrigíveis e sem gravação parcial. Valores brasileiros válidos preservam exatamente os centavos.

**CA03 — Datas.** Criar e editar com hoje e data passada válida é permitido; data anterior a 01/01/1900, inexistente ou futura é recusada. Considerar hoje no fuso America/Sao_Paulo, inclusive próximo da mudança do dia, sem deslocar a data financeira informada.

**CA04 — Histórico e pesquisa.** Com registros em meses, tipos e categorias diferentes, verificar mês corrente inicial e filtros isolados ou combinados. Pesquisar descrição por trecho, com diferenças de caixa e acentos e com caracteres literais; somente correspondências próprias aparecem.

**CA05 — Limpeza e paginação.** Limpar filtros apresenta todo o histórico. Com mais de 50 resultados, navegar sem omitir ou repetir registros entre páginas de dados estáveis, na ordem definida. Alterar pesquisa/filtro retorna à primeira página; excluir o último item da última página mantém uma página válida.

**CA06 — Detalhes e edição.** Abrir detalhes de um registro próprio mostra os cinco campos integrais. Editar cada campo e salvar atualiza o mesmo registro. Trocar o tipo exige categoria compatível. Se a edição retirar o registro dos filtros atuais, o sucesso continua claro e a consulta permanece correta.

**CA07 — Cancelamentos.** Cancelar ou fechar criação e edição mantém os dados persistidos anteriores. Cancelar ou fechar a confirmação de exclusão não remove o registro nem altera os totais.

**CA08 — Exclusão.** Excluir exige a confirmação descrita em R10. Após sucesso, o registro sai de histórico, detalhes e resultados financeiros atuais, sem desfazer. Nas integrações disponíveis, saldo, totais, balanço e consultas novas da IA deixam de considerá-lo.

**CA09 — Falhas e repetição.** Falhas de leitura não parecem histórico vazio; falhas de gravação não parecem sucesso e permitem retomada. Enquanto processa, a interface não permite repetir o mesmo envio. Duas transações intencionais de dados iguais continuam permitidas. Registro removido durante a edição não é recriado silenciosamente.

**CA10 — Isolamento e confirmação.** Como visitante ou conta com e-mail pendente, não acessar nem alterar finanças. Com duas contas confirmadas, cada uma só consulta e altera os próprios registros; referências diretas de outra conta não revelam nem modificam seus dados. Trocar de conta não reutiliza registros da anterior.

**CA11 — Estados vazios.** Sem registros, mostrar orientação de primeiro cadastro; sem correspondências, informar ausência no recorte e permitir limpar filtros. Nenhum desses estados inventa transações ou substitui falhas de consulta.

**CA12 — Efeito financeiro integrado.** Com F05/F06 disponíveis, conferir criação e edição de valores, tipos, datas e categorias e exclusão contra indicadores e consultas novas. Usar os dados atuais persistidos, sem exigir novo login e sem reescrever respostas antigas do assistente.

**CA13 — Fidelidade visual.** Comparar a superfície Transações e os diálogos aplicáveis com o design fornecido nas nove dimensões previstas por F01. Preservar hierarquia, controles, estados e ações utilizáveis; descrições e valores extensos não encobrem controles, e detalhes expõem o conteúdo resumido na listagem móvel.

## Dependências

- F01 — [#1016270](https://redmine.remsoft.com.br/issues/1016270): base visual e navegação.
- F02 — [#1016271](https://redmine.remsoft.com.br/issues/1016271): acesso autenticado, confirmação de e-mail e titular financeiro.
- F03 — [#1016273](https://redmine.remsoft.com.br/issues/1016273): catálogo e compatibilidade das categorias.
- F05–F07 consomem as movimentações desta Feature. Seus indicadores, chat e gravação por IA não precisam ser antecipados para aceitar a gestão manual; CA12 e a parte integrada de CA08 acompanham a entrega desses consumidores.

## Designs e evidências

O design fornecido é a referência da listagem, filtros, seleção de mês, paginação, formulário, detalhes e confirmação de exclusão. Os controles adicionais foram incluídos pelo responsável em Q2. A proibição de datas futuras e o efeito da exclusão foram confirmados em Q5/Q6. O requisito aplica a base visual de F01 e a classificação aprovada em F03. Referência de aceite visual: CA13.

## Dentro do escopo

Gestão manual completa de receitas e despesas realizadas, em BRL, com categoria, persistência por titular, edição, detalhes, exclusão confirmada sem desfazer, pesquisa, filtros, paginação, estados e atualização dos consumidores disponíveis.

## Fora do escopo

Lançamentos futuros ou previstos, recorrência, parcelamento, transferências entre contas, importação, integração bancária, cartões, categorias personalizadas e desfazer exclusão. Dashboard e assistente são entregues nas Features responsáveis; esta entrega não cria versões simuladas dessas capacidades.

## Decisões e revisão

- Q1/Q3: finanças por titular, com autenticação e confirmação de e-mail, conforme F02.
- Q2: controles adicionais do design incluídos no MVP.
- Q4: categorias e vínculos aprovados, conforme F03.
- Q5/Q6: responsável respondeu “concordo com os dois” à recusa de datas futuras e à exclusão confirmada sem desfazer, retirando o registro do histórico e dos totais.
- Propostas para confirmação nesta revisão completa: BRL; precisão de duas casas; limite de R$ 999.999.999,99; descrição de até 120 caracteres; data mínima 01/01/1900; hoje/mês corrente em America/Sao_Paulo; mês corrente inicial; limpeza consultando todo o histórico; ordem por data decrescente e criação; 50 resultados por página. Limites e comportamento do protótipo são propostas avaliadas, não decisões atribuídas ao responsável antes da revisão.
- O responsável aprovou o requisito completo e a publicação, incluindo todas as propostas acima, respondendo “aprovado” nesta conversa. A autorização inclui materialização definitiva e as três relações de dependência apresentadas.
- Preferência editorial: mencionar apenas o design fornecido, sem expor sua origem pessoal.

## Publicação proposta

- Projeto FinAi (65224), versão Livewire (20359), escolhida pelo responsável.
- Criar Feature (tracker 2), título **[WEB] [USUARIO] Gestão de transações**, status inicial New (1), sem categoria, pai, responsável, datas, estimativa ou Sequencing; prioridade padrão do servidor.
- Descrição integral: seções de **Objetivo** até **Fora do escopo**, dentro de `<!-- project-flow:start -->` e `<!-- project-flow:end -->`, com a referência estável identificada no início.
- Após ID confirmado, materializar em `docs/harness/features/<ID>-gestao-de-transacoes/feature.md`, corrigir referências relativas e acrescentar o caminho definitivo à descrição, preservando a referência estável inicial.
- Relações propostas: F01 #1016270 **bloqueia** a nova F04; F02 #1016271 **bloqueia** a nova F04; F03 #1016273 **bloqueia** a nova F04. Motivos: base visual, identidade/acesso e categorias. Não criar tarefas DEV/QA nem alterar registros da Sprint 1.
- Similaridade: consulta da versão Livewire encontrou apenas F01, F02 e F03. Na Sprint 1 existe #1016105 — Gestão de transações, de outro catálogo, que permanece preservada; não adotar nem mover seu requisito ou suas filhas. Publicação proposta própria na versão escolhida.
- Publicação autorizada e confirmada como [Feature #1016274](https://redmine.remsoft.com.br/issues/1016274), com descrição integral e referência definitiva relidas. Projeto FinAi (65224), versão Livewire (20359), tracker Feature e status New conferidos; sem pai, categoria, responsável, datas, estimativa, Sequencing ou filhas. Relações #879, #880 e #881 confirmadas nos dois endpoints de cada vínculo: F01 #1016270, F02 #1016271 e F03 #1016273 bloqueiam F04 #1016274. Nenhum resultado incerto de publicação.

## Resultado da publicação

| Operação autorizada                           | Identidade                                                        | Resultado                                                                 | Pendência |
| --------------------------------------------- | ----------------------------------------------------------------- | ------------------------------------------------------------------------- | --------- |
| Criar F04 com o requisito aprovado            | #1016274, projeto FinAi, versão Livewire                          | Criação e leitura final confirmadas                                       | Nenhuma   |
| Materializar requisito e atualizar referência | `docs/harness/features/1016274-gestao-de-transacoes/feature.md`   | Documento materializado, fontes preservadas e referência remota conferida | Nenhuma   |
| F01, F02 e F03 bloqueiam F04                  | #1016270, #1016271 e #1016273 → #1016274, relações #879/#880/#881 | Criadas e relidas nos dois endpoints de cada vínculo                      | Nenhuma   |

## Passagem

Entrada pronta para `project-slices`: este requisito aprovado, pai #1016274 confirmado na versão Livewire e dependências F01/F02/F03 registradas. Design fornecido preservado nas fontes do escopo. Sem slicing, tarefas DEV/QA ou implementação nesta etapa.
