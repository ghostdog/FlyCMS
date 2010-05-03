var GroupEditor = function() {
    this.body = $('#menu-group');
    this.groups = [];
    this.currentLocation = -1;
    this.paginationLinks = {};
    this.chooser = $('#group-location');
    this.activePages = $('#group-pages');
    this.groupsTable = $('#groups').hide();
    this.paginationIcons = $('#pagination-icons').hide();
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
        } else  {
            that.activePages.show('fast');
        }
    });
    this.activePages.find('#page-list-inv').toggle(
        function() {
            var inv = $(this);
            inv.removeClass('open').addClass('close');
            that.pagesTable.slideDown('fast');
            that.getPages();
        },
        function () {
            var inv = $(this);
            inv.removeClass('close').addClass('open');
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
                that.paginationLinks = data['pagination'];
                delete data['pagination'];
                that.populatePageTableRows(data);
                that.createPaginationLinks();
                caption.text('Wybierz strony, na których ma pojawić się grupa.');
            });
}
GroupEditor.prototype.createPaginationLinks = function() {
    var links = this.paginationLinks,
        pagination = $('#pagination-links'),
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
                        .attr('rel', id)
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
                var tr = $('<tr>');
                tr.append($('<td/>')
                            .text(pages[key].title)
                            .data('id', pages[key].id)
                            .click(function() {
                                console.log($(this).data('id'), 'click id');
                            })
                          );
                
                tbody.append(tr);
            }
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


