# Gestão de transações

## Identidade

- Feature: [#1016274](https://redmine.remsoft.com.br/issues/1016274).
- Projeto: FinAi (65224).
- Versão: Livewire (20359).
- Situação: requisito aprovado; implementação não realizada neste fluxo.
- [Catálogo](../../scopes/2026-11-13-finai-mvp/scope.md).

## Objetivo

Permitir ao usuário registrar, editar, excluir e consultar receitas e despesas realizadas, com categorias e histórico pesquisável, mantendo seus registros persistidos e separados dos demais usuários.

## Resultado esperado

O titular registra suas movimentações manualmente e encontra os mesmos dados ao voltar ao sistema ou acessar sua conta em outro navegador. Pode consultar detalhes, corrigir um registro ou excluí-lo após confirmação. O histórico e os detalhes refletem os dados atuais na própria conclusão. F05, F06 e F07 verificam os efeitos nos canais que cada uma entrega.

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
3. Escolher receita ou despesa, informar valor positivo, descrição, categoria compatível do catálogo predefinido desta Feature e data não futura.
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

**R5 — Categorias predefinidas.** Disponibilizar o mesmo catálogo a todos os titulares, com quatro receitas — Salário, Freelance, Rendimentos, Outras receitas — e oito despesas — Alimentação, Moradia, Transporte, Saúde, Educação, Lazer, Compras, Outras despesas. Preservar nomes e acentos, sem manutenção, personalização, subcategorias ou importação pelo usuário. Uma transação exige categoria existente e compatível com seu tipo, incluindo as alternativas gerais. Trocar o tipo reapresenta as opções compatíveis e não permite salvar uma categoria anterior incompatível ou oculta. As categorias continuam disponíveis sem movimentações; falha real de obtenção das opções não é apresentada como catálogo vazio nem permite categoria improvisada. Histórico, filtros e futuras consultas/propostas utilizam o mesmo vocabulário.

**R6 — Titularidade e persistência.** Associar o registro ao usuário autenticado, sem aceitar escolha de outro titular. A titularidade não é campo editável. Consultas, detalhes e alterações respeitam F02, inclusive em acessos diretos. A mesma conta reencontra os registros ao retornar ou trocar de navegador.

**R7 — Histórico.** A consulta inicial usa mês corrente. Permitir pesquisar parte da descrição e filtrar por tipo, categoria e mês; combinar os filtros com a pesquisa. A pesquisa ignora diferenças de maiúsculas e acentos e trata os caracteres digitados como texto literal. Os filtros só restringem os registros do titular.

**R8 — Limpeza, ordem e paginação.** Limpar filtros remove descrição, tipo, categoria e mês, passando a consultar todo o histórico. Ordenar por data da transação da mais recente para a mais antiga; para a mesma data, os registros criados mais recentemente aparecem primeiro, com desempate estável. Exibir até 50 registros por página, contagem de resultados, página atual e controles anterior/próxima quando necessários. Alterar um filtro ou pesquisa retorna à primeira página. Após edição ou exclusão, manter uma página válida do recorte.

**R9 — Detalhes e edição.** Os detalhes apresentam os cinco campos obrigatórios integralmente. A edição atualiza o mesmo registro, sem criar cópia, e permite alterar tipo, valor, descrição, categoria e data respeitando as regras. Criar duas transações legítimas com os mesmos dados é permitido.

**R10 — Exclusão confirmada.** Exigir confirmação explícita antes de excluir. Explicar que o registro deixa o histórico e os totais e que não existe desfazer no produto. Após sucesso, o registro não aparece em consultas financeiras ativas nem contribui para saldo, totais ou balanços. A regra define o efeito percebido pelo usuário, sem impor mecanismo interno de armazenamento.

**R11 — Fechamento e consumidores.** Criação, edição e exclusão bem-sucedidas atualizam o histórico e os detalhes apresentados nesta Feature, sem exigir novo login. F05 verifica seus indicadores após alterações manuais; F06 verifica consultas novas sobre dados atuais; F07 verifica os efeitos de seus registros por IA no histórico, nas consultas e no dashboard já entregue. Essas integrações não são condições futuras de encerramento da QA de F04. Mensagens históricas da IA não são reescritas por alterações posteriores.

**R12 — Apresentação.** Seguir o design fornecido para Transações, formulário, detalhes, confirmação e estados aplicáveis, usando F01. No celular, campos ocultos na linha resumida continuam disponíveis nos detalhes. Manter os nomes das categorias predefinidas e as informações de valor, tipo e data compreensíveis.

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

**CA08 — Exclusão.** Excluir exige a confirmação de R10. Após sucesso, o registro deixa o histórico e os detalhes disponíveis ao titular, sem desfazer. A exclusão é preservada nos dados reais; F05 e F06 verificam o reflexo nos seus indicadores e consultas ao entregarem esses canais.

**CA09 — Falhas e repetição.** Falhas de leitura não parecem histórico vazio; falhas de gravação não parecem sucesso e permitem retomada. Enquanto processa, a interface não permite repetir o mesmo envio. Duas transações intencionais de dados iguais continuam permitidas. Registro removido durante a edição não é recriado silenciosamente.

**CA10 — Isolamento e confirmação.** Como visitante ou conta com e-mail pendente, não acessar nem alterar finanças. Com duas contas confirmadas, cada uma só consulta e altera os próprios registros; referências diretas de outra conta não revelam nem modificam seus dados. Trocar de conta não reutiliza registros da anterior.

**CA11 — Estados vazios.** Sem registros, mostrar orientação de primeiro cadastro; sem correspondências, informar ausência no recorte e permitir limpar filtros. Nenhum desses estados inventa transações ou substitui falhas de consulta.

**CA12 — Fechamento funcional e integração.** Demonstrar cadastro, consulta, filtros, detalhes, edição e exclusão de transações reais na interface desta Feature. O aceite dos indicadores após mudanças manuais pertence a F05 e o das novas consultas pertence a F06; o registro por IA e seu efeito integrado pertencem a F07. O aceite de F04 é concluído pelo fluxo manual real.

**CA13 — Fidelidade visual.** Comparar a superfície Transações e os diálogos aplicáveis com o design fornecido nas nove dimensões previstas por F01. Preservar hierarquia, controles, estados e ações utilizáveis; descrições e valores extensos não encobrem controles, e detalhes expõem o conteúdo resumido na listagem móvel.

**CA14 — Catálogo visível e classificação.** No formulário de receita, encontrar exatamente as quatro categorias de receita; no de despesa, exatamente as oito de despesa de R5. Duas contas recebem o mesmo catálogo, sem compartilhar registros. Criar e editar com categoria compatível é permitido; categoria inexistente ou do tipo oposto é recusada. A troca de tipo mostra a categoria compatível que será salva, e histórico e filtros preservam os mesmos nomes, inclusive Outras receitas e Outras despesas.

**CA15 — Catálogo sem manutenção e estados.** Mesmo sem transações, as opções predefinidas continuam disponíveis no formulário. A interface não oferece criação, edição, exclusão ou personalização de categorias nem uma nova tela de gestão. Falha real ao obter opções é comunicada e não permite salvar categoria improvisada. Nomes e seleção são legíveis em celular, tablet e desktop, conforme a base visual de F01.

## Dependências

- F01 — [#1016270](https://redmine.remsoft.com.br/issues/1016270): base visual e navegação.
- F02 — [#1016271](https://redmine.remsoft.com.br/issues/1016271): conta, identidade e confirmação do e-mail.
- F05/F06/F07 consomem transações e categorias já entregues. F04 encerra seu próprio aceite na interface de gestão, sem exigir esses consumidores futuros.

## Designs e evidências

O design fornecido é a referência da listagem, filtros, mês, paginação, formulário, detalhes e confirmação de exclusão. Os controles foram aprovados em Q2, as categorias em Q4 e as regras de data/exclusão em Q5/Q6. A revisão de catálogo aprovada incorpora as categorias no primeiro fluxo que permite selecioná-las, persistir e conferir sua classificação. Referência de aceite visual: CA13 e CA14/CA15 para as categorias.

## Dentro do escopo

Gestão manual completa de receitas e despesas realizadas em BRL, catálogo comum de categorias, validação da classificação, persistência por titular, edição, detalhes, exclusão confirmada, pesquisa, filtros, paginação e estados. O resultado é verificável no formulário e histórico reais.

## Fora do escopo

Lançamentos futuros ou previstos, recorrência, parcelamento, transferências entre contas, importação, integração bancária, cartões, categorias personalizadas e desfazer exclusão. Dashboard e assistente são entregues nas Features responsáveis; esta entrega não cria versões simuladas dessas capacidades.
