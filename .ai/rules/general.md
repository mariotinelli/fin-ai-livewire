---
paths:
  - '**'
  - README.md
---

# General

## Write pt-BR with correct diacritics
Keep correct accents and cedilla in every Portuguese (pt-BR) text written to project files.

## Optimize images before storing them
Whenever an image is stored in the system, process it with Intervention Image and call `->optimize()` before persisting it. The exact API and processing chain may vary; `$request->image('avatar')->optimize()->store(...)` is only an illustrative example, not a required implementation.

## Keep Boost installer selections synchronized
After any Composer dependency or Laravel Boost change, synchronize the comma-separated third-party package list below boost:install with every package currently discovered by the Boost installer, adding new entries and removing unavailable ones. Keep the agent identifier list synchronized with the selected supported agents, use the Boost key codex, and write both lists without spaces after commas.

## Choose the Boost integration from the project runtime
In Boost installation instructions, select Laravel Sail only when the project actually uses Sail; otherwise select None. Laravel Cloud must never be selected for this project family.
