import assert from 'node:assert/strict';
import test from 'node:test';
import upload from '../../../resources/js/components/file-upload.js';
function setup(accept = 'application/pdf') {
    const component = upload('attachments', 10240, accept, 'Anexos', accept);
    const events = [],
        pending = [];
    component.$refs = { input: { value: 'selected' } };
    component.$dispatch = (name, detail) => events.push({ name, detail });
    component.$wire = {
        get: () => null,
        set() {},
        removeUpload() {},
        upload: (...args) => pending.push(args),
        uploadMultiple: (...args) => pending.push(args),
        cancelUpload: () => pending[0][5](),
    };
    return { component, events, pending };
}
for (const [accept, type, valid] of [
    ['application/pdf', 'application/zip', false],
    ['application/pdf', 'application/pdf', true],
    ['image/png', 'image/jpeg', false],
    ['image/png', 'image/png', true],
    [' image/png, APPLICATION/PDF ', 'application/pdf', true],
    ['image/*', 'image/jpeg', true],
    ['image/*', 'application/pdf', false],
    ['image/*', '', false],
    ['image/*', 'image/', false],
    ['', '', false],
    ['*/*', '', true],
]) {
    test(`accept ${accept} validates ${type}: ${valid}`, () => {
        const { component } = setup(accept);
        assert.equal(Boolean(component.validateFileType({ name: 'file', type })), valid);
    });
}
test('uses KB and accepts the inclusive ten MB boundary', () => {
    const { component, events } = setup();
    assert.equal(component.validateFileSize({ name: 'file', size: 10485760 }), true);
    assert.equal(component.validateFileSize({ name: 'file', size: 10485761 }), false);
    assert.match(events.at(-1).detail.message, /10 MB/);
});
test('empty selection does not upload or clear feedback', () => {
    const { component, events, pending } = setup();
    component.addFile([]);
    component.addFile(undefined);
    assert.equal(pending.length, 0);
    assert.equal(events.length, 0);
});
for (const callback of [3, 5]) {
    test(`callback ${callback} frees previews and allows retry`, (t) => {
        const revoked = [];
        t.mock.method(URL, 'createObjectURL', () => 'blob:test');
        t.mock.method(URL, 'revokeObjectURL', (url) => revoked.push(url));
        const { component, events, pending } = setup();
        const file = new File(['pdf'], 'report.pdf', {
            type: 'application/pdf',
        });
        component.addFile([file]);
        pending[0][callback]();
        assert.equal(component.uploading, false);
        assert.match(events.at(-1).detail.message, /Selecione novamente/);
        assert.deepEqual(revoked, ['blob:test']);
        component.addFile([file]);
        assert.equal(pending.length, 2);
        assert.equal(component.$refs.input.value, '');
        component.destroy();
        assert.deepEqual(revoked, ['blob:test', 'blob:test']);
    });
}

test('waits for completion and releases previews on removal without revoking persisted URLs', (t) => {
    const revoked = [];
    t.mock.method(URL, 'createObjectURL', () => 'blob:local');
    t.mock.method(URL, 'revokeObjectURL', (url) => revoked.push(url));
    const { component, pending } = setup();
    const file = new File(['pdf'], 'report.pdf', { type: 'application/pdf' });
    component.init();
    component.addFile([file]);
    component.addFile([file]);
    assert.equal(pending.length, 1);
    pending[0][4]({ detail: { progress: 100 } });
    assert.equal(component.file.progress, 99);
    pending[0][2]();
    assert.equal(component.file.progress, 100);
    component.removeFile();
    assert.equal(component.file, null);
    assert.deepEqual(revoked, ['blob:local']);
    component.$wire.get = () => ({
        name: 'saved.pdf',
        preview: 'https://example.test/saved.pdf',
    });
    component.init();
    component.destroy();
    component.removeFile();
    assert.deepEqual(revoked, ['blob:local']);
});
test('invalid files never start a transfer and reset the input for reselection', () => {
    const { component, pending } = setup();
    component.addFile([new File(['zip'], 'wrong.zip', { type: 'application/zip' })]);
    assert.equal(pending.length, 0);
    assert.equal(component.$refs.input.value, '');
    assert.equal(component.checkFileIsValid([]), false);
});
test('removing an in-flight upload cancels it and releases its URL', (t) => {
    const revoked = [];
    t.mock.method(URL, 'createObjectURL', () => 'blob:local');
    t.mock.method(URL, 'revokeObjectURL', (url) => revoked.push(url));
    const { component } = setup();
    component.addFile([new File(['pdf'], 'report.pdf', { type: 'application/pdf' })]);
    component.removeFile();
    assert.equal(component.file, null);
    assert.equal(component.uploading, false);
    assert.deepEqual(revoked, ['blob:local']);
});

test('hydrates persisted metadata, forwards dropped files and exposes preview helpers', () => {
    const { component } = setup();
    const changes = [];
    component.$refs.input.dispatchEvent = (event) => changes.push(event.type);
    component.$wire.get = () => ({
        id: 4,
        name: 'saved.pdf',
        size: 10,
        type: 'application/pdf',
        preview: 'https://example.test/saved.pdf',
    });
    component.init();
    const dropped = [new File(['pdf'], 'saved.pdf')];
    component.dragging = true;
    component.handleDrop(dropped);
    assert.equal(component.file.persisted, true);
    assert.equal(component.$refs.input.files, dropped);
    assert.deepEqual(changes, ['change']);
    assert.ok(component.getPreviewMimeTypes('image').includes('svg'));
    assert.ok(component.getPreviewMimeTypes('video').includes('mp4'));
    assert.ok(component.getPreviewMimeTypes('document').includes('pdf'));
    assert.deepEqual(component.getPreviewMimeTypes('other'), []);
    assert.equal(component.getPreviewId('file', 'image'), 'file-image-preview');
    component.removeFile();
});
