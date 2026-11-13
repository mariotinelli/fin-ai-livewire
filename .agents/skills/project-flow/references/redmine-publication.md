# Prévia, publicação e leitura final

## Resolver identidade e intenção

Leia requisito aprovado, contexto, projeto, versão selecionada, convenção de título, tracker/classificação, categoria e status inicial reais. Busque demandas semelhantes na versão/projeto, seguindo paginação e lendo candidatos completos. Mostre diferenças materiais ao usuário; similaridade sozinha não autoriza adoção nem duplicação.

Forme títulos com os prefixos aplicáveis e o comportamento ou resultado da entrega. O projeto já identifica o produto: omita seu nome quando ele apenas repetir esse contexto. No projeto FinAI, use `[WEB] [USUÁRIO] Adequação visual completa`, em vez de `[WEB] [USUÁRIO] Adequação visual completa do FinAI`. Preserve nomes de produtos quando distinguirem o objeto funcional da entrega, como uma integração com outro sistema. Mantenha projeto e versão explícitos no destino da prévia. Títulos de issues existentes só mudam mediante operação apresentada e autorizada.

ID conhecido sempre é consultado. Antes da entrevista só crie quando o usuário solicitou esse momento: prévia explica objetivo inicial e que o requisito ainda está em coleta. Publicação final necessita revisão do requisito completo.

Novos pais ficam sem Sequencing até project-slices reservar bloco. Se configuração exige número na criação, registrar impedimento, sem max+1 provisório. Não alterar configurações remotas.

**Concluído quando:** destino e identidade estão verificados, inexistência/adoção foi decidida e nenhuma dúvida material é resolvida por conveniência técnica.

## Apresentar uma prévia completa

Mostre destino, versão, título/prefixos, classificação/tracker, categoria ou ausência, status inicial para criação, descrição completa e relações propostas. Inclua criação e posterior atualização de referência para o caminho definitivo na mesma decisão quando conteúdo/destino já estiverem definidos.

Antes do primeiro create, inclua na descrição da prévia uma referência local estável ao rascunho/requisito (caminho e identidade do item, reutilizados entre tentativas). Depois do ID confirmado, preserve essa referência de origem e acrescente o caminho definitivo autorizado. Isso permite conciliar uma criação sem ID retornado, sem ledger ou hash de aprovação. Histórico sem marcador exige evidências existentes suficientes; ambiguidade bloqueia nova criação.

O texto remoto deve permitir entender todo o requisito sem acesso à conversa. Preserve histórias, fluxos/exceções, regras, dados percebidos, limites, dependências e critérios com seus IDs. Não reduzir um critério a link nem repetir o H1/metadata local como substituto do conteúdo funcional.

Preserve delimitadores existentes:
`<!-- project-flow:start -->` e `<!-- project-flow:end -->`.
Atualize somente seção gerenciada e referência canônica autorizadas, preservando bytes/texto humano fora dela. Se marcadores faltarem, forem ambíguos/duplicados ou conteúdo gerenciado foi editado remotamente, mostre antes/remoto/canônico e obtenha decisão; não sobrescrever descrição inteira por inferência.

Atualização comum inclui apenas descrição e versão autorizadas; omita status_id. Aprovação local não autoriza transição remota. Mudança de status solicitada é ação distinta com transição exata autorizada. Relações devem mostrar endpoints, direção e motivo; preservar relações alheias.

**Concluído quando:** usuário revisou conteúdo e operações exatos; autorização conhecida para o mesmo conteúdo é reutilizada sem repetição.

## Executar e conciliar

Use MCP e leituras frescas imediatamente antes da mutação. Na seção Publicação do requisito, mantenha tabela com intenção autorizada, ID/URL, resultado e pendência. Preserve descrição anterior necessária à comparação e conteúdo exato de operações incertas, de forma proporcional, sem estado paralelo/ledger por microevento.

Após criar, registre ID e releia. Timeout exige busca pelo contexto, título e identidade local estável presente na descrição; confira campos/conteúdo. Um candidato compatível confirmado pode ser conciliado; ausência comprovada permite repetir, ambiguidade impede nova criação. ID conhecido ou criação confirmada nunca dispara outra criação. Resultados incertos de atualização/relação também exigem consulta.

Conferir descrição funcional completa, versão, preservação de conteúdo humano/status/campos/relações e cada relação autorizada. Relação existente correta não precisa ser recriada. Não publicar comentários por rodada de entrevista. Atualizar caminho definitivo só após ID confirmado, mantendo fontes/links válidos.

**Concluído quando:** conteúdo e relações autorizados estão relidos, documentos identificam ID/URL e resultados incertos permanecem explicitamente incompletos.
