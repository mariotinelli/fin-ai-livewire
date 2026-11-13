# Acesso autenticado e espaço financeiro pessoal

## Identidade

- Feature: [#1016271](https://redmine.remsoft.com.br/issues/1016271).
- Projeto: FinAi (65224).
- Versão: Livewire (20359).
- Situação: requisito aprovado; implementação não realizada neste fluxo.
- [Catálogo](../../scopes/2026-11-13-finai-mvp/scope.md).

## Objetivo

Permitir que qualquer pessoa crie e utilize sua conta pessoal, confirme o e-mail atual, entre, recupere a senha e saia pelo canal real do produto. A jornada entrega identidade e estado de confirmação corretos para as funcionalidades financeiras consumidoras.

## Resultado esperado

O titular conclui cadastro, confirmação, entrada, recuperação e saída e reencontra a própria conta nos próximos acessos. A QA verifica esses resultados pelas telas e links reais, sem precisar criar transações ou usar uma funcionalidade financeira futura.

## Atores e permissões

- Visitante: pode cadastrar-se, entrar e solicitar recuperação de senha; não acessa dados financeiros.
- Titular autenticado com e-mail pendente: pode confirmar o próprio e-mail, solicitar reenvio e sair; não acessa dashboard financeiro, transações ou assistente financeiro. As funções não financeiras existentes de conta e perfil mantêm suas permissões atuais.
- Titular autenticado com e-mail confirmado: acessa seu espaço financeiro e as capacidades já entregues.
- Administração e suporte: mantêm suas funções existentes; seus papéis não concedem acesso às finanças pessoais dos demais usuários por esta Feature.

## Histórias de usuário

1. Como visitante, quero cadastrar nome, e-mail e senha para começar a usar o FinAI sem convite.
2. Como titular, quero confirmar meu e-mail e reenviar o link quando necessário para liberar o acesso às finanças.
3. Como titular, quero entrar com minhas credenciais e reencontrar meus registros para continuar de onde parei.
4. Como titular, quero recuperar a senha por e-mail quando a esquecer.
5. Como titular, quero sair da conta para encerrar meu acesso atual.
6. Como titular, quero que minhas finanças permaneçam separadas das outras contas tanto na interface quanto no assistente.

## Fluxo principal

1. O visitante encontra a entrada da conta pessoal e as opções de cadastro e recuperação. A entrada principal do produto conduz ao acesso pessoal; áreas administrativas e de suporte mantêm suas entradas próprias.
2. No cadastro, informar nome, e-mail, senha e confirmação da senha. Com dados válidos e e-mail disponível, criar uma única conta pessoal e apresentar a orientação para confirmar o e-mail. Não solicitar dados financeiros no cadastro.
3. Solicitar o envio da confirmação ao e-mail cadastrado. Enquanto a confirmação estiver pendente, informar essa condição e disponibilizar reenvio e saída, sem liberar funcionalidades financeiras.
4. Ao abrir um link de confirmação válido da própria conta, autenticar-se quando necessário e confirmar o endereço. Liberar o espaço pessoal e encaminhar ao destino próprio originalmente solicitado, quando disponível e autorizado, ou à área inicial pessoal existente.
5. Nos próximos acessos, entrar com e-mail e senha. Uma conta confirmada acessa sua área pessoal; uma conta pendente continua na jornada de confirmação quando tentar usar as finanças.
6. Ao voltar à área pessoal existente ou entrar em outro navegador, reconhecer a própria conta e acessar somente seus dados pessoais permitidos. Trocar de conta não reaproveita a identidade da anterior.
7. Ao sair, encerrar a sessão atual e retornar ao login pessoal. Um novo acesso protegido exige autenticação.

## Fluxos alternativos e exceções

- Dados ausentes ou inválidos, e-mail já utilizado, senha fora da política atual ou confirmação divergente impedem concluir o formulário e apresentam erros nos campos. Cadastro duplicado não cria outra conta.
- Credenciais incorretas não autenticam. Preservar a limitação atual de tentativas e a indicação de quando tentar novamente; a opção existente de lembrar acesso não dispensa confirmação de e-mail.
- Um link de confirmação inválido, expirado, adulterado ou pertencente a outra conta não confirma o titular atual nem libera suas finanças. A pessoa pode solicitar novo link na jornada de confirmação.
- Abrir novamente um link ainda válido da própria conta já confirmada não cria conta nem desfaz a confirmação. Retomar o destino permitido sem repetir efeitos de confirmação.
- Enquanto aguarda confirmação, abrir diretamente um endereço financeiro ou tentar uma ação financeira continua sem liberar dados ou alterações. Essa regra vale para interface e assistente, não apenas para menus visíveis.
- Se o pedido de envio de e-mail falhar, informar a falha e permitir nova tentativa, respeitando os limites atuais. Não afirmar entrega na caixa de entrada; um pedido aceito de envio não comprova recebimento. Uma conta já criada permanece utilizável para entrar e reenviar a confirmação, sem exigir novo cadastro.
- Na recuperação, informar o e-mail e apresentar a resposta genérica já existente para contas conhecidas ou desconhecidas. O titular recebe um link para informar nova senha e confirmação. Link inválido, expirado ou utilizado não altera a senha e permite solicitar outro.
- Após redefinição bem-sucedida, retornar ao login pessoal. A senha nova funciona e a anterior não permite novos logins. Recuperar a senha não confirma o e-mail automaticamente nem remove a exigência pendente.
- Quando a alteração do e-mail no perfil existente retirar sua confirmação, o uso financeiro volta a exigir a confirmação do endereço atual. Preservar os registros do titular e os recursos existentes para retomar a conta; alterar somente o nome não exige nova confirmação.
- Sair de uma conta e entrar em outra apresenta o espaço da segunda conta, sem reaproveitar dados financeiros, mensagens ou propostas da anterior.

## Regras de negócio

**R1 — Conta aberta ao público.** Qualquer pessoa pode criar sua própria conta com nome, e-mail, senha e confirmação, usando o cadastro existente. A conta pública não recebe privilégios administrativos ou de suporte.

**R2 — Validações existentes.** Preservar a política atual de cadastro e recuperação: nome de 3 a 191 caracteres no cadastro; e-mail válido, disponível e com até 191 caracteres; senha e confirmação correspondentes, com até 191 caracteres no cadastro e política atual de ao menos oito caracteres, maiúscula, minúscula, número, símbolo e recusa de senha comprometida. Não criar política divergente entre cadastro e redefinição. Normalização e comparação de e-mail devem manter uma identidade consistente entre cadastro, login e recuperação, sem permitir contas duplicadas equivalentes.

**R3 — Confirmação obrigatória para as finanças.** Antes de disponibilizar qualquer dado ou ação financeira, exigir autenticação e confirmação do e-mail atual. A confirmação pertence à própria conta. Reenvio, login lembrado, recuperação de senha ou navegação direta não substituem a confirmação.

**R4 — Retomada.** Após autenticar e confirmar, retomar apenas um destino próprio, disponível e autorizado. Sem destino elegível, abrir a área inicial pessoal existente. A ausência de uma Feature financeira futura não autoriza criar página vazia ou simulada nesta entrega.

**R5 — Identidade e responsabilidade financeira.** A jornada de conta identifica o próprio titular e não permite trocar sua identidade por referência de outra pessoa. A separação de transações, indicadores, respostas, mensagens e propostas é uma regra transversal obrigatória: F04, F05, F06 e F07 a aplicam e verificam nas próprias interfaces quando introduzem esses recursos. Administração e suporte não recebem visão financeira de terceiros.

**R6 — Retorno à conta.** Novo login ou acesso em outro navegador identifica a mesma conta pessoal, sem gerar dados financeiros de exemplo. A persistência e a consulta dos registros financeiros pertencem às Features que entregam esses registros e permanecem obrigatórias nelas.

**R7 — Recuperação e saída.** Reutilizar a recuperação por e-mail e a saída existentes, preservando limites, validade de links e restrições atuais. A saída encerra o acesso atual; esta Feature não acrescenta gestão global de sessões ou dispositivos.

**R8 — Aceite próprio e consumidores.** F02 entrega cadastro, entrada, confirmação/reenvio, recuperação, saída, retomada e identidade do titular, verificáveis nas telas atuais. F04–F07 consomem essa identidade e exigem a confirmação antes de expor suas operações financeiras; cada Feature testa essa condição e o isolamento dos seus dados no próprio canal. O encerramento da QA da conta não declara esses recursos futuros testados.

**R9 — Apresentação.** Usar a fundação visual de F01 nas telas de cadastro, acesso, confirmação e recuperação, com rótulos, mensagens e estados em português brasileiro. Preservar os controles existentes de conta e perfil, sem aplicar regras de outras versões do projeto por inferência.

## Dados percebidos pelo usuário

Nome, e-mail, senha e confirmação; opção de lembrar acesso; condição de e-mail pendente ou confirmado; orientações de confirmação e recuperação; mensagens de validação, processamento, pedido de envio aceito, falha e limitação temporária; identificação da própria conta. Senhas não são apresentadas no perfil nem incluídas em mensagens. Os dados financeiros permanecem nos itens consumidores.

## Critérios de aceite

**CA01 — Cadastro pessoal.** Como visitante, encontrar a entrada pessoal e cadastrar nome, e-mail, senha e confirmação válidos, sem convite nem dados financeiros. Criar uma única conta pessoal e apresentar a jornada de confirmação, sem conceder privilégios administrativos.

**CA02 — Dados inválidos.** Exercitar campos obrigatórios, e-mail inválido ou duplicado, limites e política de senha, confirmação divergente e tentativas repetidas. Erros orientam a correção e não criam outra conta nem concluem a operação inválida. Cadastro e redefinição seguem a mesma política de senha.

**CA03 — Confirmação pendente.** Após cadastro ou login de conta pendente, apresentar a orientação de confirmar o e-mail atual, com reenvio e saída. A opção de lembrar acesso não transforma a conta em confirmada; as funções não financeiras de perfil mantêm as permissões atuais. A condição de acesso financeiro é aplicada e testada também nos canais que F04–F07 introduzirem.

**CA04 — Confirmação válida e retomada.** Abrir o link válido do próprio e-mail, autenticar-se se necessário e confirmar. Retomar destino próprio disponível e autorizado ou área inicial pessoal. Abrir novamente um link válido de conta já confirmada não repete efeitos nem cria conta.

**CA05 — Link recusado.** Usar link expirado, adulterado ou de outra conta: não confirmar o titular atual nem liberar finanças. Orientar como obter novo link sem enfraquecer as restrições existentes.

**CA06 — Reenvio e falhas.** Solicitar reenvio e observar feedback coerente com o pedido aceito. Respeitar os limites atuais; falha não se apresenta como envio bem-sucedido nem exige cadastrar novamente a conta já criada. O usuário mantém possibilidade de nova tentativa e saída.

**CA07 — Login e saída.** Credenciais válidas de conta confirmada permitem acessar a área pessoal; credenciais inválidas são recusadas com os limites atuais de tentativas. Sair encerra a sessão atual e retorna ao login pessoal; acesso protegido seguinte exige autenticação.

**CA08 — Recuperação.** Solicitar recuperação com conta existente e inexistente mantém resposta genérica. Link próprio válido permite definir senha conforme a política; a nova senha permite novos logins e a anterior deixa de permiti-los. Link inválido, expirado ou reutilizado não muda a senha. Redefinir não dispensa confirmação pendente.

**CA09 — E-mail alterado.** Alterar o e-mail no perfil existente retira a confirmação do endereço anterior e permite retomar a confirmação do endereço atual, preservando a identidade da conta. Alterar somente o nome mantém a confirmação. Não é necessário criar movimentações para verificar esse estado; o bloqueio financeiro decorrente é testado nos consumidores.

**CA10 — Identidade da própria conta.** Usar duas contas nas telas reais de entrada e perfil: cada uma reencontra sua identificação e seus dados pessoais permitidos. Sair, trocar de conta e acessar por outro navegador não mistura as identidades. Os testes de transações, indicadores, chat e propostas entre contas pertencem respectivamente a F04, F05, F06 e F07, mantendo o isolamento exigido em cada canal.

**CA11 — Fechamento da jornada.** Concluir cadastro, confirmação, entrada, recuperação, saída e retomada pela interface e links reais da área pessoal existente. Nenhum cenário obrigatório da QA da conta depende de telas financeiras futuras ou de valores demonstrativos.

**CA12 — Identidade visual.** As telas e estados abrangidos seguem o design fornecido e a base F01 em celular, tablet e desktop, incluindo espera, validação, falha, sucesso e limitação. A composição mantém disponíveis os controles de confirmação, reenvio, recuperação e saída, sem expor origem pessoal do design.

## Dependências

F01 — [Adequação visual completa do FinAI, #1016270](https://redmine.remsoft.com.br/issues/1016270): base visual consumida por esta entrega. A definição funcional de F02 pode avançar antes da implementação de F01; a entrega visual completa usa essa base.

F04–F07 dependem da identidade e da fronteira de acesso definidas aqui e são responsáveis por demonstrá-las nos dados financeiros que introduzirem. Nenhuma dependência exige implementar antecipadamente transações, dashboard ou IA nesta Feature.

## Designs e evidências

O design fornecido estabelece a identidade visual. As jornadas de acesso sem mockup próprio seguem a fundação F01, preservando seus campos e aplicando os estados exigidos por este requisito. Referência de aceite: CA12.

O projeto já possui cadastro, login pessoal, confirmação/reenvio, recuperação/redefinição, saída e perfil. A mudança funcional identificada é exigir confirmação antes de usar as finanças e tornar a entrada pessoal encontrável. A existência desses recursos no código não comprova execução nem aprovação dos fluxos.

## Dentro do escopo

Cadastro público pessoal com os dados existentes, entrada pessoal, login, confirmação de e-mail obrigatória para finanças, reenvio, recuperação de senha, saída, retomada autorizada e separação financeira por titular. Preservação das funções atuais de conta, administração e suporte, usando a identidade F01.

## Fora do escopo

Criação de transações, cálculos financeiros e integração com IA nesta Feature; contas compartilhadas; acesso administrativo às finanças de terceiros; novos fatores de autenticação, login social ou gestão de dispositivos. A edição de perfil existente é preservada e sua alteração de e-mail deve respeitar a regra de confirmação; não é uma nova gestão de perfil.
