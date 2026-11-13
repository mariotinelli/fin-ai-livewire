# Condições de teste e DOCX obrigatório

Aplique a [disciplina de condições](../../vertical-slicing/references/test-conditions.md) ao requisito completo, inclusive Bug e QA-only. Condições são fonte para verificação futura, não resultados já executados.

## Preparar e revisar

Mantenha contexto, ID estável CT-NNN, título, verificação, resultado esperado e IDs dos critérios de origem. Cada critério precisa de cobertura; regressões externas têm justificativa. Preservar IDs quando editar/reordenar; IDs retirados ficam reservados.

Inclua condições na prévia completa de slices.md. Escreva `slices/condicoes-teste-rNNN.md` e preserve revisões anteriores. Uma alteração material exige revisão do conteúdo; nenhum hash concede autorização.

**Concluído quando:** condições cobrem todo o requisito aprovado e responsável revisou conteúdo, origem e destino QA.

## Gerar documento real

Toda nova publicação precisa do DOCX `<ID do pai> - Condições de testes.docx`, inclusive QA-only. Use o ID confirmado da Feature ou Bug pai, nunca o ID da tarefa QA. Por exemplo, para a Feature 1016288, o arquivo entregue e anexado é `1016288 - Condições de testes.docx`.

Guarde cada revisão em sua própria pasta: `slices/rNNN/<ID do pai> - Condições de testes.docx`, como `slices/r001/1016288 - Condições de testes.docx`. Assim, o nome do anexo permanece legível e revisões anteriores não são sobrescritas. Preserve documentos e anexos históricos com seus nomes existentes; o padrão vale para novos documentos, sem renomeação automática dos antigos.

Markdown continua em `slices/condicoes-teste-rNNN.md`, como fonte legível/prévia, e não substitui Word. Use capacidade documental disponível no agente ou ferramenta local sem Python. Descubra a ferramenta e seus requisitos antes de prometer geração; não instale conversor ou escreva novo motor por inferência.

O DOCX contém título “Condições de teste”, pai/ID, revisão, contexto e todas as condições aprovadas com origem. Gere a partir do Markdown aprovado. Abra/verifique o arquivo real: extensão .docx não prova pacote Word válido. Confira ZIP/OpenXML e conteúdo legível com ferramenta capaz; equivalência com as condições aprovadas é necessária. Preserve arquivos anteriores e diferenças úteis; revisão de Word incorpora ajustes à fonte antes de regenerar.

Sem capacidade disponível, entregue o Markdown e registre o impedimento específico; publicação fica incompleta, sem usar arquivo fictício ou dispensar anexo. A ferramenta é detalhe de implementação; capacidade demonstrada e fidelidade são o aceite.

**Concluído quando:** arquivo real é legível, corresponde à revisão aprovada e está disponível para associação.

## Anexar e conferir

A prévia identifica QA e arquivo. Para múltiplas QAs até seis horas, descreva cobertura e destino do documento em cada uma, preservando verificação integrada ao final. Gere/upload/associe pelo MCP conforme schemas disponíveis; releia anexos da QA e confirme nome, identidade retornada e documento correspondente.

QA adotada pode receber apenas o DOCX autorizado, preservando descrição/status/campos/relações/anexos. QA encerrada exige discutir impacto e definir destino autorizado antes de associar. Timeout exige consultar anexos antes de repetir; upload sem associação não conclui publicação.

**Concluído quando:** anexo aprovado aparece na QA prevista, sem remover anexos existentes nem tratar resultado incerto como sucesso.
