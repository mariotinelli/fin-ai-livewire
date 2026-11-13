# Condições de teste

Pai: #1016271 — [WEB] [USUARIO] Acesso autenticado e espaço financeiro pessoal.

Revisão: r002. Documento de condições; QA ainda não executada.

## Contexto

Uma única QA cobre a jornada inteira da conta, sobre a fundação F01 implementada e visualmente verificada. Usar contas próprias de teste, confirmadas e pendentes, e-mails conhecidos/desconhecidos, links válidos/expirados/adulterados/de outra conta, falha controlada na solicitação de envio e controle de relógio para limites/expiração. Não usar contas reais nem induzir envio a terceiros. Revisar evidência automatizada relevante e registrar execução, defeitos e um reteste focalizado.

Usar o design fornecido e a baseline F01. Comparar telas de entrada, cadastro, confirmação e recuperação e estados existentes em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080; mouse e teclado, foco e mensagens legíveis. Não reconstruir layout/identidade da F01 nesta Feature.

As doze condições são executáveis nas telas e links reais da jornada de conta. Os testes de isolamento de transações, indicadores, consultas e propostas pertencem às Features responsáveis por esses recursos. CT-012 verifica a identidade entre contas pelo acesso e perfil existentes.

## CT-001 — Entrada pessoal e cadastro público

Verificação: como visitante, abrir a entrada principal do produto, encontrar cadastro e recuperação e cadastrar nome, e-mail, senha e confirmação válidos; tentar fornecer privilégios de outra área.

Resultado esperado: entrada pessoal encontrável, conta pessoal única, sem convite nem dados financeiros e sem privilégios administrativos/suporte. Apresentar a jornada de confirmação antes do uso financeiro; entradas próprias de administração e suporte preservadas.

Origem: R1, R4, R9; CA01, CA04, CA12.

## CT-002 — Dados e identidade de e-mail

Verificação: omitir campos, usar nome fora de 3–191 caracteres, e-mail inválido/duplicado ou maior que 191 caracteres, confirmação divergente e variações de caixa/espaços entre cadastro, login e recuperação.

Resultado esperado: erros corrigíveis sem conta duplicada, alteração de conta alheia ou conclusão inválida. Normalização/comparação de e-mail preserva uma identidade consistente entre as jornadas, sem aceitar duplicatas equivalentes.

Origem: R1, R2; CA01, CA02.

## CT-003 — Política de senha consistente

Verificação: no cadastro e na redefinição, exercitar senha menor que oito caracteres, sem maiúscula/minúscula/número/símbolo, comprometida, confirmação divergente e limite de 191 no cadastro; comparar resultados.

Resultado esperado: política aprovada preservada e consistente; não consumir link nem alterar credenciais em redefinição inválida. Nenhuma senha é exposta no perfil ou nas mensagens.

Origem: R2, dados percebidos; CA02, CA08.

## CT-004 — Conta pendente e acesso lembrado

Verificação: cadastrar e entrar com conta pendente, inclusive usando lembrar acesso; percorrer a orientação de confirmação, reenvio, saída e as funções atuais não financeiras de perfil.

Resultado esperado: a jornada apresenta a necessidade de confirmar o endereço atual, com reenvio e saída disponíveis. Autenticação lembrada não muda o estado de confirmação. Perfil e funções não financeiras mantêm suas permissões, sem bloqueio indiscriminado. A condição é demonstrada nos formulários e estados reais da conta, sem uma tela financeira futura.

Origem: R3, R8; CA03, CA09, CA11.

## CT-005 — Confirmar e retomar

Verificação: abrir link válido da própria conta, autenticando-se quando necessário; exercitar destino próprio autorizado, destino de outra área/externo/inválido e ausência de destino; abrir novamente link válido após confirmação.

Resultado esperado: confirmar somente o titular correto, retomar apenas destino próprio disponível/autorizado ou a área inicial pessoal. Repetição não cria conta nem repete efeitos de confirmação. Não perder a retomada válida por exigir autenticação.

Origem: R3, R4; CA04, CA05.

## CT-006 — Links recusados

Verificação: abrir link expirado, adulterado, inválido ou de outra conta, incluindo após mudança de e-mail.

Resultado esperado: não confirmar o e-mail atual nem retirar sua pendência por um link inválido; orientar nova tentativa/reenvio sem ampliar validade ou aceitar link de outro titular.

Origem: R3, R4; CA05, CA09.

## CT-007 — Reenvio, limites e falhas

Verificação: solicitar reenvio, atingir limites atuais e tentar novamente quando liberado; provocar falha controlada ao solicitar envio, inclusive com conta já criada.

Resultado esperado: feedback de pedido aceito, nunca garantia de entrega na caixa postal; respeitar limites; falha comunicada sem sucesso fictício. Conta criada continua utilizável para entrar e reenviar, sem exigir novo cadastro nem duplicar conta.

Origem: R3, R7, R9; CA03, CA06, CA12.

## CT-008 — Login, saída e troca de conta

Verificação: entrar com credenciais válidas e inválidas, atingir limite atual de tentativas, sair e tentar acesso protegido; alternar duas contas.

Resultado esperado: credenciais corretas de conta confirmada permitem área pessoal; inválidas são recusadas e a limitação é indicada. Saída encerra a sessão atual e retorna ao login pessoal, sem acrescentar gestão global de dispositivos. Outra conta não herda identidade, dados ou contexto da anterior.

Origem: R3, R5, R7; CA07, CA10.

## CT-009 — Recuperação e redefinição

Verificação: solicitar recuperação para e-mails conhecidos/desconhecidos; redefinir com link próprio válido; repetir link utilizado e usar link inválido/expirado; entrar com senha antiga/nova.

Resultado esperado: resposta genérica preservada na solicitação; link válido permite nova senha conforme política, retorna ao login pessoal, senha nova funciona e antiga não permite novos logins. Link inválido/expirado/utilizado não altera senha e permite solicitar outro; limites existentes mantidos.

Origem: R2, R7; CA02, CA08.

## CT-010 — Recuperação e alteração do e-mail

Verificação: redefinir a senha de conta pendente e depois entrar; alterar o e-mail no perfil de conta confirmada; alterar somente o nome.

Resultado esperado: recuperar senha não confirma o e-mail automaticamente. A mudança real de e-mail retira a confirmação do endereço anterior e permite retomar a confirmação do endereço atual, mantendo a identidade e os dados pessoais da conta. Alterar somente o nome preserva a confirmação. As funções não financeiras continuam acessíveis conforme suas permissões.

Origem: R3, R5, R7; CA08, CA09.

## CT-011 — Identidade e estados visuais

Verificação: percorrer telas abrangidas e estados de espera, validação, envio, falha, sucesso e limitação sobre F01 na matriz completa, com teclado.

Resultado esperado: design fornecido e linguagem FinAI preservados; controles de confirmação/reenvio/recuperação/saída disponíveis, texto em pt-BR legível e rótulos/foco mantidos, sem expor origem pessoal do design ou refazer a fundação.

Origem: R9; CA12.

## CT-012 — Identidade da conta e fechamento da jornada

Verificação: usar duas contas com nomes e e-mails distintos nas telas reais de entrada e perfil. Sair de uma e entrar na outra, retornar à primeira e acessar a mesma conta por outro navegador. Completar cadastro, confirmação, entrada, recuperação, saída e retomada pelos canais disponíveis.

Resultado esperado: cada conta reencontra sua própria identificação e seus dados pessoais permitidos. A troca de conta não reaproveita a identidade da anterior; novo navegador autentica o mesmo titular correto. A jornada inteira é demonstrável sem criar transações, indicadores, chat, propostas ou dados simulados. Cada Feature financeira verifica o isolamento de seus próprios dados; a QA da conta conclui pela jornada real de acesso e perfil.

Origem: R5, R6, R8; CA10, CA11.
