# Filhas existentes, adoção e QA-only

Leia todas as filhas abertas/fechadas, descrições, relações, estimativas e campos completos pelo MCP. Para cada uma apresente ID, título completo com prefixos, papel, status e ação proposta: adotar ou manter externa. Diferenças entre proposta e remoto ficam explícitas; projeto/pai divergente impede adoção.

Adoção comum é somente leitura: preserva ID, status, tracker, conteúdo, estimativa e relações. Relação necessária que não existe envolvendo adotada exige reconciliação específica, não mutação implícita. Externas são preservadas. Nenhuma filha existente prova sozinha que o pai foi implementado ou fatiado.

A única exceção do caminho comum é associar à QA adotada o DOCX mostrado e autorizado na prévia, preservando o restante; QA concluída exige discussão de impacto. Mudanças funcionais em filhas seguem [revisão](change-review.md).

Quando inspeção comprovar todo o comportamento já implementado, proponha QA-only: cobertura de cada critério como existente com evidência, sem DEV artificial. QA verifica o pai inteiro; divide-se coerentemente se ultrapassar seis horas. Preserve nome/prefixos completos do pai no título QA, condições, DOCX e Sequencing.

**Concluído quando:** toda filha tem ação identificada e autorizada, evidência sustenta QA-only, e adoções/externas não receberam mutações não mostradas.
