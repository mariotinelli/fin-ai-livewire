# Publicar e conferir filhas

O caminho abaixo publica uma decomposição com QA. No ramo de Study isolada, aplique a prévia, conciliação, Sequencing e conferência apenas à investigação autorizada; condições/DOCX/QA pertencem ao retorno ao slicing conforme [Study](studies.md).

## Prévia e autorização

Leia contexto/projeto/versão, pai, todas as filhas e relações pelo MCP. Descubra schemas, trackers, status inicial, campos e ferramentas necessários; não invente IDs. Preserve versão selecionada e convenções do pai. [Sequencing](sequencing.md) define o bloco; [adoção](existing-children.md) trata trabalho existente.

A prévia completa em slices.md contém cada filha com título completo/prefixos, papel, estimativa, descrição autossuficiente, aceite, campos, destino, versão e relações, além de conteúdo humano preservado, DOCX e toda renumeração. QA usa o nome completo do pai e cobre o resultado integrado. Não use título/H1 repetido no corpo como substituto da descrição. Planejamento técnico pertence a plan-issue, não à tarefa funcional.

Antes do primeiro create, atribua a cada intenção de filha nova uma referência local estável (caminho do slices.md e identificador da entrega nessa revisão) e inclua-a no rodapé da descrição apresentada. Preserve essa referência entre tentativas e depois do ID confirmado. Ela identifica uma intenção de criação, não uma máquina de estados ou aprovação por hash. Em histórico sem marcador, concilie pelas evidências existentes; ambiguidade impede retry.

Peça uma decisão do responsável sobre esse conjunto. A decisão autoriza somente as mutações mostradas, sem confirmação equivalente extra. Mudança material requer nova prévia. Aprovação local nunca autoriza mudar status do pai.

**Concluído quando:** conteúdo e operações exatas foram apresentados e autorizados; adoções/diferenças e impactos não estão implícitos.

## Aplicar sem duplicar

Antes de escrever, atualize as leituras relevantes. Use somente MCP. Mantenha na seção Publicação uma tabela pequena com intenção autorizada, ID/URL conhecido, resultado confirmado/pendente/incerto e próximo passo. Retenha conteúdo exato de uma operação incerta para conciliar; não registre cada microevento nem crie JSON operacional.

Crie somente filhas realmente novas, registre o ID imediatamente e releia. ID já conhecido é consultado, nunca recriado. Se timeout ocorrer após criação, procure pelo destino, pai, título completo e identidade local estável referenciada na descrição. Confirme conteúdo/campos; um único candidato compatível pode ser conciliado, ausência demonstrada permite repetir e múltiplos candidatos impedem nova criação. Título parecido sozinho não prova identidade.

Crie relações autorizadas entre IDs confirmados, conferindo direção e evitando duplicatas/ciclos. Não modifique relações tocando filha adotada salvo operação específica autorizada pelo fluxo de revisão; adoção comum é somente leitura. Para refinamento externo, leia [dependências](dependencies.md).

Gere/verifique DOCX, faça upload e associe à QA prevista. Confira anexos já existentes antes de repetir associação; upload sem confirmação de associação não conclui a entrega. Resultado incerto permanece pendente. Não reenvie cegamente após timeout nem apague anexo antigo.

**Concluído quando:** cada operação autorizada tem resultado confirmado ou permanece explicitamente pendente/incerto, sem nova criação para IDs conhecidos.

## Conferência e artefatos

Releia todas as filhas gerenciadas, relações, pai, bloco completo e anexos QA. Compare descrições/campos/estimativas com a prévia e confirme preservação de status, texto humano, filhas externas e relações não afetadas. Divergência material volta à revisão; não declare sucesso com resposta truncada/página faltante.

Somente após conferência integral, escreva task.md por ID abaixo do diretório do pai:
`tasks/dev-<id>-<slug>/task.md`, `tasks/qa-<id>-<slug>/task.md` e `tasks/study-<id>-<slug>/task.md`.
Preserve caminhos existentes. planning.md permanece exclusivo de DEV. Revisão atualiza task.md apenas depois de mudança remota conferida.

**Concluído quando:** descrição, relações, Sequencing e DOCX autorizado estão confirmados no remoto e documentos por ID representam essa publicação.
