# Contexto Redmine por operação

Descubra ferramentas e schemas pelo host; use MCP exclusivamente. Conexão, autenticação e disponibilidade da operação são verificações distintas. Consulte somente capacidades necessárias agora, seguindo paginação e buscas adicionais quando a descoberta for parcial; uma primeira página não demonstra ausência de ferramenta.

| Operação | Leituras/capacidades necessárias |
| --- | --- |
| Entrevistar ou preparar rascunho | Nenhuma conexão remota necessária |
| Resolver destino | Contexto, projeto e versões; listar projetos somente se destino ambíguo |
| Conferir similaridade | Busca paginada na versão/projeto e leitura completa dos candidatos |
| Criar pai/filha | Trackers, status, categorias/campos, criação e leitura final |
| Atualizar issue | Leitura atual e atualização dos campos específicos |
| Relações | Leitura dos endpoints/grafo, criação/remoção e conferência |
| Documento QA | Upload/associação e leitura dos anexos |

Imediatamente antes de mutação, confirme servidor, usuário autenticado, projeto, versão e identidade/endpoints contra a prévia aprovada. Reuse escolhas explícitas da conversa. Não teste permissão fazendo mutação.

Em fluxo novo, liste todas as versões abertas do projeto com ID/nome e metadados disponíveis e peça seleção do usuário. Se a seleção já foi feita explicitamente na conversa, confira-a e reutilize. Sem versão aberta, criação/publicação fica impedida; não criar uma nem escolher fechada/trancada. Ao retomar, verifique vínculo e status da versão; mudança material exige nova escolha.

Diagnóstico específico:
- MCP ausente/desconectado: conferir conexão; remsoft install:mcp quando falta configuração.
- Sessão ausente/expirada/rejeitada: remsoft redmine login, sem pedir/exibir credenciais.
- Ferramenta requerida não localizada: completar descoberta, identificar capacidade e atualizar/reconectar MCP quando aplicável; contagem de ferramentas não prova versão.
- Rede/permissão/servidor: informar o erro sanitizado da leitura, sem prescrever login sem evidência.

Continue trabalho local independente. Não registrar tentativa de escrita quando nenhuma chamada ocorreu. Ao recuperar acesso, concilie IDs/resultado incerto antes de repetir.

**Concluído quando:** operação atual tem contexto/capacidades verificados, ou seu impedimento específico está declarado com trabalho preservado.
