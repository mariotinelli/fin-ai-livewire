---
name: plan-issue
description: Planeje uma filha DEV em planning.md para Dev, Validação, Testes e Commit do Ralph, sem implementar. Use a partir de task.md e do requisito pai.
---

# Plan issue

Leia [comunicação](references/user-communication.md) uma vez por conversa. Responda em pt-BR, preservando identificadores técnicos.

## 1. Localizar e inspecionar

Receba o ID DEV e localize exatamente um `tasks/dev-<id>-<slug>/task.md` em `docs/harness/features` ou `docs/harness/bugs`. Leia o requisito pai e as instruções, contexto e ADRs do projeto. QA e Study não recebem planning.md. Este planejamento não acessa nem altera Redmine.

Aplique [inspeção técnica](references/technical-inspection.md). Confira dependências reais: número de Sequencing e publicação do fornecedor não demonstram capacidade implementada. Conflitos de requisito, tarefa ou design voltam ao responsável; preserve o trabalho não afetado.

**Concluído quando:** tarefa/pai estão identificados, fatos técnicos têm evidência e nenhuma decisão de produto foi inventada.

## 2. Observar verificadores

Inspecione comandos/configuração e pré-requisitos do projeto. Execute os verificadores completos uma vez em modo de checagem, preservando arquivos alheios. Registre comando, shell, runtime, resultado e impedimentos reais. Esse baseline é contexto do planejamento, sem gate adicional ou autorização para aceitar testes obrigatórios falhando.

**Concluído quando:** resultados executados, falhas e verificações não executadas estão distinguidos no plano; comando inseguro ou desconhecido permanece pendente.

## 3. Escrever e revisar

Use [contrato do plano](references/planning-contract.md) para produzir somente `planning.md` ao lado de task.md. Cada fase prepara Dev → Validação → Testes → Commit: mudança e limites, critérios para outro agente revisar, comandos obrigatórios e uma entrega coerente para commit. Critérios visuais entram na Validação quando aplicáveis. Host, diagnóstico e investigação são atividades dos gates, sem etapas próprias ou registro por microtransição.

Apresente o arquivo completo ao desenvolvedor e incorpore ajustes. Autorização já dada para o mesmo conteúdo vale; mudança material exige nova revisão. Não implemente nem faça commits neste fluxo.

**Concluído quando:** conteúdo revisado, um único plano canônico e critérios verificáveis por fase; rascunhos bloqueados permanecem identificados como tais.

## 4. Entregar

Indique o caminho real de planning.md para a skill `ralph`. Solicitar a execução do plano revisado autoriza os commits das fases, respeitadas instruções explícitas do projeto; revisão do plano sozinha não inicia execução. Descreva pré-requisitos pendentes sem anunciar prontidão quando falta verificação essencial.

**Concluído quando:** o handoff identifica plano, autorização conhecida e próximo passo, sem comandos de executor próprio.
