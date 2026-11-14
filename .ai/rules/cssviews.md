---
paths:
    - "resources/{css,views}/**"
---

# Cssviews

## Use the canonical Remsoft semantic theme

Keep the `remsoft` DaisyUI theme in `resources/css/themes.css` as the canonical source for application colors. Use semantic base/content/state utilities in views instead of fixed palette colors; preserve explicit white/black print colors in PDF output. Do not add automatic or required dark mode without a product decision.

## Prefer Tailwind utilities for layout and component styling
Style Blade layouts and components with Tailwind utilities, including responsive and state variants and arbitrary values for calc() and env(). Do not add custom CSS classes or media-query blocks for styles Tailwind can express; keep shared design tokens in the canonical theme and reserve custom CSS for integrations or behavior that utilities cannot reasonably cover.
