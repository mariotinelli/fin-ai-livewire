# Registrar uma entrega

**Ligar uma vez.** Na etapa que já confirma a entrega do projeto, acrescente ou reutilize uma chamada não interativa ao agente. Execute-a após o sucesso da entrega, na raiz do projeto com a skill instalada.

Preencha a variável `delivery` com as referências que o processo já conhece, por exemplo “Feature #42, revisão 2, entrega 184, somente reenvio do e-mail”.

```sh
codex exec "Use project-flow para registrar a entrega informada pelo projeto: $delivery"
```

O exemplo funciona em shell e PowerShell. Para OpenCode ou Claude Code, passe o mesmo argumento a `opencode run` ou `claude -p`. Teste com o usuário do job e confira os arquivos gravados e o acesso ao MCP. Em CI temporária, recupere e salve os documentos entre execuções, inclusive quando o Redmine estiver indisponível. Se duas entregas puderem editar o mesmo mapa ao mesmo tempo, use a fila do próprio processo.

**Atualizar o mapa.** Localize no requisito e na edição vigente o trecho entregue. Se a referência for inconclusiva, preserve o mapa e informe o que falta. Incorpore o trecho em **Em uso** para o público indicado e mantenha as demais mudanças propostas. [Gere e confira a edição](map-approval.md). Registre no requisito a entrega, o trecho e onde recuperar o PDF.

**Publicar na tarefa afetada.** Com a autorização definida ao ligar o job, use a [publicação de PDFs pelo MCP](pdf-publication.md) para anexar o mapa desta entrega à própria Feature ou Bug. Acrescente uma frase sobre o que entrou em uso e o link **Mapa após a entrega · edição r005**, usando a edição real. Preserve os dois links da aprovação, as entregas anteriores e o texto da equipe. Confira anexos e descrição e anote o resultado no requisito.

**Na repetição ou retomada**, consulte primeiro o requisito e o mapa. Se a entrega já estiver representada, use a edição registrada e complete apenas o anexo ou o link pendente. Se a gravação foi interrompida, recupere o par HTML/PDF pela conferência de edição existente. Preserve as edições mais recentes ao receber um aviso antigo. Uma reversão ou um cancelamento comunicado pelo projeto altera somente o trecho indicado.

**Concluído quando** o trecho entregue está no mapa e a mesma tarefa abre essa edição e os dois PDFs da aprovação. Informe separadamente uma publicação remota pendente.
