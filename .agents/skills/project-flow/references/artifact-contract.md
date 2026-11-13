# Artefatos, identidade e retomada

Documentos Markdown ligam as etapas. JSON legado é evidência opcional, nunca entrada obrigatória para uma skill nova. Não criar estados, locks, fingerprints, hashes de aprovação ou registro por pergunta.

## Caminhos

- Escopo: `docs/harness/scopes/<YYYY-MM-DD>-<slug>/scope.md`.
- Feature: `docs/harness/features/<ID>-<slug>/feature.md`.
- Bug: `docs/harness/bugs/<ID>-<slug>/bug.md`.
- Fontes necessárias: `sources/` do item/escopo; fontes compartilhadas permanecem no escopo, com links relativos.
- Antes de existir ID: rascunho explicitamente local em `docs/harness/.runs/<run-id>/`, preservado na interrupção; após confirmação, mover para destino canônico com links conferidos.
- Slicing e tarefas: `slices/slices.md` e `tasks/<papel>-<id>-<slug>/task.md` sob o pai. Somente DEV recebe planning.md.

Preserve IDs, slug definido na materialização e caminhos existentes. Para nomes novos com colisão, use sufixo claro e confira destino sem sobrescrever. Verifique que caminho resolvido pertence ao projeto e não atravessa symlink/junction; preserve arquivos desconhecidos.

## Conteúdo e marcos

Requisito inclui identidade, fontes, comportamento, limites, critérios e decisões/revisão. Scope.md inclui catálogo, dependências e progresso distinguindo requisito, slicing e implementação. Consolide ao concluir cada marco, não cada resposta.

Na publicação, retenha na seção responsável a intenção autorizada, conteúdo necessário à conciliação, IDs e resultados confirmados/incertos. Registre impedimento material e próximo passo seguro. Temporários em .work são descartáveis somente se nenhuma evidência pendente depender deles.

## Histórico

Leia originais e estados legados quando necessários para entender identidades/aprovações. Preserve bytes e decisões históricas, sem reaprovação fictícia, conversão automática ou recriação remota. Dois arquivos conflitantes para a mesma identidade exigem conciliação; data mais nova não decide.

Retomada confere documentos, Git e remoto quando necessário. Ausência de JSON não reinicia trabalho. Reorganização completa de artefatos existentes depende de solicitação explícita, com mapa de caminhos/referências e preservação de originais. Um responsável conduz cada artefato; não prometer proteção automática contra escrita concorrente.

**Concluído quando:** documento e referências permitem o próximo passo, identidades/história estão preservadas e pendências não são apresentadas como concluídas.
