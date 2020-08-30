import '../scss/global.scss';
require('bootstrap');
const $ = require('jquery');

$(document).ready(function () {
    $('[data-toggle="popover"]').popover();
    $('.carousel').carousel();
});
