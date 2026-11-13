---
paths:
  - routes/search.php
  - 'routes/**'
  - routes/auth.php
---

# Routes

## Expose relationship select search routes
Define relationship-select endpoints in routes/search.php and route them to paginated search controllers and resources.

## Localize application URL paths
Use `/admin/*` for administrator routes, including `/admin/login` and `/admin/users/criar`. For other user types, translate the role segment into Brazilian Portuguese; for example, customer routes use `/cliente/*`. Translate domain-specific URL segments into Brazilian Portuguese, while keeping conventional terms such as `admin` and `login` untranslated.

## Require user-type prefixes in application URLs
Never define `/login` or another user-facing route directly at the URL root. Every route associated with a user type must start with that user's localized area prefix, such as `/admin/login` for administrators or `/cliente/login` for customers. When an existing or proposed route lacks its user-type prefix, determine which user type it serves and correct the URL.

## Keep password recovery routes shared
Only the administrator login uses the `/admin/login` URL. Keep shared authentication flows such as `esqueci-minha-senha` and `nova-senha/{token}` outside the `/admin` prefix so every user type can use them.
