---
paths:
  - '.ai/skills/**'
---

# Skills

## Maintain project skills in their canonical source
Edit project-owned skills and references under .ai/skills/<name>, not generated destinations such as .agents/skills. Regenerate with boost:update --no-discover --no-interaction using the existing local boost.json selections; use boost:install when changing agents, integrations or MCP configuration. Boost may symlink or copy custom skills, so verify source/destination content and preserve installed skills before regeneration. Keep package skills owned by their packages rather than copying them all into .ai/skills; do not alter or exclude project guidelines implicitly.
