const initializedDocuments = new WeakSet();

export function updatePageTitle(documentObject = document) {
    const applicationTitle = documentObject.documentElement?.dataset?.applicationTitle;

    if (!applicationTitle) return;

    const pageTitle = documentObject.querySelector('[data-page-title]')?.dataset.pageTitle?.trim();
    const title = pageTitle ? `${pageTitle} | ${applicationTitle}` : applicationTitle;

    if (documentObject.title !== title) documentObject.title = title;
}

export function initializePageTitle(documentObject = document) {
    if (initializedDocuments.has(documentObject)) return;
    initializedDocuments.add(documentObject);

    const update = () => updatePageTitle(documentObject);

    if (documentObject.readyState === 'loading') {
        documentObject.addEventListener('DOMContentLoaded', update, { once: true });
    } else {
        update();
    }

    documentObject.addEventListener('livewire:navigated', update);
}
