# Dependências externas e refinamento

Declare somente bloqueios que impedem iniciar a tarefa; fornecedor necessário apenas para aceite final é contexto de integração. Para cada capacidade, identifique um dono e consulte pai/filhas do fornecedor pelo MCP. Se houver filha específica, use-a; sem filha publicada, pai pode ser bloqueador provisório com motivo explícito. Não duplique implementação do fornecedor.

Leia o grafo relevante completo (incluindo relações externas alcançáveis) para verificar direção, ciclos e preservação. A prévia identifica origem/destino com título completo e ID, relação nova e relação provisória exata a retirar. Falta de leitura completa impede declarar grafo seguro.

No refinamento, crie e confira todas as relações específicas antes de remover somente a relação provisória cuja origem gerenciada é comprovada e cuja remoção foi autorizada. Relações do Project Flow e de terceiros permanecem intactas. Resultado incerto exige nova leitura antes de repetição.

Releia grafo e confirme novas relações, ausência da provisória exata, preservação das demais e ausência de ciclos. Relação configurada não demonstra implementação nem libera início sem conferir capacidade fornecida.

**Concluído quando:** bloqueios reais têm fornecedor específico ou provisório justificado, delta autorizado foi conferido e relações alheias permanecem intactas.
