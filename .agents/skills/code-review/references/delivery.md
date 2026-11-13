# Delivery, approval and resume

## Local report

Use [the template](../templates/review.md), keeping the resulting report in Brazilian Portuguese. Save under `docs/code-reviews/` at the project root unless the user requests another destination. Name by host/provider, repository, target type and identifier, and short head. For uncommitted review, append an identifier for the examined content fingerprint. Convert components to safe filenames without separators or traversal; verify the destination stays inside the directory and does not follow symlinks.

Reuse the same report for updates and publication confirmations of the same reviewed version. When commits or included working content change, create a new version-named report and preserve the previous one; reference the earlier report as context rather than inheriting its publication approval. Preserve other reports and unrelated files; if an existing destination's identity cannot be established, choose an unused name. Do not create manifests, separate approval states, ignore rules or commits. A failed write does not prevent conversational delivery: explain the unsaved file and cause.

Identify findings as `CR-001`, `CR-002`, and so on within the report. Keep IDs stable during its review and publication. Record sanitized evidence only; do not copy unnecessary personal data or secrets, even from diffs or logs. Identify a leak's location and nature without reproducing the value.

## Preview and approval

Present a conversational summary with both conclusions and the report path. For MR/PR, show the complete preview: destination, SHAs, full summary body and text/location of every comment. Ask once whether the user approves publishing that set. They may adjust or select comments; update the corresponding preview. Silence is not approval.

Separate optional suggestions and questions from defects in the preview too. Finding no defects does not require artificial comments; an approved summary may be the sole publication. The full report remains local; the remote summary includes a compact requirement matrix and material limitations.

Approval applies to the content, target and version shown. Reuse explicit authorization already present in this conversation for the same set without asking again. Material changes to content or commits require updating the review and obtaining approval for the new preview. Approving comments does not authorize formal approval, merge blocking or task updates. Refusal ends the workflow with local delivery preserved.

## Confirm and resume

Before writing, check current target and references. If they differ, stop publication and review the impact. Material Redmine changes since analysis also require reconciling scope conclusions and the affected preview.

Record authorized text, version, reference to conversational approval, results and links per operation in the report itself. A local approval marker alone does not prove human approval. When resuming without access to the original approval, present the set again and request approval instead of inferring it from the file.

After each operation, record its confirmed result. On timeout or uncertainty, reread reviews/comments on the target and check author, content, version and position before retrying. Do not duplicate already published findings or resolve prior comments. If reconciliation is inconclusive, leave the operation pending for clarification. Failure does not authorize deleting previously published comments.

When resuming with valid authorization and unchanged content, send only operations proven missing. Record partial publication, pending items and cause; finish without announcing full success. Without write tools or permission, keep the preview ready and explain the obstacle in Portuguese.

**Complete when:** report and conversation reflect what was actually reviewed and published, with confirmed links and explicit pending work.
