# Condições de teste

Pai: [#1016399 — Escolher tema claro, escuro ou sistema](https://redmine.remsoft.com.br/issues/1016399).

Revisão: r001 — proposta para revisão; ainda não executada.

## Contexto

Usar visitante e contas de cliente, administrador e suporte com acessos existentes. Cobertura pública: logins das áreas, cadastro, recuperação/redefinição de senha, verificação de e-mail e confirmação de senha nas condições reais de acesso. Cobertura autenticada: dashboard atual, perfil, notificações, Usuários, Perfis de acesso, Alertas de erros e comandos/histórico de suporte; incluir formulários, navegação, menus, diálogos, painéis laterais, feedbacks e envbar quando habilitada. Preparar contextos independentes de navegador, preferência de sistema clara/escura/sem preferência e indisponibilidade controlada da lembrança. Matriz: 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768 e 1366×768; transições 767/768 e 1024/1025px. Comparar identidade clara e hierarquia FinAI à referência #1016270; não há mockup ou paleta escura exata aprovada. Não há execução de testes neste documento.

## CT-001 — Primeiro acesso acompanha o dispositivo

Verificação: Em contexto sem escolha anterior, abrir a aplicação com dispositivo em claro e repetir em escuro.

Resultado esperado: Sistema fica selecionado e produz a aparência clara ou escura correspondente ao dispositivo.

Origem no requisito: R1, CA01.

## CT-002 — Padrão sem preferência válida

Verificação: Acessar sem preferência escura do dispositivo; repetir com dados do site limpos ou preferência anterior inválida.

Resultado esperado: Sistema é o padrão e a aparência é clara quando não houver preferência escura informada.

Origem no requisito: R1, CA01, CA05.

## CT-003 — Escolher tema nas telas públicas

Verificação: Como visitante, acessar os seletores das telas públicas abrangidas e escolher Claro e Escuro.

Resultado esperado: A opção selecionada é identificável e a aparência muda na tela atual, sem exigir autenticação nem salvar perfil.

Origem no requisito: R3, R4, CA02, CA06.

## CT-004 — Escolher tema no menu da conta

Verificação: Como cliente, administrador e suporte, abrir o menu da conta e escolher Claro e Escuro nas telas autorizadas.

Resultado esperado: O seletor fica disponível no menu da conta, altera a aparência atual e mantém os outros controles alcançáveis.

Origem no requisito: R3, R4, CA02, CA06.

## CT-005 — Preservar formulário e filtros

Verificação: Com formulário preenchido ou filtros aplicados, trocar o tema nos acessos disponíveis.

Resultado esperado: Campos e filtros permanecem; não é necessário reiniciar a navegação nem salvar o perfil.

Origem no requisito: R6, CA02, CA10.

## CT-006 — Acompanhar mudança do sistema

Verificação: Selecionar Sistema e alterar a preferência do dispositivo com a aplicação aberta; repetir nos seletores público/autenticado.

Resultado esperado: A aparência acompanha a mudança e Sistema continua identificado como a opção selecionada.

Origem no requisito: R1, CA03.

## CT-007 — Manter escolha explícita

Verificação: Escolher Claro ou Escuro e alterar a preferência do dispositivo; depois voltar a Sistema.

Resultado esperado: A escolha explícita permanece; ao voltar a Sistema, o acompanhamento é retomado.

Origem no requisito: R1, CA03.

## CT-008 — Lembrar na navegação e no retorno

Verificação: Escolher cada uma das três opções, navegar, recarregar e fechar/reabrir o navegador preservando os dados do site.

Resultado esperado: A opção escolhida é restaurada e aplicada; em Sistema, a aparência corresponde à preferência atual do dispositivo.

Origem no requisito: R2, CA04.

## CT-009 — Preservar entre contas no mesmo navegador

Verificação: Escolher um tema como visitante, entrar, sair e entrar com outra conta no mesmo navegador.

Resultado esperado: A preferência do navegador é mantida; a troca de conta não introduz uma preferência própria de perfil.

Origem no requisito: R2, CA04.

## CT-010 — Isolar navegadores e limpar dados

Verificação: Acessar a mesma conta em outro navegador/contexto sem dados do site e limpar os dados no contexto original.

Resultado esperado: Cada contexto sem escolha própria inicia em Sistema; não há sincronização por conta.

Origem no requisito: R2, CA05.

## CT-011 — Armazenamento indisponível

Verificação: Impedir a lembrança no navegador e escolher um tema pela interface.

Resultado esperado: A escolha ainda se aplica à página atual e o sistema continua utilizável; o próximo acesso pode voltar ao padrão.

Origem no requisito: R2, CA09.

## CT-012 — Comparar jornadas públicas em ambos os temas

Verificação: Percorrer todas as telas públicas abrangidas em Claro e Escuro, incluindo seus estados normais e mensagens existentes.

Resultado esperado: Marca, hierarquia, texto, campos, bordas, ícones e mensagens ficam coerentes e legíveis; Claro preserva a identidade vigente e Escuro a adapta sem inventar referência aprovada.

Origem no requisito: R4, R5, CA07.

## CT-013 — Comparar jornadas autenticadas em ambos os temas

Verificação: Percorrer dashboard, perfil, notificações, gestão e suporte, incluindo tabelas com dados/vazias e saída de comandos.

Resultado esperado: A identidade e a legibilidade se mantêm nas superfícies; conteúdo funcional continua reconhecível, sem áreas claras ou escuras incoerentes que impeçam o uso.

Origem no requisito: R4, R5, CA07.

## CT-014 — Conferir componentes e estados

Verificação: Abrir menus, diálogos e painéis laterais; conferir foco, seleção, desabilitado, carregamento, sucesso, aviso, erro e estado vazio nos dois temas; incluir envbar permitida.

Resultado esperado: Os estados continuam distinguíveis e legíveis, a navegação permanece alcançável e a identificação dos ambientes conserva seu significado.

Origem no requisito: R4, R5, CA07.

## CT-015 — Usar seletores na matriz responsiva

Verificação: Selecionar as três opções nas telas públicas e no menu da conta em toda a matriz, inclusive transições.

Resultado esperado: Seletores não alargam a página, não encobrem conteúdo/ações e preservam o acesso aos controles existentes.

Origem no requisito: R3, CA06, CA08.

## CT-016 — Conferir operações e saídas preservadas

Verificação: Executar as operações existentes nas telas de acesso, perfil, gestão e suporte abrangidas, nos dois temas; registrar por tela quais operações foram exercitadas, seus resultados e restrições, justificando os casos não aplicáveis. Conferir também impressão, PDF e exportação onde já disponíveis.

Resultado esperado: Resultados, permissões e contexto de uso são preservados; impressão, PDFs e arquivos exportados mantêm a aparência e regras anteriores, sem receber automaticamente o tema escuro.

Origem no requisito: R6, CA10.
