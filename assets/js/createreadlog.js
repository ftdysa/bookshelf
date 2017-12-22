'use strict';

document.addEventListener('DOMContentLoaded', function () {
    const ele = $('#create_read_log_author_name');
    const authorIds = "" + ele.data('authorIds');

    ele.selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        persist: true,
        create: true,
        closeAfterSelect: true,
        openOnFocus: false,
        valueField: 'id',
        labelField: 'name',
        searchField: ['name'],
        onInitialize: function(query, callback) {
            const s = this;
            const authors = authorIds.split(",");


            // Just select all the authors for now. I'll turn this into a search
            // once it starts getting slow.
            // TODO: Move to load + search controller.
            $.ajax({
                url: '/authors.json?',
                type: 'GET',
                error: function() {
                    callback();
                },
                success: function(res) {
                    s.addOption(res);
                    s.addItems(authors);
                }
            });
        }
    });
});
