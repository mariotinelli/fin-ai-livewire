---
name: code-review
description: Review a GitLab merge request, GitHub pull request, or the current branch for technical quality and alignment with Redmine tasks. Use for code review, including before pushing a branch; present proposed comments for approval before publishing.
---

# Code review

At entry, read [user communication](references/user-communication.md) unless already read in this conversation. Apply it to progress, blockers and delivery, preserving this workflow's complete decision and approval requirements.

Respond in Brazilian Portuguese from the first announcement, including questions, progress, findings, reports, approval previews and published comments. Translate prose from these instructions when explaining it; preserve technical identifiers, commands and paths. The report template is deliberately in Portuguese because it is user-facing output.

Deliver separate conclusions for technical quality and task alignment. This workflow reviews and recommends: it does not implement fixes, create commits, formally approve, request changes through platform state, merge, or modify Redmine.

## 1. Select the target

Reuse an explicitly supplied target. Otherwise ask where to review, prioritizing MR/PR and offering the current branch. Inspect remotes and Git context to propose candidates without choosing between ambiguous repositories, hosts or requests. Read applicable project instructions.

Read only the selected mode: [GitLab](references/gitlab.md), [GitHub](references/github.md), or [local branch](references/local-branch.md). Prefer available connectors; authenticated `glab` and `gh` are alternatives for their respective providers. Discover capabilities and command help before relying on specific operations. Do not install tools or configure accounts automatically. Never ask for tokens in the conversation or copy them into files, process arguments or output.

**Complete when:** one unambiguous target has a mode, host/repository and identifier, or missing access has been explained without silently switching targets.

## 2. Fix the comparison

Follow the selected reference to record base, head and reviewed content. For MR/PR, review the published version; local working changes are not evidence for that version. For a branch, confirm the base and ask whether uncommitted changes should be included when present.

Check pagination, file inventory, omitted diffs and truncated content. Retrieve missing content through available capabilities or declare incomplete coverage. Read surrounding affected paths beyond the diff when needed. Assess generated files and binaries through their source and impact; listing them does not establish review coverage.

**Complete when:** comparison, files and gaps are identified, and no conclusion attributes evidence to the wrong version.

## 3. Reconstruct the request and check scope

Read [Redmine and traceability](references/redmine.md). Detect task references and confirm IDs and server with the user; an explicit selection already supplied counts as confirmation. Read only necessary context through MCP. Preserve each requirement's origin when reviewing multiple tasks.

Compare requirement → implementation → test/evidence and change → requirement/justification. If Redmine is unavailable, absent or ambiguous, continue technical review and leave the affected scope assessment pending. Local evidence may help but must not silently replace the remote consultation.

**Complete when:** every identifiable requirement and relevant change has a classification and evidence, or an explicit pending question without invented acceptance criteria.

## 4. Review implementation and verify behavior

Apply [the reusable review criteria](references/review-criteria.md), independently of the provider. Inspect affected files and execution paths, prioritizing risk; separate demonstrated defects, questions and optional suggestions.

Inspect actual verifier configuration. Check CI for the reviewed version and run checks and tests proportional to impact, expanding for risk or project requirements. Use check modes without automatic fixes. To test another revision, use an isolated temporary copy; preserve the user's branch and files. Tests requiring external services or real data need a suitable environment without production changes. When safe execution is unavailable, record the obstacle. Missing infrastructure does not demonstrate a functional defect.

Record commands, examined version, results, failures and unexecuted steps. A green pipeline does not replace analysis; results for another commit do not validate this review.

**Complete when:** relevant files were examined or declared uncovered, and each conclusion distinguishes code inspection, observed execution and limitations.

## 5. Deliver and publish

Read [delivery, approval and resume](references/delivery.md). Fill [the report template](templates/review.md), save the Markdown and present a conversational summary. Include findings, requirement mapping, limitations and both conclusions. Do not manufacture findings when no problems are demonstrated.

For MR/PR, present the complete comment preview, destination and version before requesting one approval to publish. Approval authorizes only the content and operations shown. Follow the provider reference for the summary and inline comments. For a local branch, deliver the report without publishing or creating an MR/PR.

**Complete when:** report and summary were delivered; authorized comments have confirmed links, or refusal, pending work or partial failure has been explained. Do not announce publication of uncertain operations.

For controlled behavioral evaluation, read [the evaluation scenarios](references/evaluation-scenarios.md); they do not replace installation tests or prove execution against real services.
