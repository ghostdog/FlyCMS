var ItemsEditor = function(items) {
      this.items = [];
      this.setItems(items);
}

ItemsEditor.prototype.setItems = function(items) {
    var that = this;
   items.each(function(index, element) {
        that.addListeners($(element), ++index);
        that.items.push($(element));
    })
};
ItemsEditor.prototype.addListeners = function(item, index) {
            var pageListBtn = item.find('.page-list-caller'),
                linkField = item.find('#link' + index);
            item.find('#type-chooser' + index).change(function() {
                var currVal = $(this).val();
                if (currVal == 0) {
                   var oldValue = linkField.data('prev-val');
                   if (oldValue == 'http://') {
                        oldValue = '';
                    }
                linkField.val(oldValue);
                pageListBtn.show();

                } else {
                    linkField.data('prev-val', linkField.val());
                    linkField.val('http://');
                    pageListBtn.hide();
                }

            });
            item.find('input[type="text"]').each(function() {
                $(this).counter({maxLength : 100});
            });
};
ItemsEditor.prototype.clearAll = function() {
    this.itemsWalk(':input', function(input) {
                 var type = input.attr('type').toLowerCase();
                 if (type == 'text') {
                        input.val('');
                 } else if (type == 'select-one') {
                     input.val(0);
                 }
    });
}

ItemsEditor.prototype.disableInputs = function() {
    this.itemsWalk('select[id^=item-parent], select[id^=item-group], .item-group, .item-parent', function(input) {
       input.attr('disabled', true).hide();
    });
};
ItemsEditor.prototype.enableInputs = function() {
    this.itemsWalk('select[id^=item-parent], select[id^=item-group], .item-group, .item-parent', function(input) {
        input.removeAttr('disabled').show();
    })
};
ItemsEditor.prototype.showAll = function() {
    $.each(this.items, function(index, value) {
        value.show();
    })
}
ItemsEditor.prototype.hideAll = function() {
    $.each(this.items, function(index, value) {
       value.hide();
    });
};
ItemsEditor.prototype.itemsWalk = function(selector, callback) {
    $.each(this.items, function(index, value) {
            value.find(selector).each(function() {
                    callback($(this));
            });
    });
};


