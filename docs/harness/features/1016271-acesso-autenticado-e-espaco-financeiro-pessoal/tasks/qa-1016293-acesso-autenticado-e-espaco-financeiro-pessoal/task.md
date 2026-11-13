# [QA] [WEB] [USUARIO] Acesso autenticado e espaço financeiro pessoal

## Identidade

- Tarefa: [#1016293](https://redmine.remsoft.com.br/issues/1016293).
- Pai: [#1016271](https://redmine.remsoft.com.br/issues/1016271); [requisito](../../feature.md).
- Projeto FinAi (65224), versão Livewire (20359).
- Sequencing: 10.
- Estimativa: 1,5h, definida pelo responsável.
- [Slicing](../../slices/slices.md).
- [Condições de teste](../../slices/condicoes-teste-r002.md); [DOCX](<../../slices/r002/1016271 - Condições de testes.docx>).

## Entrega

Verificar a jornada inteira de conta pessoal e confirmação do e-mail atual, cobrindo cadastro, entrada, espera, reenvio, confirmação, retomada, recuperação, saída e preservação das funções existentes.

## Escopo e limites

Executar uma única QA para CT-001–CT-012 e para a integração da Feature. Preparar contas e links próprios de teste, controle de relógio e falha de solicitação de envio.

## Critérios de aceite

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

## Dependências

Executar após a conclusão de [[DEV] [WEB] [USUARIO] Acesso autenticado e espaço financeiro pessoal - Entrada pessoal e confirmação obrigatória](https://redmine.remsoft.com.br/issues/1016292), que já deve consumir a baseline visual da F01.

## Referências

Pai #1016271 revisado; condições r002, CT-001–CT-012, design fornecido e F01.

[Condições de teste r002 — DOCX anexado](https://redmine.remsoft.com.br/attachments/download/3355/1016271%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx).

Visual V01 — design fornecido: `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`. Verificar as telas de acesso e conta sem mockup específico sobre a linguagem visual compartilhada.

Intenção estável: `docs/harness/features/1016271-acesso-autenticado-e-espaco-financeiro-pessoal/slices/slices.md#QA-r001`.

[Design fornecido](../../../../scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip).
