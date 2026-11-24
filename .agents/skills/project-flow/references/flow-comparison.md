# Comparar o fluxo da Feature ou do Bug

## Fixar o ponto de partida

Localize no mapa a jornada afetada. Confira nas fontes quem inicia o fluxo, em que condição, por qual canal e que resultado encontra. Para um Bug, parta da reprodução ou da evidência relatada e descreva o efeito observado. Uma jornada prevista no mapa comprova intenção. Para apresentá-la como atual, confira sua disponibilidade.

Para uma capacidade nova, procure como a pessoa atinge o objetivo hoje, inclusive manualmente. Se a capacidade ainda não existir, explique isso em uma frase. Se faltar evidência, escreva “Ainda precisamos confirmar…” com a dúvida específica. Desenhe apenas os passos conhecidos. Para uma troca editorial, mostre o termo atual e o proposto no passo em que aparecem.

Registre no requisito o capítulo ou a jornada e a origem precisa do recorte (revisão do mapa, versão do documento, reprodução datada ou evidência preservada em `sources/`). Guarde no HTML a descrição e os passos anteriores por extenso. Em uma retomada, abra a comparação existente antes de consultar o mapa mais recente. Se surgir evidência que contradiga a versão anterior, apresente a divergência e preserve a revisão já citada ao corrigir o recorte.

Ao citar o mapa vigente, anote a edição além do capítulo. Se a referência apontar para o nome que será usado na próxima edição, vincule também a cópia preservada ou a revisão imutável ao [atualizar o mapa após a aprovação](map-approval.md).

**Concluído quando** outra pessoa consegue recuperar o fluxo anterior e saber o que sustentou sua descrição.

## Escrever e desenhar a mudança

Copie o [modelo HTML](../templates/functional-map.html) para `flow-comparison.html` junto do requisito. Em uma retomada, edite a fonte do item. Substitua o conteúdo JSON do bloco `map-data` pelos campos abaixo. Use um serializador JSON que escape `<` como `\u003c`.

| Campo | Conteúdo |
| --- | --- |
| `kind` | Valor fixo `comparison`. |
| `title`, `intro` | Nome simples da mudança e contexto para quem abre o requisito pela primeira vez. |
| `revision` | Identificação visível da revisão, por exemplo `Revisão 2`. Use o mesmo valor na prévia, na fonte e junto ao link do PDF. |
| `change` | Qual passo muda, quem o executa e qual diferença a pessoa percebe. |
| `before`, `after` | Dois objetos. Cada um tem `intro` para explicar a situação antes do desenho e `steps` com os passos em ordem. Em `before.source`, guarde a mesma referência de origem registrada no requisito. Esse campo fica na fonte editável. |
| `steps` | Cada passo tem `actor` e `action`. Use `label` para identificar em palavras o passo que sai ou que muda. Quando o caminho anterior for inexistente ou desconhecido, basta a explicação em `before.intro`. |
| `states`, `alternatives`, `failures` | Opcionais em cada versão. Para uma transição, use `states.intro` e `states.transitions` com `from`, `event` e `to`. O diagrama de estados também pode ser usado sozinho. As duas listas de textos descrevem alternativas e falhas afetadas. |
| `example` | Um caso concreto, com dados reconhecíveis e o resultado que atende ao critério de aceite. |

Use o mesmo recorte e os nomes do produto nas duas versões. Explique cada desenho antes de mostrá-lo. Em um Bug, associe o exemplo à condição que revela a falha. Mantenha commits, tarefas de QA e andamento da implementação nas fontes técnicas.

**Concluído quando** a pessoa consegue apontar o passo ou a transição alterada e reconhecer o resultado no produto.

## Gerar e revisar

Execute `remsoft skills:render-map "caminho/do/item/flow-comparison.html"`. Abra o PDF gerado ao lado da fonte. Confira títulos, participantes, rótulos em preto e branco, links internos e paginação. O modelo aproxima os desenhos curtos e reserva páginas consecutivas para os mais extensos. Se uma revisão falhar, preserve o PDF válido e indique que a proposta atual aguarda nova exportação.

Inclua **Como funciona hoje**, **O que muda** e **Como vai funcionar** no requisito e na sua prévia. Apresente os links locais ao HTML e ao PDF junto com os critérios na mesma revisão. Ao ajustar a proposta, preserve `before` com sua origem. Atualize o texto da prévia e gere o PDF novamente. Ao materializar o ID, leve o conjunto para a pasta definitiva do item e confira os links relativos. A comparação faz parte da revisão local. Na descrição destinada ao Redmine, leve o resumo funcional e use apenas referências remotas confirmadas.

**Concluído quando** o requisito, os desenhos e os critérios descrevem a mesma mudança e o PDF conferido está acessível ao responsável pela revisão.
