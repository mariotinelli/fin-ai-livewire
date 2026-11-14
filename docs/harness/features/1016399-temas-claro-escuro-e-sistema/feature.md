# Escolha de tema claro, escuro e sistema

## Identidade e revisão

- Feature: [#1016399](https://redmine.remsoft.com.br/issues/1016399), projeto FinAi (65224), versão Livewire (20359).
- Revisão funcional r002 aprovada por Mário nesta conversa e publicada/conferida. [Requisito r001 preservado](feature-r001.md); [slicing vigente](slices/slices.md).
- Decisão: não há seletor nas telas de acesso; elas seguem o dispositivo independentemente da escolha autenticada guardada. A escolha manual pertence ao menu da conta na área de trabalho.
- Origem textual remota: project-flow:2026-11-14-temas-e-responsividade:T01. Sua correspondência local é este requisito; o antigo marcador de caminho foi substituído na revisão autorizada.
- Sequencing do pai confirmado: 45. Status New preservado; nenhuma implementação ou QA executada neste fluxo.

## Objetivo

Permitir que usuários da área de trabalho autenticada escolham Claro, Escuro ou Sistema pelo menu da conta, lembrando a opção no navegador. Nas telas de acesso existentes, usar automaticamente a aparência do dispositivo, sem seletor.

## Resultado esperado

A escolha manual existe apenas na área de trabalho autenticada. As telas de acesso seguem a preferência do dispositivo, inclusive suas mudanças, independentemente da escolha explícita lembrada para a área de trabalho. Sem preferência escura informada, usar Claro. Ao sair da conta, não apagar a preferência autenticada; ao entrar novamente, restaurá-la.

## Atores e permissões

- Visitantes usam as telas de acesso com aparência automática, sem configuração de tema.
- Clientes, administradores e suporte escolhem o tema pelo menu da conta nas telas de trabalho já autorizadas.
- Não ampliar acesso a dados, telas ou operações.
- A preferência autenticada pertence ao navegador, não à conta; contas no mesmo navegador compartilham essa preferência.
- A política automática pertence às telas de acesso, inclusive quando alguma delas requer sessão, como confirmação de senha ou verificação de e-mail. Não confundir a superfície de acesso com a área de trabalho autenticada.

## Histórias de usuário

1. Como visitante, quero que login e demais jornadas de acesso acompanhem a aparência do dispositivo sem precisar configurá-la.
2. Como usuário autenticado, quero escolher Claro, Escuro ou Sistema pelo menu da conta sem perder o contexto da tela.
3. Como usuário autenticado, quero encontrar minha opção lembrada neste navegador ao retornar, sem mudar a aparência automática das telas de acesso.

## Fluxo principal

1. Abrir uma tela de acesso existente. Aplicar a aparência do dispositivo, sem seletor; na ausência de preferência escura, usar Claro.
2. Entrar na área de trabalho. Restaurar a escolha autenticada válida do navegador; sem escolha, iniciar em Sistema.
3. Abrir o menu da conta e selecionar Claro ou Escuro. A mudança ocorre na tela atual, identifica a opção e preserva campos/filtros, sem salvar perfil ou reiniciar a navegação.
4. Selecionar Sistema para acompanhar a aparência atual do dispositivo e suas alterações com a aplicação aberta.
5. Navegar, recarregar ou reabrir o navegador com dados preservados e manter a escolha autenticada.
6. Sair: a tela de acesso usa o dispositivo sem apagar a escolha guardada. Entrar novamente, inclusive com outra conta no mesmo navegador, restaura essa escolha.

## Fluxos alternativos e exceções

- As telas de acesso ignoram a escolha explícita autenticada, mas não a apagam.
- Outro navegador/contexto sem dados inicia a área de trabalho em Sistema; não há sincronização por conta.
- Sem preferência escura do dispositivo, a aparência automática e Sistema resultam em Claro.
- Limpar dados do site remove a escolha autenticada; no próximo acesso à área de trabalho, voltar a Sistema.
- Se não puder lembrar a opção, aplicar à página autenticada atual e manter a aplicação utilizável; não garantir restauração no próximo acesso.
- Em Claro/Escuro explícitos na área de trabalho, mudanças do dispositivo não substituem a escolha; retornar a Sistema retoma o acompanhamento.
- Aplicar/restaurar tema preserva o estado que a página já mantém, sem criar persistência de campos ou filtros entre recargas e retornos.

## Regras de negócio

**R1 — Opções e padrão.** Oferecer exatamente Claro, Escuro e Sistema somente na área de trabalho autenticada, com Sistema como padrão sem escolha anterior válida. Identificar a opção Sistema independentemente da aparência que produz. Nas telas de acesso, acompanhar o dispositivo sem opção manual e usar Claro se não houver preferência escura.

**R2 — Preferência autenticada por navegador.** Lembrar a opção entre navegação, recargas e próximos acessos autenticados, enquanto os dados do site forem preservados. Não sincronizar por conta nem exigir salvar perfil. Sair não apaga a escolha; telas de acesso não a utilizam e uma nova entrada a restaura. O mecanismo técnico fica para implementação.

**R3 — Local da escolha.** Disponibilizar o seletor apenas no menu da conta existente, utilizável em celular, tablet e desktop sem sobrepor controles. Não oferecer seletor nas telas de acesso nem criar páginas públicas adicionais.

**R4 — Cobertura visual.** Aplicar Claro e Escuro a todas as telas existentes: login de cliente, administração e suporte; cadastro; recuperação e redefinição de senha; verificação de e-mail; confirmação de senha; dashboard atual; perfil; gestão de usuários e perfis; alertas de erros e comandos de suporte. Incluir cabeçalho, navegação, tabelas, formulários, notificações, menus, diálogos, painéis laterais e feedbacks usados nessas telas. A barra de ambiente, quando disponível, mantém informações e controles legíveis e suas distinções de ambiente reconhecíveis.

**R5 — Identidade e estados.** O tema Claro preserva a identidade visual atual do FinAI, cuja referência aprovada está em #1016270. O tema Escuro adapta fundos, superfícies, textos, bordas e estados à aparência escura, mantendo marca, hierarquia e significado de cores e mensagens. Campos, ícones, seleção, foco, carregamento, desabilitado, sucesso, aviso, erro e estados vazios permanecem distinguíveis e legíveis. Não há paleta escura exata fornecida pelo responsável; não inventar uma referência aprovada.

**R6 — Comportamento preservado.** Trocar o tema não muda rotas, permissões, dados, efeitos de ações nem as regras de consulta. A alteração de aparência mantém o contexto de uso atual, incluindo campos preenchidos e filtros aplicados.

## Dados percebidos pelo usuário

Na área de trabalho, opção selecionada e aparência resultante; nas telas de acesso, somente aparência automática sem configuração manual. Superfícies, textos, bordas, ícones e estados conservam seus significados. A opção não é um dado do perfil da conta.

## Critérios de aceite

- **CA01 — Padrão:** nas telas de acesso, acompanhar o dispositivo sem seletor. Na área de trabalho sem escolha válida, identificar Sistema e usar a aparência correspondente. Sem preferência escura, usar Claro.
- **CA02 — Escolha autenticada:** pelo menu da conta, selecionar Claro e Escuro, identificar a opção e mudar a aparência atual sem salvar perfil nem perder campos/filtros.
- **CA03 — Acompanhamento:** nas telas de acesso, mudanças do dispositivo com a página aberta atualizam a aparência. Na área de trabalho, atualizar em Sistema; em Claro/Escuro explícitos, manter a escolha. Retornar a Sistema retoma o acompanhamento.
- **CA04 — Continuidade:** lembrar a escolha autenticada na navegação, recarga e reabertura com dados preservados. Sair mostra a aparência do dispositivo na tela de acesso sem apagar a escolha; entrar novamente ou usar outra conta no mesmo navegador restaura a opção autenticada.
- **CA05 — Independência:** outro navegador/contexto sem dados inicia a área de trabalho em Sistema. Limpar dados também devolve o padrão. Telas de acesso continuam independentes da escolha autenticada guardada.
- **CA06 — Acesso à escolha:** cliente, administrador e suporte usam as três opções no menu da conta das telas autorizadas; as telas de acesso permanecem sem seletor, inclusive quando requerem sessão.
- **CA07 — Cobertura visual:** percorrer as telas/componentes de R4 em Claro e Escuro, obtidos automaticamente nas telas de acesso e pelas opções na área de trabalho. Conferir identidade/legibilidade de R5, incluindo menus, diálogos, erros, carregamento, notificações e tabelas com dados/vazias.
- **CA08 — Responsividade:** conferir aparência e seletor autenticado em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768 e 1366×768, incluindo 767/768px e 1024/1025px. Não alargar página nem encobrir conteúdo/ações; telas de acesso não exibem seletor em nenhuma faixa.
- **CA09 — Lembrança indisponível:** ainda aplicar a opção à página autenticada atual e manter a navegação utilizável; o próximo acesso pode voltar a Sistema. A aparência das telas de acesso não exige gravar uma escolha.
- **CA10 — Operações equivalentes:** executar operações existentes de cada tela abrangida nas duas aparências, registrando operações verificadas e casos não aplicáveis. Preservar resultados, permissões e estado já mantido, sem nova persistência de campos/filtros. Impressão, PDFs e exportações mantêm regras e aparência anteriores.

## Dependências

Usar telas existentes e identidade visual de [#1016270](https://redmine.remsoft.com.br/issues/1016270). Não depende de funcionalidades futuras, de B01 ou de B02 para demonstrar escolha autenticada e aparência automática de acesso. Preservar as fronteiras das correções responsivas dos Bugs.

## Designs e evidências

Sem mockup de seletor ou paleta escura exata. A identidade/hierarquia FinAI de #1016270 orienta as duas aparências, com legibilidade conforme R4–R5. Não criar nova identidade nem afirmar conformidade a um mockup escuro inexistente.

Correção expressa de Mário nesta conversa: não oferecer temas para escolha nas telas públicas de login/esqueci a senha etc.; usar nelas, no máximo, o padrão do dispositivo. Esta proposta elimina o seletor de acesso, mantém a adaptação automática e separa sua política da escolha autenticada lembrada.

## Dentro do escopo

Três opções no menu da conta da área de trabalho autenticada e lembrança por navegador; aparência automática do dispositivo nas jornadas de acesso existentes sem seletor; cobertura visual das telas/componentes de R4 com identidade, legibilidade, contexto e operações preservados.

## Fora do escopo

Escolha manual nas telas de acesso; landing page, site institucional ou novas páginas públicas; sincronização por conta/dispositivo; temas personalizados/adicionais; seletor no perfil; novas telas financeiras; alteração de permissões/dados ou aparência de impressão/PDF/exportações. Envbar e tabelas responsivas continuam em B01 e B02.

## Publicação conferida

A descrição funcional integral r002 foi relida e corresponde ao conteúdo aprovado. Preservados status, prioridade, versão e relação relates 955 com #1016270. O slicing criou DEV #1016408–#1016411 e QAs #1016412–#1016413, total 18h, bloco 45–50. O DOCX r002 está associado às duas QAs, anexos 3381 e 3382, com links nas descrições. Os arquivos task.md por ID foram materializados após conferência.
