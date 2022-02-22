import flatpickr from 'flatpickr';
import {Polish} from "flatpickr/dist/l10n/pl";

const datePicker = document.querySelectorAll(".datePicker");

flatpickr(datePicker, {
    locale: Polish,
    enableTime: false,
});