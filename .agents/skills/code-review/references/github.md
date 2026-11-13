# GitHub: pull request

## Read the target

Resolve the host (including Enterprise), owner/repository and PR number from its URL or confirmed selection. Prefer an available connector; otherwise use `gh` authenticated to the correct host. Consult `pr view`, `pr diff`, `pr checks` and `api` help for necessary capabilities. Numbers without an unambiguous repository require disambiguation. All user-facing questions, findings and published comments remain in Brazilian Portuguese.

Retrieve the description, relevant discussions and reviews, base/head, commits, files and checks. Record SHAs and the common ancestor used for the PR comparison. Account for the source repository in forks. Identify whether CI evidence belongs to the head or merge result; checks for another commit do not validate this version.

Traverse all pages and reconcile the returned inventory with total changed files. Missing patches, binaries and API limits do not mean an empty diff. Retrieve content or Git objects at the exact version to complete review; when unavailable, declare incomplete coverage. The local branch provides evidence only after checking its SHAs and content.

## Publish after approval

Follow [the delivery contract](delivery.md). Publish a review with the `COMMENT` event, summary body, explicit `commit_id` and comments on supported diff lines. Use path, line and diff side from the examined version: `RIGHT` for new content and `LEFT` for deletions. Do not confuse file line numbers with patch positions. Findings without valid positions belong in the approved summary.

Prefer grouped publication when supported. Do not create remote pending reviews before user approval. If the connector cannot publish a review with comments, use authenticated `gh api` when available; if no supported path can publish the approved content, leave publication pending and explain the missing capability. Do not silently reduce delivery to another format.

Sending comments does not authorize `APPROVE`, `REQUEST_CHANGES`, merge, resolving conversations or changing the PR. Prepare structured arguments or payload files without secrets or interpolating remote content into the shell.

Revalidate commits before writing. After success, record the review ID/URL and comment links, verifying the destination. Uncertain results or partial publication require reconciliation before retrying; do not blindly create a second review.

**Complete when:** the approved review and comments are confirmed and linked in the report, or their pending status is explained.

Source: [GitHub Reviews API](https://docs.github.com/en/rest/pulls/reviews). Verify parameters and capabilities of the available path before calling it.
