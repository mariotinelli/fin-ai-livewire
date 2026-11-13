# Sequencing por blocos de versão

Preserve a política de blocos por projeto/versão. Pai espelha o primeiro filho sem consumir posição; DEV segue dependências e QA ocupa o final. Novos pais ficam sem numeração até o slicing completo. QA-only ocupa suas posições QA; Study excepcional recebe posição antecipada e é incorporado sem renumerar silenciosamente.

## Calcular proposta

Resolva o campo Sequencing pelos metadados reais e confirme aplicabilidade a pai/filhas. Ausência, ambiguidade ou campo obrigatório na criação do pai é impedimento de configuração, sem número fictício.

Leia por MCP todas as páginas de issues da versão/projeto, com todos os status e trackers, obtendo campos completos. Valores não vazios inválidos, páginas faltantes ou registros fora de escopo impedem cálculo. Duplicatas históricas permanecem posições ocupadas, sem reparo implícito.

Aloque bloco novo depois do maior inteiro positivo ocupado, sem preencher lacunas. Preserve ordem aprovada do catálogo e dependências. Incompatibilidade volta ao slicing; não intercale blocos silenciosamente. Prévia lista campo, números de cada filha, âncora do pai e qualquer afetado.

**Concluído quando:** leitura é completa e o bloco exato está incluído na prévia autorizada.

## Expandir ou revisar

Preserve posições existentes e canceladas. Inserir DEV antes de QA ainda não iniciada ou adicionar QA exige delta autorizado. Deslocar blocos posteriores só é possível quando cada issue é gerenciada, seu status/journals completos demonstram que nunca iniciou e todos os números afetados constam da prévia.

Issues externas, iniciadas/concluídas e relações alheias ficam protegidas; conflito interrompe a expansão. Ausência de evidência não equivale a não iniciado. Numeração sozinha não libera dependência.

Adoção comum preserva numeração existente. Filhas históricas sem número ou com bloco incompatível não recebem Sequencing automaticamente nem são excluídas silenciosamente do bloco para permitir conclusão. Apresente a incompatibilidade, pertencimento de cada filha, âncora do pai e o delta necessário como revisão/migração específica. Filhas iniciadas/concluídas continuam protegidas; sem solução autorizada compatível, publicação numerada permanece impedida. QA-only não elimina esse conflito de histórico.

**Concluído quando:** todos os deslocamentos têm autorização e evidência, ou o conflito concreto está exposto.

## Aplicar e conferir

Antes de escrever, renove a leitura completa para detectar concorrência/colisão. Use atualizações específicas pelo MCP, preservando campos alheios. Resultado incerto exige nova leitura antes de repetir. Não recalcule número autorizado para contornar concorrência.

Releia o bloco completo após publicar; confirme valores, âncora e ausência de colisões. Materialize números em task.md apenas após confirmação. O agente não oferece lock distribuído nem transação entre escritores externos; em conflito, preserve trabalho e concilie.

**Concluído quando:** todas as atribuições autorizadas estão confirmadas e protegidos permaneceram inalterados.
