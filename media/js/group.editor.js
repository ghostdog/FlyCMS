var GroupEditor = function() {
    this.body = $('#menu-group');
    this.groupProperties = ['name', 'order'];
    this.groups = [];
    this.currentLocation = -1;
    this.chooser = $('#group-location');
    this.groupsTable = $('#groups').hide();
    this.pageList = $('#page-list');
    this.statusSwitcher = $('#group-status');
    this.addListeners();
    this.chooser.trigger('change');

    if (this.statusSwitcher.attr('checked') == true) {
        this.pageList.hide();
    } else {
        this.pageList.show();
        this.getPages();
    }
};
GroupEditor.prototype.addListeners = function() {
    this.pageList.find('tr').click(function() {
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
            that.pageList.slideUp('fast');
        } else  {
            that.pageList.slideDown('fast');
        }
    })
    this.chooser.change(function() {
        var chooser = $(this);
        var location = chooser.val();
        if (location != -1) {
            that.groupsTable.show();
            if (that.groups[location] == undefined) {
            var caption = that.groupsTable.find('caption');
            caption.text('Pobieranie informacji...');
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
    var caption = this.pageList.find('caption').text('Pobieranie listy stron...'),
        action = '/kohana/admin/pages/ajax_get_pages',
        query =  (resultPageId == undefined) ? '' : 'page='+resultPageId;
    $.getJSON(action, query, function(data, status) {
        console.log(data, 'data');
        caption.text('Wybierz strony, na których ma pojawić się grupa.');
    });
}
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


