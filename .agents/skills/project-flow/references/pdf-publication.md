# Publicar os PDFs da Feature ou do Bug

Para uma entrega já comunicada pelo projeto, siga a [publicação do mapa após a entrega](delivery.md). Os dois anexos abaixo acompanham a aprovação do requisito.

## Incluir os dois documentos na prévia

O mapa permanece local durante o catálogo, a entrevista e a revisão. Na publicação autorizada do requisito completo, cada Feature ou Bug recebe **dois anexos na própria tarefa**. Isso vale também para itens do mesmo escopo que usam a mesma edição do mapa. Em tarefa criada antes da entrevista, aguarde a publicação do requisito completo.

Abra a comparação do item e a edição integral que acompanha a revisão aprovada. Confira a revisão da comparação, a edição impressa no mapa e os capítulos atingidos. A edição usada para explicar o fluxo anterior pode ser mais antiga. Se o mapa vigente já avançou, recupere a edição que acompanha o requisito. Preserve os PDFs conferidos enquanto o item ganha ID ou muda de pasta.

Na [prévia de publicação](redmine-publication.md), mostre o destino, as duas revisões, os nomes dos anexos e o texto que precede cada link. Para tarefa nova, explique que o ID confirmado completará os nomes. Registre localmente o SHA-256 de cada arquivo para conferir os bytes no envio. A aprovação do conjunto abrange criação ou atualização, anexos e preenchimento dos links confirmados. Com o Redmine indisponível, conserve os arquivos e a pendência no requisito.

Se um PDF antigo omitir a revisão na página, identifique-o pelo exemplar preservado e pelo conteúdo conferido, e informe a revisão no link. Para novas revisões, imprima a identificação antes de apresentar a prévia.

**Concluído quando** os dois PDFs da revisão estão identificados e a prévia autorizada mostra onde e como o leitor os encontrará.

## Associar os anexos à tarefa certa

Confirme pelo MCP o ID e o projeto da tarefa. Se o destino divergir da prévia, suspenda o envio e identifique a divergência. Em uma criação, use o requisito e a identidade de origem autorizados e concilie o ID antes de prosseguir. Acrescente os links quando os anexos existirem. Em uma atualização, preserve a descrição publicada durante o envio.

Para cada documento, aplique a [regra de anexos](published-evidence.md):

1. Releia a própria tarefa com `redmine_get_issue` e `include: ["attachments"]`. Reutilize um anexo se o ID, o destino e o registro da revisão e do conteúdo corresponderem ao arquivo conferido. Um mapa idêntico em outra tarefa requer upload e associação próprios.
2. Para um arquivo pendente, chame `redmine_upload_file` com o caminho absoluto e `expected_sha256`. Use o token retornado somente para `redmine_attach_file`. No destino, prefira nomes como `123-fluxo-r002.pdf` e `123-mapa-r003.pdf`. Se um homônimo tiver outro conteúdo, escolha um sufixo livre. Preserve os nomes locais e os anexos antigos.
3. Informe na descrição **do anexo** o documento, a revisão ou edição e o SHA-256 enviado. Isso permite reconhecer a operação quando o upload devolve somente o token. Releia a lista de anexos do ID correto. Concilie o ID de upload quando fornecido, ou um único candidato novo em relação à leitura anterior com os dados da operação. Em caso de ambiguidade, registre os candidatos para conciliação. Guarde no requisito o ID do anexo confirmado e seu `content_url`.

Na perda de resposta, releia o destino antes de repetir qualquer escrita. Se a associação aconteceu, use o anexo encontrado. Se só o upload ocorreu, prossiga com o token ainda disponível. Se faltar o token, só refaça o envio depois de estabelecer que falta a associação. Conserve um resultado incerto como pendência quando a leitura não resolver a dúvida. Tokens de upload e credenciais ficam fora dos documentos.

**Concluído quando** os dois anexos da revisão têm ID e URL confirmados na mesma Feature ou Bug, ou a etapa específica que falta está registrada.

## Publicar os links e conferir a leitura

Com os dois anexos confirmados, releia a descrição e aplique os delimitadores e a proteção do conteúdo humano da publicação normal. Dentro da seção gerenciada, mantenha o requisito completo e escreva duas frases junto ao resumo funcional. Por exemplo:

> Quem ainda não recebeu o e-mail poderá pedir outro na tela de confirmação.
>
> **Ver o fluxo desta mudança · revisão 2**
>
> Os capítulos Cadastro e login e Notificações mostram onde esse envio entra no produto.
>
> **Abrir o mapa do projeto · edição r003**

Transforme cada título em link de documento no formatador efetivo do Redmine. Use o `content_url` exato do anexo correspondente. Um endereço com nome acentuado ou escapado deve continuar abrindo o mesmo ID. Substitua o par em uma única atualização da descrição. Se apenas a comparação foi revisada, reutilize o mapa já confirmado na própria tarefa. Uma nova edição geral, por si só, mantém os links históricos nas demais tarefas.

Se o envio parar depois do primeiro anexo, retome pelo segundo. Se já houver dois anexos e a descrição antiga continuar publicada, retome pela edição da descrição. Quando a resposta dessa edição for incerta, releia o texto antes de escrever. Conteúdo autorizado já presente e conferido encerra a operação sem outra atualização.

Releia descrição e anexos pelo MCP. Confira que as duas explicações precedem os links e que o restante da descrição, campos, status e relações foi preservado. Pela interface disponível, abra cada link na tarefa e confira a revisão e a jornada no PDF correspondente. No registro local de publicação, distinga **associação confirmada**, **link conferido na descrição** e **PDF aberto**. Com acesso visual indisponível, registre essa conferência como pendente e preserve os resultados já confirmados.

**Concluído quando** quem abre a tarefa encontra e consegue abrir o par correto, ou o requisito explicita exatamente o que ainda precisa de conferência.
