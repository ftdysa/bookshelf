'use strict';

require('../sass/main.scss');

import DatePicker from '../vendor/bulma-calendar/datepicker';

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.bulma-calendar').forEach(function(ele) {
        new DatePicker(ele, {});
    });
});
