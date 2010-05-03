var GroupEditor = function() {
    this.body = $('#menu-group');
    this.groups = [];
    this.pages = [];
    this.currentLocation = -1;
    this.currentPageList = -1;
    this.paginationLinks = {};
    this.chooser = $('#group-location');
    this.groupsTable = $('#groups').hide();
    this.paginationIcons = $('#pagination-icons').hide();
    this.pageTable = $('#pages-data');
    this.statusSwitcher = $('#group-status');
    this.addListeners();
    this.chooser.trigger('change');

    if (this.statusSwitcher.attr('checked') == true) {
        this.pageTable.hide();
    } else {
        this.pageTable.show();
        this.getPages();
    }
};
GroupEditor.prototype.addListeners = function() {
    this.pageTable.find('tr').click(function() {
        $(this).find(':input').each(function() {
            var input = $(this);
            input.attr('checked', ! input.attr('checked'));
        });
    })
    var that = this;
    this.statusSwitcher.click(function() {
        var switcher = $(this),
            checked = switcher.attr('checked');
        if (checked) {
            that.pageTable.slideUp('fast');
        } else  {
            that.pageTable.slideDown('fast');
        }
    })
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
    var caption = this.pageTable.find('caption').text('Pobieranie listy stron...'),
        action = '/kohana/admin/pages/ajax_get_pages',
        query =  (resultPageId == undefined) ? '' : 'page='+resultPageId,
        id = resultPageId || 1,
        that = this;
        if (this.pages[id] == undefined) {
            $.getJSON(action, query, function(data, status) {
                that.paginationLinks = data['pagination'];
                delete data['pagination'];
                that.pages[id] = data;
                //console.log(data, 'data');
                console.log(that.paginationLinks, 'links');
                that.populatePageTableRows(id);
                that.createPaginationLinks();
                caption.text('Wybierz strony, na których ma pojawić się grupa.');
            });
        } else {
            that.populatePageTableRows(id);
            that.createPaginationLinks();
        }
}
GroupEditor.prototype.createPaginationLinks = function() {
    var links = this.paginationLinks,
        pagination = $('#pagination-links'),
        that = this;

    if (links.total_pages == 1) {
        pagination.hide();
    } else {
        pagination.append(loadPositionButton('first'))
                  .append(loadPositionButton('prev'));
   
        for (var i = 0; i < links.total_pages;) {
                i++;
                if (i != links.current_page) {
                    pagination.append(getAnchor(i, '[' + i + ']'));
                } else {
                    pagination.append($('<strong/>').text('[' + i + ']'));
                }
        }
        pagination.append(loadPositionButton('next'))
                  .append(loadPositionButton('last')).show();
     }
       function loadPositionButton(position) {
            var is_enabled = links[position + '_page'],
                buttonType = position + ((is_enabled) ? '-enabled' : '-disabled'),
                currIcon = $('#'+buttonType);
           console.log(buttonType, 'buttonType');
           console.log(currIcon);
           if (is_enabled) {
               return getAnchor(is_enabled, currIcon);
           } else {
               return currIcon;
           }
        }

        function getAnchor(id, content) {
           var anchor = $('<a></a>')
                     .attr('rel', id)
                     .attr('href', '#')
                     .text(content)
                     .click(function(evt) {
                          evt.preventDefault();
                          that.getPages(id);
                  });
               console.log(anchor, '<a>');
        }

};
GroupEditor.prototype.populatePageTableRows = function(currPage) {
    if (this.currentPageList != currPage) {
        var pages = this.pages[currPage],
            tbody = this.pageTable.find('tbody');

        tbody.find('tr').remove();
        for(var key in pages) {
            if(pages.hasOwnProperty(key)) {
                var tr = $('<tr>');
                tr.append($('<td/>').text(pages[key].title));
                tbody.append(tr);
            }
        }
        this.currentPageList = currPage;
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


