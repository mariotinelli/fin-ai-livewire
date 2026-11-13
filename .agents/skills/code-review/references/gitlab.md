# GitLab: merge request

## Read the target

Resolve the host (including self-managed installations), project and MR IID from its URL or confirmed selection. Discover the available connector; otherwise use `glab` already authenticated to that host, inspecting `mr` and `api` help. Do not assume `origin` or the CLI's default host identifies the selected project. All user-facing questions, findings and published comments remain in Brazilian Portuguese.

Retrieve the description, relevant discussions, source/target, commits, complete file/diff inventory and pipelines. Record `base_sha`, `start_sha` and `head_sha` for the diff version; unpopulated fields do not establish a comparison. Match CI results to the reviewed SHA and distinguish source-branch pipelines from merged-result execution.

Traverse all pages. Fields such as `collapsed`, `too_large` and limited responses require retrieving the rest through content/Git at the same version or declaring gaps. Local content from a different revision does not complete the diff. Retrieve context files and dependencies at the identified version, including for fork MRs.

## Publish after approval

Follow [the delivery contract](delivery.md). Publish the summary as an MR comment and each approved finding with a valid position as a diff discussion. Use project, IID, old/new paths, lines and base/start/head references from the examined version. Deletions use the old position; additions use the new one. Do not invent positions for missing requirements or findings outside the diff: include them in the approved summary.

The connector or `glab api` must provide the appropriate notes/discussions operation; content approval does not authorize `approve`, merge, status changes or resolving discussions. Prepare structured payloads or temporary body files, preserving newlines without shell interpolation.

Read the target again before the first write and on resume. Changed commits invalidate the preview for the previous version. Confirm returned IDs/links and reread comments when necessary. Partial failure preserves confirmed publications; uncertain results require reconciliation before resending.

**Complete when:** approved summary and discussions have confirmation and links, or pending operations are identified in the report.

Sources: [Merge requests API](https://docs.gitlab.com/api/merge_requests/) and [Discussions API](https://docs.gitlab.com/api/discussions/). Check the installation's supported contract before publishing; do not assume every connector supports inline comments.
