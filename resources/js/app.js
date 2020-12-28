/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
const turbolinks = require('turbolinks');

document.addEventListener("livewire:load", function (event) {
    turbolinks.start();
});
document.addEventListener('turbolinks:load', () => {
    window.livewire.rescan()
})


// $(".form-modal").addEventListener("keyup", function (event) {
//     if (event.keyCode === 13) {
//         event.preventDefault();
//         $(this).find(".btn-modal-save").click();
//     }
// });
