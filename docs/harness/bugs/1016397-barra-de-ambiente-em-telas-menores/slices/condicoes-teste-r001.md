# Condições de teste

Pai: [#1016397 — Corrigir barra de ambiente em telas menores](https://redmine.remsoft.com.br/issues/1016397).

Revisão: r001 — proposta para revisão; ainda não executada.

## Contexto

Usar um ambiente que já permita a envbar, uma branch longa e usuários permitidos para troca. Conferir Usuários no layout autenticado e uma tela pública que permita a barra. A regra vigente habilita a barra em local/testing, em QA/homolog com as condições existentes e a oculta nos demais contextos. Não habilitar acesso novo. Comparar a falha registrada na evidência E01 (anexo 3373) com o comportamento compacto/expansível aprovado, sem usar a captura como mockup final. Matriz: 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768 e 1366×768; conferir 767/768px. Preparação, comparações visuais, ações de login e reteste dirigido fazem parte da QA; não há resultado de teste executado neste documento.

## CT-001 — Estado inicial compacto

Verificação: Abrir a lista de Usuários nas larguras de celular, com envbar habilitada e branch longa.

Resultado esperado: Até 767px, o ambiente e o controle de expansão ficam visíveis, sem corte nem aumento da largura causado pela barra.

Origem no requisito: CC01.

## CT-002 — Expandir e consultar a branch

Verificação: Expandir a barra e consultar a identificação de branch completa, inclusive um nome longo.

Resultado esperado: O nome completo fica consultável e seleção de usuário e LOGIN são alcançáveis dentro do espaço disponível.

Origem no requisito: CC02.

## CT-003 — Recolher a barra

Verificação: Com a barra expandida, recolher e expandir novamente.

Resultado esperado: Retorna ao estado compacto e continua permitindo acessar as informações e controles ao reabrir.

Origem no requisito: CC02.

## CT-004 — Conteúdo e navegação nos dois estados

Verificação: Na tela pública e na autenticada, rolar e acessar o conteúdo e a navegação com a barra compacta e expandida.

Resultado esperado: A barra não encobre conteúdo, mensagens, navegação ou ações nem provoca rolagem horizontal global; problemas próprios da tabela ficam em B02.

Origem no requisito: CC03, CC06.

## CT-005 — Redimensionar com a barra aberta e fechada

Verificação: Percorrer a matriz de viewports e a transição 767/768px em ambos os estados, nos dois layouts.

Resultado esperado: Informações e controles continuam alcançáveis em cada composição; o espaço reservado à página acompanha a apresentação da barra.

Origem no requisito: CC04.

## CT-006 — Trocar usuário com LOGIN

Verificação: Expandir, selecionar um usuário permitido e usar LOGIN, observando conta e destino resultantes.

Resultado esperado: A ação conserva o resultado e as restrições atuais; a adaptação visual não cria novas opções de usuário ou acesso.

Origem no requisito: CC05.

## CT-007 — Barra sem branch disponível

Verificação: Usar um contexto permitido em que a branch não esteja disponível e abrir/recolher quando aplicável.

Resultado esperado: Ambiente e controles permanecem utilizáveis sem uma área de texto quebrada ou conteúdo indevido.

Origem no requisito: CC05.

## CT-008 — Condições de habilitação preservadas

Verificação: Conferir um contexto já permitido e outro no qual a envbar deve permanecer ausente.

Resultado esperado: A barra aparece apenas conforme as condições vigentes e a correção não a habilita em contextos proibidos.

Origem no requisito: CC06.
