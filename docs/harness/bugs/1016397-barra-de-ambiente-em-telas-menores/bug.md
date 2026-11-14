# Barra de ambiente utilizável em telas menores

## Identidade e revisão

- Item B01 do [catálogo aprovado](../../scopes/2026-11-14-temas-e-responsividade/scope.md).
- Projeto: FinAi (65224). Versão escolhida por Mário: Livewire (20359).
- Bug [#1016397](https://redmine.remsoft.com.br/issues/1016397). Requisito e publicação aprovados por Mário nesta conversa; publicação relida e conferida. Nenhuma implementação realizada.
- Mário aprovou a separação dos itens e escolheu uma barra compacta e expansível no celular: ambiente visível; demais informações e controles ao expandir.

## Objetivo

Corrigir a apresentação da barra de ambiente em telas menores para que suas informações e controles permaneçam acessíveis sem quebrar a largura da página nem encobrir o conteúdo do sistema.

## Impacto

As evidências apresentam corte de conteúdo e deslocamento horizontal na tela de Usuários com a barra habilitada. Isso dificulta consultar as informações da barra e usar a página. A contribuição específica da barra para o problema deve ser distinguida do Bug B02 das tabelas.

## Comportamento atual

A captura E01 mostra ambiente, branch longa e controles de login na faixa superior de uma tela estreita, com conteúdo cortado e deslocamento horizontal. A inspeção do código confirma que a barra compartilhada apresenta ambiente, branch quando disponível, seleção de usuário e botão LOGIN. A causa técnica não foi comprovada e o defeito não foi reproduzido em navegador neste fluxo.

## Comportamento esperado

1. No celular, até 767px de largura, apresentar inicialmente a barra compacta com o ambiente visível e um controle para expandir.
2. Ao expandir, permitir consultar o nome completo da branch, quando disponível, e alcançar a seleção de usuário e o botão LOGIN já existentes. Permitir recolher novamente a barra.
3. Textos longos e controles devem caber ou se reorganizar dentro da largura disponível. A expansão e o recolhimento não podem encobrir conteúdo ou impedir a navegação na página.
4. Em tablet e desktop, preservar o acesso às informações e controles existentes, adaptando sua apresentação ao espaço disponível sem provocar rolagem horizontal da página.
5. Preservar as condições existentes de exibição da barra, os usuários selecionáveis e os efeitos e restrições da ação de login. A correção não habilita a barra em ambientes ou sessões onde ela não é permitida.

## Passos de reprodução conhecidos

1. Usar um contexto em que a barra de ambiente já esteja habilitada.
2. Abrir a lista de Usuários com o acesso atualmente exigido.
3. Usar uma branch com nome longo, como a exibida em E01.
4. Reduzir a largura da janela para uma faixa de celular e observar a barra e o conteúdo da página.

Os passos foram inferidos da evidência e dos elementos existentes, sem reprodução executada. A dimensão exata do viewport original não foi informada; as dimensões de validação abaixo são a proposta de aceite baseada na matriz já aprovada para #1016270.

## Contexto e condições

Abrange as telas existentes que incluem a barra, públicas ou autenticadas quando sua exibição já é permitida. Usar a tela de Usuários como referência inicial e conferir também o layout público de acesso, além do layout autenticado. Validar a barra com branch longa e, quando aplicável, sem identificação de branch, mantendo o ambiente e os controles disponíveis.

## Evidências

### E01

E01 — Barra de ambiente em tela menor; captura original de 14/11/2026 às 10:27:39.

[Baixar evidência E01](https://redmine.remsoft.com.br/attachments/download/3373/e01-envbar-tela-menor.png)

![Evidência E01](https://redmine.remsoft.com.br/attachments/download/3373/e01-envbar-tela-menor.png)

As capturas originais estão anexadas a esta issue e podem ser consultadas sem acesso ao computador de origem.

Referência de cobertura visual: [#1016270 — Adequação visual completa do FinAI](https://redmine.remsoft.com.br/issues/1016270).

## Frequência e alcance

Há uma captura específica do problema da barra. Frequência e abrangência exatas não foram medidas. A barra é compartilhada; a correção abrange seus consumidores existentes, sem afirmar que todos apresentam o mesmo defeito.

## Critérios de correção

- **CC01 — Estado compacto:** em 360×800, 390×844 e 430×932, abrir uma tela com a barra habilitada e verificar ambiente visível e controle de expansão disponível sem cortes ou alargamento da página causado pela barra.
- **CC02 — Informações e controles:** expandir a barra com branch longa; conferir que o nome completo pode ser consultado e que seleção de usuário e LOGIN são alcançáveis. Recolher e verificar o retorno ao estado compacto.
- **CC03 — Página utilizável:** nos estados compacto e expandido, acessar e rolar o conteúdo da página; a barra não encobre conteúdo, navegação nem ações. A barra não provoca rolagem horizontal global. O defeito independente da tabela pertence a B02.
- **CC04 — Transições e larguras:** conferir também 600×960, 820×1180, 1024×768 e 1366×768, incluindo a transição 767/768px. Redimensionar com a barra aberta e fechada e manter informações e controles alcançáveis.
- **CC05 — Operação preservada:** selecionar um usuário permitido e acionar LOGIN conforme o comportamento existente; conferir que a ação mantém seu resultado e suas restrições. Quando a branch não estiver disponível, a barra continua utilizável sem um espaço de texto quebrado.
- **CC06 — Cobertura compartilhada:** conferir a lista de Usuários e uma tela pública que já permita a barra. Em contextos onde sua exibição não é permitida, a correção não faz a barra aparecer.

## Designs e evidências

Não há mockup novo. E01 comprova o defeito observado; não é referência da composição final. A adaptação compacta e expansível foi escolhida expressamente por Mário nesta conversa. A linguagem visual existente e a separação entre barra de ambiente, cabeçalho e navegação principal são preservadas.

## Dentro do escopo

Apresentação responsiva da barra de ambiente compartilhada, estado compacto no celular, expansão/recolhimento, consulta da branch completa, acesso aos controles existentes e integração com o espaço disponível nos layouts consumidores.

## Fora do escopo

Correção das tabelas (B02), escolha de temas (T01), novas operações de login, alteração das permissões ou das condições que habilitam a barra e redesenho geral da navegação.

## Publicação autorizada e conferida

- Servidor: https://redmine.remsoft.com.br. Usuário consultado: Mário Tinelli (131789).
- Operação aprovada: criar um Bug (tracker 1) em FinAi (65224), versão Livewire (20359), status New (1), prioridade Normal (4), sem categoria, responsável, pai ou Sequencing definidos nesta operação.
- Título proposto: `[WEB] [SUPORTE] Corrigir barra de ambiente em telas menores`.
- Descrição: publicar integralmente de Objetivo até Fora do escopo, com os critérios CC01–CC06 e esta referência de origem estável: `docs/harness/.runs/2026-11-14-temas-e-responsividade/b01-envbar/bug.md`, item B01. Usar delimitadores project-flow.
- Após obter o ID, mover este requisito para `docs/harness/bugs/<ID>-barra-de-ambiente-em-telas-menores/bug.md`, manter a referência de origem na descrição e acrescentar o caminho definitivo. O ID será o retornado pela criação confirmada.
- Relação proposta: B01 `relates` #1016270, por compartilhar o contexto da adequação visual responsiva, sem impor bloqueio nem alterar o conteúdo da Feature.
- Não modificar outras issues ou relações. A publicação inicial não incluiu comentários nem anexos; os anexos foram acrescentados na correção solicitada pelo responsável.
- Buscas por títulos contendo “env” e “responsiv” em todos os status do projeto não retornaram candidatos. A similaridade e os campos devem ser reconferidos antes da publicação.

| Operação autorizada | Resultado conferido |
| --- | --- |
| Criar Bug com descrição integral e referência de origem | #1016397 criado, New, Normal, versão Livewire; descrição relida e equivalente à enviada |
| Acrescentar referência definitiva após confirmar o ID | Caminho definitivo adicionado à descrição, preservando origem e conteúdo |
| Relacionar B01 à #1016270 | Relação `relates` 953 confirmada entre #1016270 e #1016397 |

Na publicação inicial, Sequencing ficou vazio conforme project-flow. Após aprovação e publicação do slicing, o pai passou a espelhar 38. A ordem de catálogo não foi usada como número provisório. Mário perguntou pela sequência e recebeu essa explicação nesta conversa.

Próximo passo deste item: entrada para project-slices com este requisito aprovado e pai #1016397 confirmado. Não houve slicing, implementação ou comentários. E01 está anexada ao Bug no Redmine e referenciada acima.

## Correção das referências de evidência

Por solicitação de Mário, as referências ao computador de origem foram substituídas pelos anexos originais no Redmine, também incluídos como imagens na descrição. Anexos confirmados: [e01-envbar-tela-menor.png](https://redmine.remsoft.com.br/attachments/download/3373/e01-envbar-tela-menor.png). A alteração preserva critérios, status, versão, prioridade, campos e relações do requisito.

## Slicing publicado e conferido

[D01 #1016401](https://redmine.remsoft.com.br/issues/1016401) — 2h, Sequencing 38; [Q01 #1016402](https://redmine.remsoft.com.br/issues/1016402) — 1h, Sequencing 39. [Slicing](slices/slices.md). Relações e DOCX conferidos; task.md materializados. Próximo passo: plan-issue nas DEVs; implementação e QA ainda não executadas.
