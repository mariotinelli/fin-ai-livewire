import flatpickr from 'flatpickr';
import { Portuguese } from 'flatpickr/dist/l10n/pt.js';

flatpickr.l10ns.pt = Portuguese;

export default (isLive, wireModel, model, config, createDatepicker = flatpickr) => ({
    isLive: isLive,
    wireModel: wireModel,
    model: model,
    config: config,
    pickr: null,

    init() {
        if (this.pickr) return;
        this.pickr = createDatepicker(this.$refs.datepicker, this.config);

        this.pickr.setDate(this.model, false);

        this.$watch('model', (value) => {
            if (!this.pickr) return;
            this.pickr.setDate(value, false);
            this.$wire.set(this.wireModel, value, this.isLive);
        });
    },
    destroy() {
        this.pickr?.destroy();
        this.pickr = null;
    },
    openCalendar() {
        this.pickr.open();
    },
});
