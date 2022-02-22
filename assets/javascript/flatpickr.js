import flatpickr from 'flatpickr';
import {Polish} from "flatpickr/dist/l10n/pl";

const datePicker = document.querySelectorAll(".datePicker");
const timePicker = document.querySelectorAll(".timePicker")

flatpickr(datePicker, {
    locale: Polish,
    enableTime: false,
});
flatpickr(timePicker, {
    enableTime: true,
    noCalendar: true,
    dateFormat: "H:i",
    time_24hr: true
});