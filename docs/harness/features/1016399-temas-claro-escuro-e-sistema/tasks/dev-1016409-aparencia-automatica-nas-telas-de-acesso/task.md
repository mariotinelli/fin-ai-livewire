# [DEV] [WEB] [USUÁRIO] Escolher tema claro, escuro ou sistema - Aparência automática nas telas de acesso

## Identidade e fontes

- Filha: [#1016409](https://redmine.remsoft.com.br/issues/1016409); papel DEV.
- Pai: [#1016399](https://redmine.remsoft.com.br/issues/1016399); requisito canônico: docs/harness/features/1016399-temas-claro-escuro-e-sistema/feature.md.
- Slicing aprovado: [slices.md](../../slices/slices.md), revisão r002.
- Sequencing: 46. Estimativa: 2h, conforme revisão aprovada; pareceres e fundamento em slices.md.
- Condições: [Markdown r002](../../slices/condicoes-teste-r002.md); [DOCX confirmado na QA #1016412](https://redmine.remsoft.com.br/attachments/download/3381/1016399%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx); [DOCX confirmado na QA #1016413](https://redmine.remsoft.com.br/attachments/download/3382/1016399%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx).
- Situação: publicação e relações conferidas; implementação e execução QA não realizadas.

## Entrega

Aplicar automaticamente a aparência do dispositivo às jornadas de acesso existentes, sem seletor de tema. Reaproveitar a paleta compartilhada e adaptar as superfícies de acesso, mantendo a preferência explícita da área de trabalho fora dessas telas.

## Escopo e limites

Abranger logins, cadastro, recuperação/redefinição de senha, verificação de e-mail e confirmação de senha conforme acesso real, inclusive quando houver sessão. A política depende da superfície de acesso, não apenas da existência de usuário autenticado. Não criar novas páginas públicas. Esta entrega não guarda nem apaga a escolha da área de trabalho.

## Critérios de aceite

- Todas as telas de acesso abrangidas ficam sem seletor e usam a aparência atual do dispositivo; sem preferência escura informada, usam Claro.
- Alterar a aparência do dispositivo com a tela de acesso aberta atualiza a página sem perder campos, mensagens ou contexto já presentes.
- A aparência automática da tela de acesso não depende da escolha explícita usada na área de trabalho e não cria uma preferência manual própria.
- Nas duas aparências automáticas, marca, hierarquia, superfícies, textos, bordas, ícones, campos e estados de foco/seleção/desabilitado/carregamento/sucesso/aviso/erro ficam coerentes e legíveis. Manter a identidade de #1016270, sem mockup escuro inventado.
- Conferir todas as jornadas de acesso em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768 e 1366×768 e 767/768px e 1024/1025px, inclusive telas que exigem sessão: sem seletor, sem alargar a página ou encobrir conteúdo/ações.
- Operações, validações e restrições existentes são preservadas. Envbar permitida mantém informações e distinções legíveis; impressão/PDF/exportações não recebem automaticamente a aparência escura.

## Dependências

Bloqueio de início pela base visual de “Escolher tema claro, escuro ou sistema - Escolha clara e escura no menu da conta”. Reaproveitar a observação do dispositivo com a entrega “Sistema como padrão e acompanhamento”, sem duplicar trabalho. Não aguarda a lembrança autenticada para funcionar; o caso de preferência guardada oposta ao dispositivo é integrado pela entrega de lembrança.

## Referências

[Feature #1016399](https://redmine.remsoft.com.br/issues/1016399), revisão funcional r002 proposta. [Identidade visual #1016270](https://redmine.remsoft.com.br/issues/1016270), aplicada às telas e estados existentes. Sem mockup de seletor ou paleta escura exata; seguir R4–R5 e a decisão de retirar o seletor das telas de acesso.

Cobertura: R1 aparência de acesso; R3 sem seletor; R4–R6 nas jornadas de acesso; CA01, CA03 e CA06–CA10 nessas superfícies. Condições: CT-012, CT-014, CT-016 nas jornadas de acesso; CT-017–CT-018, revisão r002 do documento do pai #1016399.

Origem: project-slices:1016399:r002:D02.
