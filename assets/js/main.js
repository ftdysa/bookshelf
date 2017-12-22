'use strict';

require('../sass/main.scss');

import DatePicker from '../vendor/bulma-calendar/datepicker';

import instantsearch from 'instantsearch.js';
import {searchBox, hits} from 'instantsearch.js/es/widgets';

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.bulma-calendar').forEach(function(ele) {
        new DatePicker(ele, {});
    });

    // Get all "navbar-burger" elements
    const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);

    // Check if there are any navbar burgers
    if ($navbarBurgers.length > 0) {

        // Add a click event on each of them
        $navbarBurgers.forEach(function ($el) {
            $el.addEventListener('click', function () {

                // Get the target from the "data-target" attribute
                const target = $el.dataset.target;
                const $target = document.getElementById(target);

                // Toggle the class on both the "navbar-burger" and the "navbar-menu"
                $el.classList.toggle('is-active');
                $target.classList.toggle('is-active');

            });
        });
    }

    const userId = document.getElementById('search-box').dataset.userId;
    const search = instantsearch({
        appId: process.env.ALGOLIA_APP_ID,
        apiKey: process.env.ALGOLIA_API_KEY,
        indexName: 'readlog',
        urlSync: true,
        searchParameters: {
            numericFilters: ["user_id="+userId]
        },
    });

    const allItemsTemplate = '<table class="table is-fullwidth is-striped is-hoverable">' +
        '<thead>' +
        '<tr>' +
            '<th>ID</th>' +
            '<th>Book</th>' +
            '<th>Author(s)</th>' +
            '<th>Comment</th>' +
            '<th>Date Read</th>' +
        '</tr>' +
        '</thead>' +
        '{{#hits}}' +
        '<tr>'+
        '<td>{{objectID}}</td>' +
        '<td>{{{_highlightResult.book.value}}}</td>' +
        '<td><div class="tags">{{#_highlightResult.authors}}<span class="tag">{{{value}}}</span>{{/_highlightResult.authors}}</div></td>' +
        '<td>{{comment}}</td>' +
        '<td>{{date_read}}</td>' +
        '</tr>' +
        '{{/hits}}'
        '<tbody>' +
        '</tbody>' +
        '</table>'

    search.addWidget(
        hits({
            container: '#hits',
            templates: {
                empty: 'No results',
                allItems: allItemsTemplate,
            }
        })
    );

    search.addWidget(
        searchBox({
            container: '#search-box',
            placeholder: 'Search for products',
            magnifier: false,
            reset: false,
        })
    );

    search.start();
});
