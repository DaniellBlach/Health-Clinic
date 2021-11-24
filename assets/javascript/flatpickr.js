import flatpickr from 'flatpickr';
import {Polish} from "flatpickr/dist/l10n/pl";

const birthPicker = document.querySelectorAll(".birthPicker");

flatpickr(birthPicker, {
    locale: Polish,
    enableTime: false,
});