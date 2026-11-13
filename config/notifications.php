<?php

declare(strict_types = 1);

return [
    /*
    | Volume exibido por página (limitado a 1–100 pelo painel).
    | O histórico é preservado; a limpeza ocorre somente pela ação explícita do usuário.
    */
    'per_page' => env('NOTIFICATIONS_PER_PAGE', 20),
];
