var GroupEditor = function() {
    this.body = $('#menu-group');
    this.groups = [];
    this.currentLocation = -1;
    this.chooser = $('#group-location');
    this.activePages = $('#group-pages');
    this.groupsTable = $('#groups').hide();
    this.pagesTable = $('#pages-data').hide();
    this.statusSwitcher = $('#group-status');
    this.addListeners();
    this.chooser.trigger('change');

    if (this.statusSwitcher.attr('checked') == true) {
        this.activePages.hide();
    } else {
        this.activePages.show();
        
    }
};
GroupEditor.prototype.addListeners = function() {
    var that = this;
    this.statusSwitcher.click(function() {
        var switcher = $(this),
            checked = switcher.attr('checked');
        if (checked) {
            that.activePages.hide('fast');
            if (that.pagesTable.css('display') == 'block') {
                $('#page-list-inv').trigger('click');
            }
        } else  {
            that.activePages.show('fast');
        }
    });
    this.activePages.find('#page-list-inv').toggle(
        function() {
            var inv = $(this);
            inv.removeClass('open').addClass('close')
            that.pagesTable.slideDown('fast');
            that.getPages();
        },
        function () {
            var inv = $(this);
            inv.removeClass('close').addClass('open')
            that.pagesTable.slideUp('fast');

       }
    )
    this.chooser.change(function() {
        var chooser = $(this);
        var location = chooser.val();
        if (location != -1) {
            that.groupsTable.show();
            if (that.groups[location] == undefined) {
            var caption = that.groupsTable.find('caption').text('Pobieranie informacji...');
            $.getJSON('/kohana/admin/menus/ajax_groups_by_location','location='+location,
                        function(data, status) {
                            that.groups[location] = data;
                            caption.text('Grupy aktywne w tej lokalizacji.');
                            that.populateGroupTableRows(location);
                        });
            } else {
                that.populateGroupTableRows(location);
            }
         } else {
             that.groupsTable.slideUp('fast');
         }
    });
};
GroupEditor.prototype.getPages = function(resultPageId) {
    var action = '/kohana/admin/pages/ajax_get_pages',
        query =  (resultPageId == undefined) ? '' : 'page='+resultPageId,
        id = resultPageId || 1,
        that = this;
            var caption = this.pagesTable.find('caption').text('Pobieranie listy stron...');
            $.getJSON(action, query, function(data, status) {
                var pagination = data['pagination'];
                delete data['pagination'];
                that.populatePageTableRows(data);
                that.createPaginationLinks(pagination);
                caption.text('Wybierz strony, na których ma pojawić się grupa.');
            });
}
GroupEditor.prototype.createPaginationLinks = function(paginationLinks) {
    var links = paginationLinks,
        pagination = $('#page-pagination-links'),
        that = this;

    if (links.total_pages == 1) {
        pagination.hide();
    } else {
        pagination.find('*').remove();
        pagination.append(getPositionButton('first'))
                  .append(getPositionButton('prev'));
        for (var i = 0; i < links.total_pages;) {
                i += 1;
                if (i != links.current_page) {
                    pagination.append(getAnchor(i, '[' + i + ']'));
                } else {
                    pagination.append($('<strong/>').text('[' + i + ']'));
                }
        }
        pagination.append(getPositionButton('next'))
                  .append(getPositionButton('last'));
     }
       function getPositionButton(position) {
            var is_enabled = links[position + '_page'],
                src = '/kohana/media/img/' + position + ((is_enabled) ? '_enabled' : '_disabled') + '_mini.png',
                img = $('<img/>')
                        .attr('src', src)
                        .attr('alt', position);
           if (is_enabled) {
               return getAnchor(is_enabled, img);
           } else {
               return img;
           }
        }

        function getAnchor(id, content) {
           var anchor = $('<a>')
                        .attr('href', '#')
                        .html(content)
                        .click(function(evt) {
                              evt.preventDefault();
                              that.getPages(id);
                         });
              return anchor;
        }

};
GroupEditor.prototype.populatePageTableRows = function(pages) {
        var tbody = this.pagesTable.find('tbody'),
            that = this;
        tbody.find('tr').remove();
        for(var key in pages) {
            if(pages.hasOwnProperty(key)) {
                var tr = $('<tr>'),
                    page = pages[key];
                tr.data('id', page.id);
                tr.append($('<td/>')
                            .text(page.title)
                            .addClass('title')
                          )
                  .attr('id', page.id);
                if (isPageActive(pages[key])) {
                    markRow(tr);
                }
                tbody.append(tr);
            }
        }

        tbody.find('tr').click(function() {
            var tr = $(this),
                id = tr.attr('id');
            if (isPageInActiveList(id)) {
                unmarkRow(tr);
                removePageFromActiveList(id);
            } else {
                markRow(tr);
                addPageToActiveList(id, tr.find('td.title').text());
            }

           function isPageInActiveList(id) {
               return that.activePages.find('input#page'+id).length;
           }

        });

        function removePageFromActiveList(id) {
            that.activePages.find('#page' + id).parent().remove();
        }

        function addPageToActiveList(id, title) {
            that.activePages.find('ul').append(
                                $('<li/>')
                                       .append($('<label/>')
                                               .attr('for','page'+id)
                                               .text(title)
                                           )
                                       .append(
                                            $('<input/>')
                                            .attr({
                                                    'type' : 'checkbox',
                                                    'name' : 'group[pages][' + id +'][id]                                    ',
                                                    'value' : id,
                                                    'checked' : true,
                                                    'id' : 'page'+id
                                            })
                                        )
                                       .append(
                                            $('<input/>')
                                            .attr({
                                                'type' : 'hidden',
                                                'name' : 'group[pages][' + id +'][title]',
                                                'value' : title
                                            })
                                        )
                            )
        }
        function isPageActive(page) {
            return that.activePages.hasElement('#page'+page.id);
        }
        function markRow(tr) {
            tr.css({'background-color' : '#d5d5d5'});
        }
        function unmarkRow(tr) {
            tr.css({'background-color' : '#f1f1f1'});
        }
};
GroupEditor.prototype.populateGroupTableRows = function(location) {
    if (location !== this.currentLocation) {
        var groups = this.groups[location],
            tbody = this.groupsTable.find('tbody');

        tbody.find('tr').remove();
        for(i = 0; i < groups.length; i++) {
            var tr = $('<tr/>');
            tr.append($('<td/>').text(groups[i].name)).
               append($('<td/>').text(groups[i].order)).
               append($('<td/>').text(groups[i].is_global ? 'Tak' : 'Nie'));
            tbody.append(tr);
        }
        this.currentLocation = location;
    }

};
GroupEditor.prototype.clear = function() {
    this.body.find(':input').each(function() {
               var input = $(this);
               var type = input.attr('type').toLowerCase();
               if (type == 'text') {
                        input.val('');
               } else if (type == 'select-one') {
                     input.val(-1);
               }
    });
};
GroupEditor.prototype.show = function(speed) {
    if (speed == undefined) {
        this.body.hide();
    } else this.body.slideDown(speed);
    this.body.find(':disabled').attr('disabled', false);
};
GroupEditor.prototype.hide = function(speed) {
    if (speed == undefined) {
        this.body.hide();
    } else this.body.slideUp(speed);
    this.body.find(':input').attr('disabled', true);
};


