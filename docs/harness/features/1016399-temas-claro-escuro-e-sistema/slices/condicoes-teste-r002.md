# Condições de teste

Pai: [#1016399 — Escolher tema claro, escuro ou sistema](https://redmine.remsoft.com.br/issues/1016399).

Revisão: r002 — proposta funcional para revisão; ainda não executada. A revisão r001 permanece preservada.

## Contexto

Telas de acesso existentes seguem automaticamente o dispositivo, sem seletor: logins de cliente/administração/suporte, cadastro, recuperação/redefinição de senha, verificação de e-mail e confirmação de senha nas condições reais, inclusive quando houver sessão. Na área de trabalho autenticada, cliente, administrador e suporte escolhem no menu da conta conforme permissões. Preparar dispositivo em Claro/Escuro/sem preferência, campos preenchidos, escolha autenticada oposta ao dispositivo, contextos de navegador independentes e falha controlada de lembrança. Inventário visual inclui dashboard, perfil, notificações, usuários, perfis, alertas e comandos/histórico, componentes e estados existentes. Matriz: 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768 e 1366×768; transições 767/768 e 1024/1025px. Conferir marca/hierarquia de #1016270 e legibilidade; não há mockup ou paleta escura exata aprovada. Condições são verificações futuras, sem execução neste fluxo.

## CT-001 — Primeiro acesso à área de trabalho acompanha o dispositivo

Verificação: Em contexto sem escolha autenticada anterior, entrar na área de trabalho com dispositivo em Claro e repetir em Escuro.

Resultado esperado: Sistema fica selecionado no menu da conta e produz a aparência correspondente ao dispositivo.

Origem no requisito: R1, CA01.

## CT-002 — Padrão autenticado sem preferência válida

Verificação: Entrar na área de trabalho sem preferência escura do dispositivo; repetir com dados do site limpos ou preferência autenticada inválida.

Resultado esperado: Sistema é o padrão autenticado; sem preferência escura informada, a aparência é clara.

Origem no requisito: R1, CA01, CA05.

## CT-004 — Escolher tema no menu da conta

Verificação: Como cliente, administrador e suporte, abrir o menu da conta e escolher Claro e Escuro nas telas autorizadas.

Resultado esperado: O seletor fica disponível no menu da conta, altera a aparência atual e mantém os outros controles alcançáveis.

Origem no requisito: R3, R4, CA02, CA06.

## CT-005 — Preservar formulário e filtros na escolha autenticada

Verificação: Na área de trabalho, com formulário preenchido ou filtros aplicados, trocar o tema pelo menu da conta.

Resultado esperado: Campos e filtros já presentes permanecem; não é necessário salvar o perfil ou reiniciar a navegação, sem criar persistência entre recargas.

Origem no requisito: R6, CA02, CA10.

## CT-006 — Acompanhar mudança do sistema na área de trabalho

Verificação: Selecionar Sistema no menu da conta e alterar a aparência do dispositivo com a aplicação aberta.

Resultado esperado: A aparência autenticada acompanha a mudança e Sistema continua identificado como a opção selecionada.

Origem no requisito: R1, CA03.

## CT-007 — Manter escolha explícita

Verificação: Na área de trabalho, escolher Claro ou Escuro e alterar o dispositivo; depois voltar a Sistema.

Resultado esperado: A escolha explícita permanece; ao voltar a Sistema, o acompanhamento é retomado.

Origem no requisito: R1, CA03.

## CT-008 — Lembrar na navegação e no retorno autenticado

Verificação: Escolher cada opção na área de trabalho, navegar, recarregar e fechar/reabrir com dados do site preservados; voltar à área de trabalho.

Resultado esperado: A opção autenticada é restaurada; em Sistema, usa a preferência atual do dispositivo. Nenhuma persistência nova de formulário/filtros é criada.

Origem no requisito: R2, CA04.

## CT-009 — Preservar a preferência autenticada entre contas

Verificação: Escolher na área de trabalho, sair e entrar novamente com a mesma conta e com outra conta no mesmo navegador.

Resultado esperado: A tela de acesso segue o dispositivo sem apagar a preferência guardada; as entradas na área de trabalho restauram a mesma opção do navegador.

Origem no requisito: R2, CA04.

## CT-010 — Isolar navegadores e limpar dados

Verificação: Acessar a área de trabalho com a mesma conta em outro contexto sem dados e limpar os dados no contexto original.

Resultado esperado: Cada contexto sem opção própria inicia autenticado em Sistema; não há sincronização por conta. Telas de acesso seguem o dispositivo independentemente da opção guardada.

Origem no requisito: R2, CA05.

## CT-011 — Lembrança autenticada indisponível

Verificação: Impedir a lembrança no navegador e escolher um tema na área de trabalho.

Resultado esperado: A opção aplica-se à página autenticada atual e a aplicação permanece utilizável; outro acesso pode voltar ao padrão. A aparência de acesso não exige gravar uma opção.

Origem no requisito: R2, CA09.

## CT-012 — Comparar jornadas de acesso nas duas aparências automáticas

Verificação: Percorrer todas as telas de acesso abrangidas com dispositivo em Claro e Escuro, incluindo as que exigem sessão e seus estados existentes.

Resultado esperado: Sem seletor, marca, hierarquia, texto, campos, bordas, ícones e mensagens ficam coerentes e legíveis nas duas aparências automáticas.

Origem no requisito: R3, R4, R5, CA06, CA07.

## CT-013 — Comparar jornadas autenticadas em ambos os temas

Verificação: Percorrer dashboard, perfil, notificações, gestão e suporte, incluindo tabelas com dados/vazias e saída de comandos.

Resultado esperado: A identidade e a legibilidade se mantêm nas superfícies; conteúdo funcional continua reconhecível, sem áreas claras ou escuras incoerentes que impeçam o uso.

Origem no requisito: R4, R5, CA07.

## CT-014 — Conferir componentes e estados

Verificação: Abrir menus, diálogos e painéis; conferir foco, seleção, desabilitado, carregamento, sucesso, aviso, erro e vazio nas duas aparências. Nas telas de acesso usar o dispositivo; na área de trabalho usar as opções. Incluir envbar permitida.

Resultado esperado: Os estados continuam distinguíveis e legíveis, a navegação permanece alcançável e a identificação dos ambientes conserva seu significado.

Origem no requisito: R4, R5, CA07.

## CT-015 — Usar seletor autenticado na matriz responsiva

Verificação: Selecionar as três opções no menu da conta de cliente, administrador e suporte, em toda a matriz e nas transições.

Resultado esperado: O seletor autenticado e os demais controles permanecem alcançáveis, sem alargar a página ou encobrir conteúdo/ações.

Origem no requisito: R3, CA06, CA08.

## CT-016 — Conferir operações e saídas preservadas

Verificação: Executar as operações existentes nas telas de acesso, perfil, gestão e suporte abrangidas, nos dois temas; registrar por tela quais operações foram exercitadas, seus resultados e restrições, justificando os casos não aplicáveis. Conferir também impressão, PDF e exportação onde já disponíveis.

Resultado esperado: Resultados, permissões e contexto de uso são preservados; impressão, PDFs e arquivos exportados mantêm a aparência e regras anteriores, sem receber automaticamente o tema escuro.

Origem no requisito: R6, CA10.

## CT-017 — Aparência automática de acesso sem seletor

Verificação: Abrir todas as telas de acesso em dispositivo Claro, Escuro e sem preferência escura, incluindo toda a matriz e as transições.

Resultado esperado: Não há seletor em nenhuma tela/faixa. A aparência acompanha o dispositivo, com fallback claro, inclusive em telas de acesso que exigem sessão.

Origem no requisito: R1, R3, CA01, CA06, CA08.

## CT-018 — Mudança do dispositivo em acesso com campos preenchidos

Verificação: Abrir uma tela de acesso, preencher os campos e alterar a aparência do dispositivo com a página aberta.

Resultado esperado: A aparência atualiza automaticamente sem perder os campos/contexto já presentes, mantendo identidade e legibilidade; não cria persistência de campos entre acessos.

Origem no requisito: R1, R4, R5, R6, CA03, CA07, CA10.

## CT-019 — Preferência autenticada não controla acesso direto

Verificação: Guardar uma escolha autenticada oposta ao dispositivo e abrir diretamente uma tela de acesso em nova navegação e após reabrir o navegador; depois voltar à área de trabalho.

Resultado esperado: A tela de acesso segue o dispositivo, sem seletor e sem apagar a escolha autenticada. A área de trabalho restaura a opção guardada no mesmo navegador.

Origem no requisito: R1, R2, R3, CA04, CA05, CA06.

## ID retirado e reservado

CT-003 — Escolher tema nas telas públicas. Retirada porque Mário eliminou a escolha manual nas telas de acesso; não executar nem reutilizar esse ID. CT-017 e CT-018 verificam o novo comportamento automático.
