# Arquivos e referências publicados no Redmine

Use esta regra ao publicar ou atualizar descrições com evidências, designs e documentos, incluindo filhas do slicing. O caminho local serve apenas para localizar a fonte e pode permanecer no documento local; não é uma referência acessível no texto remoto. Nunca publique caminhos do computador, `file://` ou referências a arquivos do repositório como destino remoto. A conciliação de novas criações usa uma identidade textual portátil no rodapé, com sua correspondência de caminhos guardada somente localmente. Marcadores históricos são consultados para conciliar, sem migração ou alteração silenciosa.

## Preparar e apresentar

Inspecione o arquivo e confira que corresponde à evidência descrita. Na prévia, mostre identificação/legenda, arquivo a enviar, tarefa de destino e sua apresentação na descrição. Essa operação integra a aprovação do conjunto, sem uma confirmação por arquivo. Se o arquivo não está disponível ao processo MCP, explicite a pendência; não substitua o envio por um caminho local.

Priorize anexar arquivos disponíveis em vez de publicar links para eles. Para referência a outra tarefa, use o ID/URL Redmine confirmado. Uma página externa sem arquivo disponível pode permanecer como URL acessível; não invente um arquivo nem copie conteúdo sem autorização. Links e caminhos úteis na fonte local devem ser adaptados à publicação remota, preservando o significado.

## Enviar e associar

Use exclusivamente o MCP existente: consulte os anexos da tarefa, envie pelo `redmine_upload_file`, associe pelo `redmine_attach_file` e confirme com `redmine_get_issue` incluindo `attachments`. Para tarefa nova, primeiro concilie seu ID; a criação e as etapas seguintes integram a mesma publicação autorizada. Upload aceito não comprova associação.

Use nomes simples, legíveis e únicos no destino, como `<ID>-e01.png`, preservando o arquivo original. O nome remoto é informado ao associar o upload; não renomeie nem regrave a fonte para isso. Se houver colisão, escolha outro nome e registre o vínculo entre ID da evidência e anexo confirmado. Preserve nomes já referenciados e documentos com convenção própria, como o DOCX de condições de teste.

Reutilize um anexo somente quando sua identidade e conteúdo estiverem comprovados pelo histórico da operação ou comparação disponível. Nome ou tamanho iguais isoladamente não comprovam identidade. Após timeout ou resposta incerta, consulte os anexos antes de repetir. Se a identidade continuar ambígua, mantenha a pendência; não reenvie cegamente, remova anexos anteriores ou recrie a tarefa.

## Mostrar na descrição

Após confirmar a associação, atualize somente a seção gerenciada e autorizada, preservando conteúdo humano, campos, status e anexos existentes. Cada imagem deve aparecer na seção pertinente com identificação e legenda, além de continuar disponível como anexo. Outros formatos recebem um link para o anexo remoto confirmado; anexar não significa que PDF, vídeo ou documento será renderizado como imagem.

Confira o formatador efetivo da instância pela interface/ajuda ou conteúdo renderizado já conhecido. Não mude a configuração do Redmine nem presuma o formatador apenas pela extensão do arquivo local. Use o nome remoto exato da imagem associada à própria tarefa ou seu URL confirmado. Exemplos de sintaxe:

- Markdown: `![E01 — Barra em tela menor](https://redmine.example/attachments/download/123/1016397-e01.png)`; o destino entre parênteses também pode ser somente o nome remoto, quando resolver sem ambiguidade na própria tarefa.
- Textile: `!1016397-e01.png(E01 — Barra em tela menor)!`.

Esses nomes são exemplos, não arquivos a publicar. Quando houver anexos de mesmo nome ou outra ambiguidade, use o URL/ID do anexo confirmado em vez de adivinhar qual imagem será resolvida. Para arquivos de outra tarefa, use o endereço remoto correspondente ou anexe ao destino conforme a prévia autorizada; não presuma que um nome de arquivo isolado resolve entre tarefas.

## Conferir e concluir

Releia a descrição e os anexos. Confira destino, nomes/identidades, legendas, links remotos e ausência de caminhos locais ou links ao repositório na nova seção gerenciada. Preserve a identidade textual exigida pela conciliação; não acrescente o caminho do documento ao texto remoto. Alterações necessárias em descrições históricas seguem a revisão autorizada, preservando conteúdo alheio.

Confira a descrição renderizada: a imagem deve aparecer, não apenas o texto da sintaxe. Se não houver meio de visualizar a renderização, registre separadamente associação confirmada e conferência visual pendente; não declare que viu a imagem. Falha de upload, associação, atualização ou visualização mantém a publicação explicitamente parcial, preservando o que já foi confirmado. Não remova um anexo confirmado para tentar refazer toda a publicação.

**Concluído quando:** arquivos autorizados estão associados ao destino correto, imagens são exibidas e demais arquivos têm links remotos acessíveis, sem referências locais como substituto da evidência; qualquer etapa não conferida permanece indicada como pendente.
