# [DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Jornadas de acesso

## Identidade

- Tarefa: [#1016284](https://redmine.remsoft.com.br/issues/1016284).
- Pai: [#1016270](https://redmine.remsoft.com.br/issues/1016270); [requisito](../../feature.md).
- Projeto FinAi (65224), versão Livewire (20359).
- Sequencing: 4.
- Estimativa: 2h, definida pelo responsável.
- [Slicing](../../slices/slices.md).
- [Condições de teste](../../slices/condicoes-teste-r002.md); [DOCX](<../../slices/r002/1016270 - Condições de testes.docx>).

## Entrega

Adequar à identidade FinAI as telas de cadastro, login de cliente/administração/suporte, recuperação e redefinição de senha, verificação e reenvio de e-mail e confirmação de senha, utilizando as funções existentes.

## Escopo e limites

Adaptar a composição dessas telas e os campos de acesso comuns, sem alterar regras de autenticação, URLs, tokens ou permissões. As mudanças funcionais da entrada pessoal pertencem à F02.

## Critérios de aceite

- Apresentar marca, títulos, campos, botões, ajuda e links com a linguagem visual FinAI em todas as telas de acesso listadas, inclusive quando não houver mockup específico.
- Preservar os campos e as validações existentes ao enviar dados válidos e inválidos.
- Preservar as restrições por área e os resultados das operações de cadastro e login.
- Preservar o significado, os destinos e as comunicações atuais de recuperação, redefinição, verificação, reenvio e confirmação de senha.
- Aplicar a identidade aos estados existentes de normal, hover, foco, ativo, desabilitado, carregamento, vazio, erro, sucesso, confirmação e cancelamento quando aplicáveis às jornadas de acesso.
- Comparar os formulários, erros e processamento com a linguagem do design em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, mantendo campos e ações utilizáveis por mouse e teclado, sem corte, encobrimento ou rolagem horizontal da página.
- Manter foco e rótulos dos controles e preservar dados informados pelo usuário.
- Não criar novos destinos financeiros, dados de demonstração, regras de autenticação ou rótulos de conta local e assistente simulado.

## Dependências

Pode iniciar sobre os formulários existentes. Integrar a marca, a tipografia, os componentes e os estados compartilhados fornecidos por [[DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Identidade FinAI no dashboard atual](https://redmine.remsoft.com.br/issues/1016281) para concluir a apresentação.

## Referências

Pai #1016270; R1 (acesso), R2 e R8; CA01/CA02/CA06/CA08/CA09 no acesso; CT-006 a CT-009.

Visual V01 — design fornecido: `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`. Aplicar a identidade e os estados dos formulários às telas de acesso sem desenho próprio.

Identidade estável: `docs/harness/features/1016270-adequacao-visual-completa-do-finai/slices/slices.md#D04-r001`.

[Design fornecido](../../../../scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip).
