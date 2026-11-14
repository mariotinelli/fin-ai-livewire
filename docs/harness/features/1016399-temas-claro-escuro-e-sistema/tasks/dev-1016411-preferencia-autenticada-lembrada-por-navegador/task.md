# [DEV] [WEB] [USUÁRIO] Escolher tema claro, escuro ou sistema - Preferência autenticada lembrada por navegador

## Identidade e fontes

- Filha: [#1016411](https://redmine.remsoft.com.br/issues/1016411); papel DEV.
- Pai: [#1016399](https://redmine.remsoft.com.br/issues/1016399); requisito canônico: docs/harness/features/1016399-temas-claro-escuro-e-sistema/feature.md.
- Slicing aprovado: [slices.md](../../slices/slices.md), revisão r002.
- Sequencing: 48. Estimativa: 2.5h, conforme revisão aprovada; pareceres e fundamento em slices.md.
- Condições: [Markdown r002](../../slices/condicoes-teste-r002.md); [DOCX confirmado na QA #1016412](https://redmine.remsoft.com.br/attachments/download/3381/1016399%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx); [DOCX confirmado na QA #1016413](https://redmine.remsoft.com.br/attachments/download/3382/1016399%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx).
- Situação: publicação e relações conferidas; implementação e execução QA não realizadas.

## Entrega

Lembrar a escolha Claro, Escuro ou Sistema da área de trabalho no navegador e restaurá-la ao retornar, sem aplicar essa escolha às telas de acesso e sem vinculá-la ao perfil.

## Escopo e limites

A persistência não sincroniza contas ou dispositivos. As escolhas e o acompanhamento do sistema têm fornecedores próprios; esta entrega integra suas três opções sem recriar os seletores.

## Critérios de aceite

- Escolher cada opção na área de trabalho, navegar, recarregar e fechar/reabrir com dados do site preservados mantém a escolha ao voltar à área de trabalho; em Sistema, usar a preferência atual do dispositivo.
- Sair da conta não apaga a preferência guardada. A tela de acesso segue o dispositivo; entrar novamente, inclusive com outra conta no mesmo navegador, restaura a escolha autenticada.
- Com escolha autenticada oposta ao dispositivo, abrir diretamente tela de acesso em nova navegação/reabertura usa o dispositivo sem apagar a opção; retornar à área de trabalho restaura a escolha.
- Outro contexto sem dados inicia a área de trabalho em Sistema; limpar os dados também restaura esse padrão. Não sincronizar por conta ou dispositivos.
- Se não puder lembrar a opção, aplicar à página autenticada atual e manter a aplicação utilizável; no próximo acesso, pode voltar ao padrão. A aparência de acesso não exige gravar opção.
- Aplicar/restaurar tema preserva somente o estado que a página já conserva, sem nova persistência de campos/filtros entre recargas ou retornos.

## Dependências

Bloqueio de início pela primeira seleção/base visual de “Escolher tema claro, escuro ou sistema - Escolha clara e escura no menu da conta”. Pode começar sem aguardar Sistema e aparência de acesso; para concluir, integrar as três opções de “Sistema como padrão e acompanhamento” e as transições para “Aparência automática nas telas de acesso”. São integrações de conclusão, sem bloqueios nativos entre essas tarefas.

## Referências

[Feature #1016399](https://redmine.remsoft.com.br/issues/1016399), revisão funcional r002 proposta. [Identidade visual #1016270](https://redmine.remsoft.com.br/issues/1016270), aplicada às telas e estados existentes. Sem mockup de seletor ou paleta escura exata; seguir R4–R5 e a decisão de retirar o seletor das telas de acesso.

Cobertura: R2; R1 na restauração; R6 na continuidade; CA04, CA05, CA09. Condições: CT-008–CT-011, CT-019, revisão r002 do documento do pai #1016399.

Origem: project-slices:1016399:r002:D04.
