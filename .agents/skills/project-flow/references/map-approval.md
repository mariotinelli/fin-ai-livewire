# Atualizar o mapa ao aprovar um requisito

## Preparar a prévia

Abra a edição vigente, o requisito e sua comparação. Parta do mesmo passo, público e resultado descritos em `before`. Siga os efeitos até as outras jornadas envolvidas. Por exemplo, reenviar uma confirmação pode alterar tanto a tela de cadastro quanto a mensagem recebida. Registre no requisito os IDs dos capítulos atingidos. Em escopo, use a aprovação de cada item. A aprovação do catálogo, a abertura da tarefa e a estimativa pertencem a outros marcos.

Prepare uma cópia candidata do mapa na mesma pasta da fonte, com nome distinto e links relativos válidos. Durante a coleta e a revisão, mostre os capítulos que mudariam junto com a comparação do item. Ao receber aprovação daquele conteúdo, incorpore apenas a revisão aceita e seus efeitos na edição integral. A mesma aprovação vale para a atualização local, inclusive com o Redmine indisponível.

**Concluído quando** a prévia identifica os passos atingidos e é possível distinguir cada requisito aprovado dos rascunhos.

## Compor os capítulos

Releia a fonte da equipe antes de editar. Mantenha os capítulos em uso, seus IDs e notas. Acrescente o efeito de cada proposta junto à jornada correspondente, com explicação antes do desenho e exemplo do resultado. Atualize as ligações entre capítulos. Para uma capacidade nova, use **Previsto** e explique a alternativa manual ou a situação anterior conhecida. Se o texto de uma jornada prevista já descreve exatamente a proposta, apresente o desenho uma só vez.

No [modelo HTML](../templates/functional-map.html), use estes campos dentro de `map-data`:

| Campo | Como preencher |
| --- | --- |
| `edition` | Identificação legível da edição integral, por exemplo `r003`. Reaproveite a convenção do projeto. |
| `requirements` | Objeto indexado por chave da revisão, como `renew-r2`. Cada entrada tem `item` (identidade estável do requisito desde o rascunho), `title`, `revision`, `path` relativo ao HTML e, quando confirmada, `url` HTTP(S) da tarefa. Para uma revisão histórica, aponte para a cópia que a identifica. |
| `journey.proposals` | Lista de efeitos aprovados nesta jornada. Cada efeito tem `origin` (chave de revisão), `intro`, `steps` ou `states`, e `example`. Use os mesmos formatos de raias, transições, alternativas e falhas do mapa original. Uma única versão consolidada por item e jornada. |
| `journey.related` | IDs de outros capítulos aos quais a pessoa pode seguir. Use os IDs existentes, inclusive quando o título mudar. |
| `journey.conflicts` | Lista de avisos com `reason` (qual passo está em disputa e por quê) e `origins` (chaves das revisões envolvidas). |

As chaves de revisão e os IDs de capítulos começam por letra minúscula e usam letras minúsculas, dígitos e hífens. Trate os caminhos como relativos à fonte, resolva-os dentro do projeto e confira o destino real, inclusive após mover um requisito para sua pasta definitiva. Mantenha a identidade do item ao acrescentar a URL remota. O HTML permite abrir o requisito local. O PDF navega internamente à origem e oferece o link remoto quando disponível.

Mapas antigos continuam abrindo com os campos originais. Na primeira atualização de uma cópia antiga do modelo, compare o renderizador instalado com o da equipe. Incorpore na candidata o suporte aos campos novos, preservando dados, marcação, estilos e notas personalizados. Confira que as propostas aparecem no PDF. Para formatos próprios, edite a fonte canônica com sua ferramenta e confira a mesma apresentação. Se faltar a fonte ou houver ambiguidade sobre uma personalização, preserve o original e registre o trecho que precisa de decisão.

**Concluído quando** cada efeito aprovado tem origem, revisão e destino navegáveis e as demais jornadas continuam legíveis no guia.

## Conciliar revisões

- **Mesmo item.** Localize a proposta pela identidade do item e pelo capítulo, mesmo após mudança de caminho ou atribuição de ID remoto. Reaplicar a mesma revisão sem diferença encerra a operação na edição existente. Uma nova revisão substitui apenas o efeito anterior daquele item. Retire os vínculos que perderam o efeito e preserve os citados por outras propostas ou avisos.
- **Propostas compatíveis.** Mostre cada efeito com sua origem. Compare atores, condições, ações e resultados do mesmo passo. Se uma proposta depender de outra, explicite a condição na introdução.
- **Incompatibilidade.** Mantenha o fluxo em uso e a última proposta consolidada no trecho. Acrescente o aviso **A decidir** com o ponto de divergência e os requisitos envolvidos. Prossiga nos trechos independentes. Ao receber a decisão, aplique a revisão aceita e retire o aviso resolvido.
- **A base avançou.** Confronte o recorte fixado em cada comparação com a edição vigente. Se uma entrega já estiver comprovada e representada em uso, retire apenas sua proposta já atendida. Revise as demais à luz da nova base. Preserve a comparação histórica e peça decisão se o novo comportamento mudar o sentido de uma proposta. A aprovação isolada de um requisito nunca comprova sua entrega.
- **Texto ou tarefa técnica.** Registre “sem mudança no fluxo” no requisito. Uma revisão de redação pode corrigir a edição. Uma tarefa puramente técnica mantém a edição existente.

**Concluído quando** as propostas independentes estão identificadas, os conflitos estão visíveis e cada comparação conserva a origem que motivou a tarefa.

## Conferir, aplicar e retomar

Use `remsoft skills:render-map "caminho/da/candidata.html"`. Abra o PDF integral e siga o índice, as jornadas relacionadas, os avisos e as origens. Confira a edição impressa, os rótulos **Em uso** e **Mudança proposta**, as exceções e ao menos um capítulo preservado. Compare os dados e o conteúdo humano com a fonte original. Invalidação, falha de impressão ou edição concorrente mantém o par vigente até a conciliação.

Antes de substituir qualquer arquivo, tenha o par anterior e o par candidato completos. Para cada edição citada por um requisito, confirme uma revisão imutável que recupere **os dois arquivos** ou preserve cópias com a edição no nome junto da fonte, mantendo os links relativos. Confira as referências de origem nos requisitos. Preserve também os destinos locais já citados ao mover o item, ou use referências históricas recuperáveis. Nunca sobrescreva uma edição arquivada diferente.

Releia a edição vigente imediatamente antes da troca. Promova as cópias conferidas para os caminhos habituais do projeto. Em caso de falha entre as duas substituições, restaure o par anterior ou conclua a aplicação a partir do par candidato validado. Na retomada, confronte a edição do HTML e do PDF com a revisão aprovada no requisito antes de compor outra edição. Registre a edição e os capítulos na Feature ou no Bug e, em escopo, no progresso do item, depois de conferir o par definitivo. Mantenha as cópias necessárias a qualquer retomada pendente.

**Concluído quando** o HTML e o PDF canônicos apresentam a mesma edição, a reexecução preserva sua identidade e o leitor consegue abrir a origem e recuperar a edição anterior citada.
