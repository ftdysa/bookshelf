'use strict';

import instantsearch from "instantsearch.js";
import {hits, searchBox, pagination} from "instantsearch.js/es/widgets/index";

document.addEventListener('DOMContentLoaded', function () {
    const box = document.getElementById('search-box');
    const userId = box.dataset.userId;
    const env = box.dataset.env;
    const index = env + '_readlog';
    const search = instantsearch({
        appId: process.env.ALGOLIA_APP_ID,
        apiKey: process.env.ALGOLIA_API_KEY,
        indexName: index,
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
        '<th>Actions</th>' +
        '</tr>' +
        '</thead>' +
        '{{#hits}}' +
        '<tr>'+
        '<td>{{objectID}}</td>' +
        '<td>{{{_highlightResult.book.value}}}</td>' +
        '<td><div class="tags">{{#_highlightResult.authors}}<span class="tag">{{{value}}}</span>{{/_highlightResult.authors}}</div></td>' +
        '<td>{{comment}}</td>' +
        '<td>{{date_read}}</td>' +
        // TODO: use router to generate these urls
        '<td><a class="button" href="/log/{{objectID}}"><span class="icon is-small"><i class="fa fa-edit"></i></span></td>' +
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

    search.addWidget(
        pagination({
            container: '#pagination',
            maxPages: 20,
            // default is to scroll to 'body', here we disable this behavior
            scrollTo: false,
            showFirstLast: false,
            cssClasses: {
                root: 'pagination-list',
                link: 'pagination-link',
            }
        })
    );

    search.start();
});
