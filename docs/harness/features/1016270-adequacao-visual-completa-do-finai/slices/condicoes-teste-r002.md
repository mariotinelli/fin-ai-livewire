# Condições de teste

Pai: #1016270 — [WEB] [USUARIO] Adequação visual completa do FinAI.

Revisão: r002. Documento de condições; QA ainda não executada.

## Contexto

Comparar com o design fornecido e com o requisito aprovado. Telas sem mockup individual herdam a identidade, mantendo seus campos, ações e permissões. Usar contas de cliente, administrador e suporte e variações de permissão; dados de teste com listas vazias, listas longas, textos extensos e validações. Não executar comandos perigosos nem excluir contas reais: usar ambiente e dados próprios de teste para ações que alteram dados. Dados e operações financeiras futuras não são criados nesta QA.

Matriz visual de todas as telas abrangidas: 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080. Conferir adicionalmente 767/768px e 1024/1025px. Comparação humana de aparência é necessária; ausência de overflow ou screenshot isolada não comprova fidelidade.

A única QA da Feature cobre CT-001–CT-018 e o fechamento integrado, com estimativa de 4h.

## CT-001 — Identidade e dashboard atual

Verificação: abrir o dashboard existente e comparar marca, paleta, tipografia, cartões e componentes aplicáveis com o design fornecido na matriz visual completa.

Resultado esperado: identidade FinAI; fundo #F5F7F8, superfícies brancas, texto #172622, secundário #52615C, verde #145C46, positivo #146345, negativo #A12B36, borda #D6DFDB e destaque #E4F0E9; títulos de destaque Georgia, corpo system-ui, controles com raio 8px e painéis 16px. Ritmo de espaçamento, bordas e sombras coerentes com o design; dashboard preserva finalidade atual sem dados financeiros demonstrativos.

Origem: R2, R3, R9, R10; CA02, CA10, CA11.

## CT-002 — Desktop e recolhimento

Verificação: nas três áreas, abrir telas com lateral aberta/recolhida em larguras a partir de 1025px; acessar destinos permitidos, conta, perfil, notificações e saída.

Resultado esperado: lateral desktop funcional, destino ativo, cabeçalho e conteúdo conforme referência; recolhimento preservado; a partir de 768px, superfície de trabalho com contorno 1px, raio 16px, margem 8px e cabeçalho transparente. Nenhum destino autorizado fica inacessível e os controles não se sobrepõem.

Origem: R6, R7; CA03, CA07.

## CT-003 — Tablet e altura reduzida

Verificação: usar 820×1180 e 1024×768, incluindo conteúdo longo e pouco espaço vertical; acessar navegação e ações da conta.

Resultado esperado: lateral compacta 72px mais área segura, marca compacta, alvos de pelo menos 48px, conteúdo ao lado e ausência de barra inferior; controles alcançáveis com rolagem apropriada e superfície de trabalho conforme CT-002.

Origem: R5, R6, R7; CA04, CA07.

## CT-004 — Celular e área segura

Verificação: usar 360×800, 390×844, 430×932 e 600×960; percorrer até o fim das páginas, focar campos, abrir menus, diálogos e notificações.

Resultado esperado: marca no topo, barra principal inferior em largura total com base 56px mais área segura, ícones 24px, alvos mínimos 44px, sem legenda visual e com nome acessível, foco e destino ativo. Conteúdo, mensagens e ações não ficam encobertos; todos os destinos atuais e ações da conta continuam disponíveis.

Origem: R4, R7; CA05, CA07, CA08.

## CT-005 — Transições de navegação

Verificação: após recolher a lateral no desktop, redimensionar entre 767/768px e 1024/1025px nas três áreas, com menus abertos e fechados.

Resultado esperado: cada faixa aplica o modo correto; não há barra inferior no tablet/desktop, estado recolhido não torna o celular ou tablet inacessível e controles/foco continuam alcançáveis sem rolagem horizontal da página.

Origem: R4–R7; CA03–CA07.

## CT-006 — Cadastro e três logins

Verificação: abrir cadastro e login de cliente, administração e suporte; comparar composição na matriz completa e exercitar envios válidos e inválidos com contas de teste e tipos permitidos/recusados.

Resultado esperado: marca e componentes FinAI, campos e mensagens legíveis; validações, restrições por área, estados de envio e resultados preservados. Não acrescentar regras de autenticação nesta Feature.

Origem: R1, R2, R8; CA01, CA02, CA06, CA08, CA09.

## CT-007 — Recuperação e confirmação

Verificação: percorrer recuperação/redefinição de senha, verificação de e-mail, reenvio e confirmação de senha, incluindo dados inválidos, mensagens e estados já existentes; comparar todas as telas na matriz visual.

Resultado esperado: mesma finalidade, campos, links, validações, operações e restrições atuais, com identidade FinAI e controles acessíveis, sem alterar tokens, validade ou efeitos das jornadas.

Origem: R1, R2, R8; CA01, CA02, CA06, CA08, CA09.

## CT-008 — Mouse, teclado e estados comuns

Verificação: em dashboard, navegação e telas de acesso, usar mouse e teclado; observar normal, hover, foco, ativo, desabilitado, carregamento, vazio, erro, sucesso, confirmação e cancelamento quando existentes.

Resultado esperado: estados distinguíveis e coerentes com a identidade; foco visível, rótulos preservados, menus e diálogos utilizáveis sem ações escondidas ou dados sobrepostos. Não adicionar estados fictícios a controles que não os possuem.

Origem: R2–R8; CA02, CA05, CA06, CA08, CA09.

## CT-009 — Permissões e destinos reais

Verificação: navegar como visitante e pelos três tipos de conta, variando permissões; tentar destinos diretos não permitidos; verificar links da conta e saída em cada faixa.

Resultado esperado: apenas destinos atuais autorizados são expostos; acessos indevidos mantêm recusa; perfil, notificações e saída permanecem alcançáveis. Não aparecem páginas ou atalhos financeiros futuros, credenciais alteradas ou operações liberadas pela mudança visual.

Origem: R7, R8, R10; CA07, CA09, CA11.

## CT-010 — Perfil e senha atuais

Verificação: nas áreas disponíveis, abrir perfil, editar dados pessoais e senha com dados válidos/inválidos; comparar formulários, feedback e estados na matriz inteira. Conferir também as apresentações legadas de perfil que ainda sejam consumidas.

Resultado esperado: campos, validações, mensagens e resultados preservados com identidade FinAI. O perfil roteado mantém seus formulários de dados e senha. O trecho legado de exclusão, apenas textual e sem operação inspecionada, não origina um novo fluxo de exclusão nesta entrega.

Origem: R1, R2, R8; CA01, CA02, CA06, CA08, CA09.

## CT-011 — Notificações

Verificação: abrir painel e histórico de notificações nas áreas disponíveis, com histórico vazio/longo, textos extensos, leitura/carregamento e ações já existentes; verificar pela matriz visual e teclado.

Resultado esperado: apresentação comum FinAI; dados, ações, ordenação e controles atuais preservados; conteúdo e ações alcançáveis no celular sem a barra inferior cobrir painel ou mensagens. A alteração não muda quais notificações pertencem ao usuário.

Origem: R1, R2, R7, R8; CA01, CA02, CA05, CA06, CA08, CA09.

## CT-012 — Gestão de usuários

Verificação: em dados de teste, percorrer listagem, busca, filtros/paginação existentes, criação, edição, exclusão, restauração e reenvio de convite; comparar listas, formulários e confirmações na matriz, com listas vazias/longas e permissões distintas.

Resultado esperado: composições e estados FinAI; dados e ações autorizadas preservados; diálogos e painéis utilizáveis, campos válidos/inválidos mantêm efeitos atuais e controles não desaparecem em telas estreitas. Ações não autorizadas permanecem recusadas.

Origem: R1, R2, R7, R8; CA01, CA02, CA06–CA09.

## CT-013 — Gestão de perfis de acesso

Verificação: percorrer lista, pesquisa/paginação, criação e edição de perfis, permissões e estados já existentes, com nomes/descrições longos e dados válidos/inválidos, na matriz inteira.

Resultado esperado: identidade e componentes coerentes; campos, ações e resultados mantidos; rótulos e permissões legíveis, tabela e formulário utilizáveis, sem ampliar privilégios.

Origem: R1, R2, R7, R8; CA01, CA02, CA06–CA09.

## CT-014 — Alertas de erros

Verificação: listar/filtrar alertas, abrir detalhes, mensagens técnicas e trace extensos, estados vazios e ações permitidas de reconhecer/resolver; percorrer matriz e teclado com conta autorizada e sem permissão.

Resultado esperado: lista e detalhes no padrão FinAI; conteúdo técnico permanece legível e alcançável, mesmo com rolagem interna; filtros, ações, validações e restrições atuais preservados sem overflow da página.

Origem: R1, R2, R7, R8; CA01, CA02, CA06–CA09.

## CT-015 — Executor e histórico Artisan

Verificação: em ambiente e comandos de teste autorizados, abrir executor, sugestões, validação, processamento, histórico e saída longa; comparar estados na matriz e verificar restrições por tipo/permissão e IP já existentes.

Resultado esperado: controles e estados FinAI preservam as operações e proteções atuais; saídas longas podem ser consultadas sem encobrir ações nem ampliar acesso. A QA não executa comandos destrutivos para comprovar aparência.

Origem: R1, R2, R7, R8; CA01, CA02, CA06–CA09.

## CT-016 — Componentes compartilhados nas áreas internas

Verificação: em perfil, notificações, gestão e suporte, observar botões, campos, tabelas, paginação, badges, menus, diálogos, painéis laterais e feedbacks, incluindo estados aplicáveis e interação por teclado na matriz inteira.

Resultado esperado: identidade, espaçamentos, tipografia, bordas, raios, sombras e estados comuns sem divergência entre consumidores; foco e rótulos preservados; mudanças nos controles compartilhados não quebram as áreas verificadas anteriormente nesta QA.

Origem: R1–R8; CA01–CA09.

## CT-017 — Conteúdo e fronteira

Verificação: percorrer todas as superfícies e estados abrangidos e comparar conteúdo funcional com a versão anterior.

Resultado esperado: marca do produto é FinAI, sem identidade genérica Rem Soft nas superfícies; nomes próprios e dados dos usuários não são alterados. Não há textos de armazenamento apenas local, conta local ou assistente simulado, nem novos destinos financeiros, valores fictícios ou regras financeiras/autenticação inventadas.

Origem: R2, R8–R10; CA09–CA11.

## CT-018 — Fechamento integrado

Verificação: após todos os DEV, revisar evidências de CT-001–CT-017, percorrer a matriz de todas as telas e repetir as jornadas afetadas por ajustes tardios de componentes/navegação; incluir três áreas, transições e conta/saída.

Resultado esperado: todas as telas atuais do inventário têm resultado de comparação com o design ou aplicação consistente da linguagem visual quando não há mockup, sem lacunas por área/tamanho/estado. Não há regressão de campos, ações, permissões ou funções atuais; defeitos e retestes têm resultado registrado. Aprovação visual não é inferida apenas de testes automatizados.

Origem: R1–R10; CA01–CA11.
