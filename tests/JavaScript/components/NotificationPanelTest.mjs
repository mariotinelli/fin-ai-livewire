import { test } from 'node:test';
import assert from 'node:assert/strict';
import notificationPanel from '../../../resources/js/components/notification-panel.js';
import { mount } from '../support/component.js';

test('defers fetching until opening and keeps the placeholder until completion', async () => {
    let finish;
    let calls = 0;
    const { component, watchers } = mount(notificationPanel(), {
        $wire: {
            loadNotifications: () => {
                calls++;
                return new Promise((resolve) => {
                    finish = resolve;
                });
            },
        },
    });
    component.init();
    assert.equal(calls, 0);
    watchers.get('$wire.sidepageOpen')(true);
    assert.equal(calls, 1);
    assert.equal(component.loading, true);
    finish();
    await new Promise((resolve) => setImmediate(resolve));
    assert.equal(component.loading, false);
    watchers.get('$wire.sidepageOpen')(false);
    assert.equal(component.loading, true);
});

test('offers retry after failure and ignores responses after closing or destruction', async () => {
    const { component, watchers } = mount(notificationPanel(), {
        $wire: {
            loadNotifications: async () => {
                throw new Error('offline');
            },
        },
    });
    component.init();
    await component.load();
    assert.equal(component.loadError, true);
    assert.equal(component.loading, false);
    component.$wire.loadNotifications = async () => {};
    await component.load();
    assert.equal(component.loadError, false);
    assert.equal(component.loading, false);
    let reject;
    component.$wire.loadNotifications = () =>
        new Promise((resolve, fail) => {
            reject = fail;
        });
    const pending = component.load();
    watchers.get('$wire.sidepageOpen')(false);
    reject(new Error('offline'));
    await pending;
    assert.equal(component.loading, true);
    assert.equal(component.loadError, false);
    const destroyed = component.load();
    component.destroy();
    reject(new Error('offline'));
    await destroyed;
    assert.equal(component.loadError, false);
});
