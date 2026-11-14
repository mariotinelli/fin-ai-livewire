# Escolha de tema claro, escuro e sistema

## Identidade e revisão

- Item T01 do [catálogo aprovado](../../scopes/2026-11-14-temas-e-responsividade/scope.md).
- Projeto: FinAi (65224). Versão escolhida por Mário: Livewire (20359).
- Feature [#1016399](https://redmine.remsoft.com.br/issues/1016399), requisito e publicação aprovados por Mário nesta conversa. Publicação relida e conferida. Nenhuma implementação realizada neste fluxo.
- Decisões de Mário nesta conversa: oferecer Claro, Escuro e Sistema; iniciar em Sistema; lembrar a escolha por navegador; disponibilizar o seletor no menu da conta e nas telas públicas.

## Objetivo

Permitir que visitantes e usuários autenticados escolham a aparência da interface entre Claro, Escuro e Sistema, preservando a identidade FinAI e a legibilidade das telas existentes.

## Resultado esperado

O usuário altera o tema pela própria interface e percebe sua aplicação na tela atual. A escolha acompanha a navegação e os próximos acessos no mesmo navegador. Na opção Sistema, a aparência acompanha a preferência clara ou escura do dispositivo, inclusive quando ela muda com a aplicação aberta.

## Atores e permissões

- Visitantes escolhem o tema nas telas públicas existentes que podem acessar.
- Usuários autenticados escolhem o tema pelo menu da conta, nas áreas de cliente, administração e suporte, conforme seus acessos atuais.
- A escolha não exige permissão administrativa e não altera o acesso às telas, dados ou operações.
- A preferência pertence ao navegador, sem sincronização por conta. Contas usadas no mesmo navegador compartilham essa preferência de aparência.

## Histórias de usuário

1. Como visitante, quero escolher a aparência antes de entrar para usar as telas de acesso no tema desejado.
2. Como usuário autenticado, quero alternar o tema pelo menu da conta para ajustar a aparência sem sair da tela em uso.
3. Como usuário, quero acompanhar o tema do dispositivo ou fixar Claro ou Escuro para controlar a aparência de cada navegador que utilizo.

## Fluxo principal

1. Acessar uma tela pública ou autenticada existente em um navegador sem escolha anterior. A opção selecionada é Sistema e a aparência corresponde à preferência do dispositivo.
2. Abrir o seletor nas telas públicas ou no menu da conta da área autenticada. Encontrar as opções Claro, Escuro e Sistema e identificar qual está selecionada.
3. Selecionar Claro ou Escuro. A aparência muda na tela atual, sem exigir salvar o perfil, sair da conta ou reiniciar a navegação; a operação em andamento não perde campos preenchidos nem filtros aplicados.
4. Navegar por outras telas permitidas, recarregar e retornar posteriormente no mesmo navegador. Manter a opção escolhida.
5. Selecionar Sistema. Aplicar a preferência atual do dispositivo e acompanhar suas alterações enquanto essa opção estiver selecionada.

## Fluxos alternativos e exceções

- Entrar ou sair da conta mantém a escolha do navegador. Trocar de conta no mesmo navegador não carrega uma preferência de tema distinta.
- Outro navegador ou contexto sem preferência anterior inicia em Sistema, independentemente da conta utilizada.
- Se o dispositivo não informar preferência escura, Sistema apresenta a aparência clara.
- Limpar os dados do site remove a preferência lembrada; no próximo acesso, voltar a Sistema.
- Se não for possível lembrar a preferência no navegador, a escolha ainda se aplica à página atual; o sistema continua utilizável, sem prometer que a escolha persistirá no próximo acesso.
- Em Claro ou Escuro, alterações da preferência do dispositivo não substituem a escolha explícita. Voltar a Sistema retoma o acompanhamento.

## Regras de negócio

**R1 — Opções e padrão.** Oferecer exatamente Claro, Escuro e Sistema, com Sistema como padrão quando não houver escolha anterior válida. O seletor distingue a opção Sistema da aparência efetivamente clara ou escura que ela produz.

**R2 — Preferência por navegador.** Lembrar a opção no mesmo navegador entre páginas, recargas e próximos acessos, enquanto os dados do site forem preservados. Não sincronizar com a conta nem exigir salvar configurações do perfil. O mecanismo técnico de armazenamento fica para implementação.

**R3 — Seletor disponível.** Na área autenticada, disponibilizar a escolha no menu da conta existente. Nas telas públicas, disponibilizar um seletor identificável sem exigir autenticação. Ambos devem ser alcançáveis em celular, tablet e desktop, sem sobrepor os controles atuais. A composição específica do seletor fica para implementação, mantendo esses resultados.

**R4 — Cobertura visual.** Aplicar Claro e Escuro a todas as telas existentes: login de cliente, administração e suporte; cadastro; recuperação e redefinição de senha; verificação de e-mail; confirmação de senha; dashboard atual; perfil; gestão de usuários e perfis; alertas de erros e comandos de suporte. Incluir cabeçalho, navegação, tabelas, formulários, notificações, menus, diálogos, painéis laterais e feedbacks usados nessas telas. A barra de ambiente, quando disponível, mantém informações e controles legíveis e suas distinções de ambiente reconhecíveis.

**R5 — Identidade e estados.** O tema Claro preserva a identidade visual atual do FinAI, cuja referência aprovada está em #1016270. O tema Escuro adapta fundos, superfícies, textos, bordas e estados à aparência escura, mantendo marca, hierarquia e significado de cores e mensagens. Campos, ícones, seleção, foco, carregamento, desabilitado, sucesso, aviso, erro e estados vazios permanecem distinguíveis e legíveis. Não há paleta escura exata fornecida pelo responsável; não inventar uma referência aprovada.

**R6 — Comportamento preservado.** Trocar o tema não muda rotas, permissões, dados, efeitos de ações nem as regras de consulta. A alteração de aparência mantém o contexto de uso atual, incluindo campos preenchidos e filtros aplicados.

## Dados percebidos pelo usuário

Opção de tema selecionada, aparência clara ou escura das telas, superfícies, textos, bordas, ícones e estados. A preferência de tema não é apresentada como dado do perfil da conta.

## Critérios de aceite

- **CA01 — Primeiro acesso:** em contexto sem preferência anterior, conferir Sistema selecionado; com dispositivo em claro, apresentar Claro; com dispositivo em escuro, apresentar Escuro. Sem preferência escura informada, apresentar Claro.
- **CA02 — Escolha explícita:** pela interface, selecionar Claro e depois Escuro. A mudança ocorre na tela atual e a opção selecionada fica identificável. Não exigir salvar perfil e não perder campos preenchidos nem filtros aplicados.
- **CA03 — Sistema dinâmico:** selecionar Sistema e alterar a aparência do dispositivo com a aplicação aberta; a interface acompanha. Repetir com Claro e Escuro selecionados e conferir que as escolhas explícitas permanecem.
- **CA04 — Continuidade no navegador:** escolher um tema, navegar, recarregar, fechar e reabrir o navegador preservando os dados do site; manter a opção. Entrar, sair e usar outra conta no mesmo navegador mantém essa preferência.
- **CA05 — Independência:** em outro navegador ou contexto sem dados do site, iniciar em Sistema, inclusive para a mesma conta. Após limpar os dados do site, voltar ao padrão Sistema.
- **CA06 — Acesso aos seletores:** conferir o seletor no menu da conta de cliente, administrador e suporte, conforme acessos existentes, e nas telas públicas abrangidas. Selecionar as três opções em celular, tablet e desktop sem perder acesso aos demais controles.
- **CA07 — Cobertura e estados:** percorrer as telas e componentes de R4 em Claro e Escuro, conferindo legibilidade, identidade e estados de R5. Verificar menus e diálogos abertos, campos com erro, carregamento, notificações e tabelas com dados e vazias conforme os estados existentes.
- **CA08 — Responsividade:** conferir a escolha e a aparência em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768 e 1366×768, incluindo transições 767/768px e 1024/1025px. Os seletores não alargam a página nem encobrem conteúdo ou ações.
- **CA09 — Preferência indisponível:** quando o navegador não permitir lembrar a opção, ainda aplicar a seleção à página atual e manter a navegação utilizável. O próximo acesso pode retornar ao padrão.
- **CA10 — Operações equivalentes:** executar operações já disponíveis nas telas abrangidas em ambos os temas e conferir resultados, permissões e preservação do contexto ao alternar a aparência. Impressões, PDFs e arquivos exportados mantêm suas regras atuais e não recebem automaticamente a aparência escura da interface.

## Dependências

Usa as telas existentes e a identidade visual documentada em [#1016270 — Adequação visual completa do FinAI](../1016270-adequacao-visual-completa-do-finai/feature.md). Não depende da criação de funcionalidades financeiras futuras, de B01 ou de B02 para demonstrar a escolha e aplicação dos temas. A validação integrada deve observar os seletores e as tabelas nos temas, sem absorver as correções responsivas dos Bugs.

## Designs e evidências

Não foi fornecido mockup de seletor nem paleta escura. O código inspecionado fixa `data-theme="remsoft"` nos layouts público e autenticado e define esse tema como claro. O menu da conta existente contém acesso ao perfil e saída; ele é o local aprovado para a escolha autenticada. As telas públicas recebem o acesso à escolha nesta Feature.

As decisões de padrão Sistema, preferência por navegador e locais do seletor foram explicitamente confirmadas por Mário nas respostas Q3–Q5. A adaptação visual é verificável por R4–R5 e CA06–CA08; detalhes de cores escuras e composição do controle serão elaborados pela implementação dentro desses limites.

## Dentro do escopo

Seleção utilizável de Claro, Escuro e Sistema em telas públicas e no menu da conta, aplicação às telas existentes e seus componentes, lembrança da preferência por navegador e acompanhamento da aparência do dispositivo em Sistema, preservando identidade, contexto e operações.

## Fora do escopo

Sincronização de tema por conta ou entre dispositivos, temas personalizados ou adicionais, seletor no perfil, novas telas financeiras, alteração de permissões ou dados e mudança da aparência de impressão, PDFs ou arquivos exportados. Correções responsivas da envbar e tabelas continuam em B01 e B02.

## Publicação autorizada e conferida

- Servidor: https://redmine.remsoft.com.br. Usuário consultado neste fluxo: Mário Tinelli (131789).
- Criar Feature (tracker 2) no projeto FinAi (65224), versão Livewire (20359), status New (1), prioridade Normal (4), sem categoria, responsável, pai ou Sequencing definidos nesta operação.
- Título: `[WEB] [USUÁRIO] Escolher tema claro, escuro ou sistema`.
- Descrição: publicar integralmente de Objetivo até Fora do escopo, incluindo histórias, fluxos, R1–R6 e CA01–CA10, com delimitadores project-flow e origem estável `docs/harness/.runs/2026-11-14-temas-e-responsividade/t01-temas/feature.md`, item T01.
- Após confirmar o ID retornado, mover para `docs/harness/features/<ID>-temas-claro-escuro-e-sistema/feature.md` e acrescentar esse caminho definitivo à descrição, preservando a referência de origem.
- Criar relação T01 `relates` #1016270, pela continuidade da identidade visual, sem impor bloqueio ou alterar o escopo da Feature existente. Não criar dependências de B01 e B02.
- Não alterar conteúdo ou campos de outras issues. Não enviar comentários ou anexos nesta operação.
- Buscas por “tema”, “escuro” e “aparência” nos títulos, em todos os status do projeto FinAi, não retornaram candidatos. Conferir novamente contexto e similaridade antes da publicação.

| Operação autorizada | Resultado conferido |
| --- | --- |
| Criar Feature com descrição integral e origem estável | #1016399 criada; Feature, New, Normal, FinAi, versão Livewire; descrição relida e equivalente à enviada |
| Acrescentar referência definitiva | Caminho docs/harness/features/1016399-temas-claro-escuro-e-sistema/feature.md acrescentado, preservando origem e conteúdo |
| Relacionar com #1016270 | Relação `relates` 955 confirmada entre #1016270 e #1016399 |

Sequencing confirmado vazio, aguardando reserva pelo project-slices. Não houve comentários, anexos, slicing ou implementação. Entrada disponível para project-slices: este requisito aprovado, pai #1016399 confirmado e referência visual #1016270. Sem decisão funcional pendente neste requisito.

## Correção de referência remota

A descrição no Redmine teve o link relativo da referência visual substituído pelo endereço de [#1016270](https://redmine.remsoft.com.br/issues/1016270). Esta Feature não recebeu capturas próprias na solicitação; as evidências dos defeitos pertencem aos Bugs #1016397 e #1016398, onde foram anexadas. Critérios, status e demais campos foram preservados.
