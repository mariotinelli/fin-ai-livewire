# [DEV] [WEB] [USUARIO] Acesso autenticado e espaço financeiro pessoal - Entrada pessoal e confirmação obrigatória

## Identidade

- Tarefa: [#1016292](https://redmine.remsoft.com.br/issues/1016292).
- Pai: [#1016271](https://redmine.remsoft.com.br/issues/1016271); [requisito](../../feature.md).
- Projeto FinAi (65224), versão Livewire (20359).
- Sequencing: 9.
- Estimativa: 2h, definida pelo responsável.
- [Slicing](../../slices/slices.md).
- [Condições de teste](../../slices/condicoes-teste-r002.md); [DOCX](<../../slices/r002/1016271 - Condições de testes.docx>).

## Entrega

Ajustar a entrada pessoal e a jornada de cadastro e login para que contas com e-mail pendente sejam encaminhadas à confirmação do endereço atual. Reaproveitar os fluxos existentes de conta e apresentar informações corretas sobre envio, falhas e retomada.

## Escopo e limites

Consumir a identidade e os componentes de F01, sem reconstruir a autenticação. Preservar o acesso às funções não financeiras de perfil e às entradas próprias de administração e suporte. As transações, os indicadores e o assistente são entregues pelas Features consumidoras.

## Critérios de aceite

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

## Dependências

O início depende da baseline visual implementada e verificada por [[QA] [WEB] [USUARIO] Adequação visual completa do FinAI](https://redmine.remsoft.com.br/issues/1016288). As Features financeiras posteriores consomem esta jornada; elas não bloqueiam o início desta entrega.

## Referências

Pai #1016271 revisado; R1–R9, CA01–CA12 e condições r002, CT-001–CT-012. Os recursos financeiros aplicam e testam o isolamento em suas próprias Features, sem condição futura para o encerramento desta jornada.

Visual V01 — design fornecido: `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`. Aplicar a linguagem visual da F01 às telas de entrada, cadastro, confirmação, reenvio e recuperação, incluindo seus estados atuais.

Intenção estável de criação: `docs/harness/features/1016271-acesso-autenticado-e-espaco-financeiro-pessoal/slices/slices.md#D01-r001`.

[Design fornecido](../../../../scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip).
