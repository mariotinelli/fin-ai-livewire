import notificationCenter from './components/notification-center.js';
import notificationPanel from './components/notification-panel.js';
import checkboxSelect from './components/checkbox-select.js';
import * as Quantity from './components/quantity.js';
import { initializePageTitle } from './components/page-title.js';
import { sidebarGroup, sidebarContext } from './components/sidebar.js';
import sidepage from './components/sidepage.js';
import alertModal from './components/alert-modal.js';
import dropdown from './components/dropdown.js';
import { initializeButtonLoading } from './components/button-loading.js';
import './bootstrap.js';
import collapse from '@alpinejs/collapse';
import mask from '@alpinejs/mask';
import Chart from 'chart.js/auto';
import * as Money from './components/money.js';
import * as Percentage from './components/percentage.js';
import * as Helpers from './components/helpers.js';
import datepicker from './components/datepicker.js';
import selectSearch from './components/select-search.js';
import select from './components/select.js';
import multiSelect from './components/multi-select.js';
import multiSelectSearch from './components/multi-select-search.js';
import fileUpload from './components/file-upload.js';
import multipleUpload from './components/multiple-upload.js';
import autocomplete from './components/autocomplete.js';
import tableTooltips from './components/table-tooltips.js';

window.Money = Money;
window.Percentage = Percentage;
window.Quantity = Quantity;
window.Helpers = Helpers;
window.Chart = Chart;

Alpine.data('datepicker', datepicker);
Alpine.data('notificationCenter', notificationCenter);
Alpine.data('notificationPanel', notificationPanel);
Alpine.data('selectSearch', selectSearch);
Alpine.data('select', select);
Alpine.data('multiSelect', multiSelect);
Alpine.data('multiSelectSearch', multiSelectSearch);
Alpine.data('checkboxSelect', checkboxSelect);
Alpine.data('fileUpload', fileUpload);
Alpine.data('multipleUpload', multipleUpload);
Alpine.data('autocomplete', autocomplete);
Alpine.data('tableTooltips', tableTooltips);
Alpine.data('dropdown', dropdown);
Alpine.data('alertModal', alertModal);
Alpine.data('sidepage', sidepage);
Alpine.data('sidebarGroup', sidebarGroup);
Alpine.data('sidebarContext', sidebarContext);
Alpine.plugin(mask);
Alpine.plugin(collapse);

if (localStorage.getItem('asideOpen') === null) {
    localStorage.setItem('asideOpen', 'true');
}

initializeButtonLoading(document, window);

initializePageTitle(document);
