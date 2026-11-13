# Fatiamento de Acesso autenticado e espaço financeiro pessoal

## Identidade

- Pai: [#1016271](https://redmine.remsoft.com.br/issues/1016271); [requisito](../feature.md).
- Projeto FinAi (65224), versão Livewire (20359).
- Slicing publicado e conferido, sem implementação ou execução de QA neste fluxo.
- Uma única QA cobre a Feature inteira.

## Tarefas

| Tarefa                                                                                                                                                            | Papel | Horas | Sequencing |
| ----------------------------------------------------------------------------------------------------------------------------------------------------------------- | ----- | ----: | ---------: |
| [[DEV] [WEB] [USUARIO] Acesso autenticado e espaço financeiro pessoal - Entrada pessoal e confirmação obrigatória](https://redmine.remsoft.com.br/issues/1016292) | DEV   |     2 |          9 |
| [[QA] [WEB] [USUARIO] Acesso autenticado e espaço financeiro pessoal](https://redmine.remsoft.com.br/issues/1016293)                                              | QA    |   1,5 |         10 |

Total: 3,5h. Estimativas definidas pelo responsável; incluem verificação da entrega e QA integrada.

## Cobertura

| Origem aprovada                                           | Destino                                                                                                  | Evidência/condições  |
| --------------------------------------------------------- | -------------------------------------------------------------------------------------------------------- | -------------------- |
| R1 / CA01 — entrada pública e conta pessoal               | D01 adapta entrada/jornada, preserva criação Customer existente                                          | CT-001/CT-002        |
| R2 / CA02 — validações e identidade consistente de e-mail | D01 verifica/ajusta diferenças da jornada sem reconstruir política                                       | CT-002/CT-003        |
| R3 / CA03/CA05 — confirmação obrigatória e links          | D01 adapta espera, condição financeira e orientação de recusas                                           | CT-004/CT-006        |
| R4 / CA04 — confirmação e retomada autorizada             | D01 integra a retomada existente à entrada/espera                                                        | CT-005               |
| CA06 — pedido de envio, reenvio e falhas                  | D01 adapta estados/feedback e preserva limites                                                           | CT-007               |
| R7 / CA07 — credenciais, limites e saída                  | Existente por leitura: BaseLogin/Logout e testes dedicados; D01 preserva na integração                   | CT-008               |
| R2/R7 / CA08 — recuperação e nova senha                   | Existente por leitura: ForgotPassword/ResetPassword e testes; D01 garante coerência com nova condição    | CT-003/CT-009/CT-010 |
| CA09 — e-mail alterado e nome sem alteração do e-mail     | Existente por leitura: UserObserver e testes de perfil; D01 aplica a condição financeira do e-mail atual | CT-006/CT-010        |
| R5/R6 / CA10 — identidade entre contas                    | D01 e QA pelas telas reais de entrada e perfil                                                           | CT-008/CT-012        |
| R8 / CA11 — fechamento próprio                            | D01 entrega a jornada completa de conta; finanças têm aceite nos consumidores                            | CT-012               |
| R9 / CA12 — aparência sobre a base visual                 | D01 consome F01, sem refazer identidade/layout                                                           | CT-011               |

Todas as regras e critérios têm destino. “Existente por leitura” não significa teste executado ou conformidade de todo o requisito; os ajustes da jornada possuem dono D01. A atribuição aos consumidores de CT-012 está autorizada pelo próprio requisito e não é uma exclusão nova.

## Condições de teste

[Condições vigentes](condicoes-teste-r002.md) e [DOCX](<r002/1016271 - Condições de testes.docx>), associados à [QA #1016293](https://redmine.remsoft.com.br/issues/1016293).

## Descrições das tarefas

### [DEV] [WEB] [USUARIO] Acesso autenticado e espaço financeiro pessoal - Entrada pessoal e confirmação obrigatória

#### Entrega

Ajustar a entrada pessoal e a jornada de cadastro e login para que contas com e-mail pendente sejam encaminhadas à confirmação do endereço atual. Reaproveitar os fluxos existentes de conta e apresentar informações corretas sobre envio, falhas e retomada.

#### Escopo e limites

Consumir a identidade e os componentes de F01, sem reconstruir a autenticação. Preservar o acesso às funções não financeiras de perfil e às entradas próprias de administração e suporte. As transações, os indicadores e o assistente são entregues pelas Features consumidoras.

#### Critérios de aceite

- A entrada principal oferece acesso pessoal, cadastro e recuperação encontráveis.
- O cadastro cria uma conta pessoal, sem convite, dados financeiros ou privilégios administrativos e de suporte.
- Cadastro, login e recuperação utilizam uma identidade de e-mail consistente e não permitem contas duplicadas equivalentes.
- Preservar o limite de 3–191 caracteres para nome e de até 191 caracteres para e-mail válido e disponível no cadastro.
- Exigir senha e confirmação correspondentes, preservando o limite de 191 caracteres no cadastro e a política de pelo menos oito caracteres, com maiúscula, minúscula, número, símbolo e recusa de senha comprometida. A redefinição segue a mesma política de senha.
- Após cadastro ou login de uma conta pendente, apresentar a orientação de confirmação, reenvio e saída.
- Autenticação ou acesso lembrado não transforma uma conta pendente em confirmada; apresentar o estado correto na jornada pessoal.
- Manter o acesso ao perfil e às demais funções não financeiras conforme suas permissões atuais.
- Um link próprio válido confirma a conta uma única vez, exigindo autenticação quando necessária.
- Após confirmar, retomar apenas um destino próprio, disponível e autorizado ou a área inicial pessoal.
- Abrir novamente um link ainda válido de conta já confirmada não repete os efeitos da confirmação.
- Links inválidos, expirados, adulterados ou de outra conta não confirmam o titular atual e apresentam orientação para solicitar novo link.
- Um pedido de envio aceito apresenta feedback coerente, sem garantir entrega na caixa postal.
- Falha ao solicitar envio, inclusive depois de a conta ter sido criada, informa o problema e permite retomar ou reenviar, sem duplicar a conta ou apresentar sucesso falso.
- Preservar os limites atuais de solicitação e a possibilidade de nova tentativa quando liberada.
- Credenciais inválidas e excesso de tentativas mantêm a recusa e os limites atuais.
- Sair encerra a sessão atual e retorna ao login pessoal.
- Recuperação mantém resposta genérica na solicitação e o tratamento atual de links válidos, inválidos, expirados ou utilizados.
- Após redefinir a senha, a nova senha permite novos logins e a anterior deixa de permiti-los.
- Redefinir a senha não confirma automaticamente um e-mail pendente.
- Uma mudança real de e-mail retira a confirmação anterior e permite retomar a confirmação do endereço atual, preservando a identidade e os dados pessoais do titular.
- Alterar somente o nome preserva a confirmação do e-mail.
- Trocar de conta não reutiliza a identidade ou o contexto da conta anterior.
- Comparar as telas da jornada com o design fornecido e a base F01 em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, incluindo espera, validação, processamento, falha, sucesso e limitação. Manter texto legível, foco, rótulos, controles acessíveis e uso por teclado.
- Telas sem mockup específico herdam a linguagem FinAI, sem expor a origem pessoal do design.
- Concluir cadastro, confirmação, entrada, recuperação, saída e retomada nas telas e links reais da área pessoal existente.
- Conferir duas contas nos formulários de entrada e perfil: cada uma reencontra sua identificação e dados pessoais permitidos, inclusive após troca de conta e acesso por outro navegador. Nenhum teste obrigatório desta entrega depende de transações, indicadores ou chat futuros.

#### Dependências

O início depende da baseline visual implementada e verificada por [[QA] [WEB] [USUARIO] Adequação visual completa do FinAI](https://redmine.remsoft.com.br/issues/1016288). As Features financeiras posteriores consomem esta jornada; elas não bloqueiam o início desta entrega.

#### Referências

Pai #1016271 revisado; R1–R9, CA01–CA12 e condições r002, CT-001–CT-012. Os recursos financeiros aplicam e testam o isolamento em suas próprias Features, sem condição futura para o encerramento desta jornada.

Visual V01 — design fornecido: `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`. Aplicar a linguagem visual da F01 às telas de entrada, cadastro, confirmação, reenvio e recuperação, incluindo seus estados atuais.

Intenção estável de criação: `docs/harness/features/1016271-acesso-autenticado-e-espaco-financeiro-pessoal/slices/slices.md#D01-r001`.

### [QA] [WEB] [USUARIO] Acesso autenticado e espaço financeiro pessoal

#### Entrega

Verificar a jornada inteira de conta pessoal e confirmação do e-mail atual, cobrindo cadastro, entrada, espera, reenvio, confirmação, retomada, recuperação, saída e preservação das funções existentes.

#### Escopo e limites

Executar uma única QA para CT-001–CT-012 e para a integração da Feature. Preparar contas e links próprios de teste, controle de relógio e falha de solicitação de envio.

#### Critérios de aceite

- Verificar que a entrada pessoal, o cadastro e a recuperação estão encontráveis e que o cadastro público cria somente uma conta pessoal.
- Conferir dados inválidos, identidade de e-mail, política de senha e recusa de privilégios injetados.
- Conferir a orientação da conta pendente, reenvio e saída nas telas reais; o acesso lembrado não transforma seu e-mail em confirmado.
- Manter o acesso ao perfil não financeiro conforme suas permissões atuais.
- Confirmar somente o e-mail próprio por link válido e retomar apenas um destino autorizado, sem repetir efeitos.
- Verificar a recusa de links expirados, adulterados ou pertencentes a outra conta.
- Provocar falha controlada no pedido de envio e conferir mensagem coerente, reenvio, limites e nova tentativa, sem exigir recriar uma conta existente ou anunciar entrega na caixa postal.
- Verificar credenciais inválidas, limites de tentativas e encerramento da sessão atual pela saída.
- Conferir resposta genérica na recuperação, nova senha e tratamento dos links inválidos, expirados ou utilizados.
- Confirmar que recuperar a senha não dispensa a confirmação de e-mail pendente.
- Comparar a mudança real de e-mail com a alteração somente do nome, preservando o comportamento de confirmação correspondente.
- Conferir troca de conta e preservação das funções não financeiras e das entradas de administração e suporte.
- Comparar telas e estados de CT-011 com o design fornecido e a base F01 em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, verificando legibilidade, teclado, foco, rótulos e acesso às ações.
- Registrar resultados de R1–R9, CA01–CA12 e CT-001–CT-012, defeitos e reteste focalizado.
- Executar CT-012 pelas telas reais de entrada e perfil de duas contas, incluindo saída, troca de conta, retorno e novo navegador, sem misturar suas identificações ou dados pessoais. A QA da conta encerra com esse fluxo próprio, sem testes pendentes de recursos financeiros futuros.

#### Dependências

Executar após a conclusão de [[DEV] [WEB] [USUARIO] Acesso autenticado e espaço financeiro pessoal - Entrada pessoal e confirmação obrigatória](https://redmine.remsoft.com.br/issues/1016292), que já deve consumir a baseline visual da F01.

#### Referências

Pai #1016271 revisado; condições r002, CT-001–CT-012, design fornecido e F01.

[Condições de teste r002 — DOCX anexado](https://redmine.remsoft.com.br/attachments/download/3355/1016271%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx).

Visual V01 — design fornecido: `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`. Verificar as telas de acesso e conta sem mockup específico sobre a linguagem visual compartilhada.

Intenção estável: `docs/harness/features/1016271-acesso-autenticado-e-espaco-financeiro-pessoal/slices/slices.md#QA-r001`.

## Sequencing e dependências

O pai espelha o primeiro número de seu bloco, sem consumir posição adicional. Os bloqueios confirmados estão nas descrições e relações das tarefas. Nenhuma dependência de integração foi convertida em bloqueio apenas por compartilhar arquivos.
