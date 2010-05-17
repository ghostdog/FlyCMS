var ItemsEditor = function(items) {
      this.items = [];
      this.setItems(items);
      this.pagination = undefined;
}
ItemsEditor.prototype.setItems = function(items) {
    var that = this;
    that.items = [];
    items.each(function(index, element) {
        var item = $(element);
        that.addListeners(item, ++index);
        that.items.push(item);
        item.find('#item-group').trigger('change');
    });
    $('.page-list-caller').each(function() {
        var invoker = $(this);
        invoker.dialog({
            onOpen : function(dialog, invoker, evt) {
                var tbody = $('#item-pages-list').find('tbody'),
                    caption = $('#item-pages-list').find('caption');
                if (this.pagination == undefined) {
                    this.pagination = new Pagination('#item-page-pagination',
                                            {callback : function(pages) {
                                                tbody.find('tr').remove();
                                                for (var key in pages) {
                                                        if (pages.hasOwnProperty(key)) {
                                                            var page = pages[key];
                                                            tbody.append(
                                                                $('<tr/>')
                                                                .append(
                                                                     $('<td/>').append(
                                                                        $('<label/>').text(page.title)
                                                                         .attr('for', 'item-page'+page.id)
                                                                      ).addClass('title')
                                                                 )
                                                                 .append($('<td/>').append(
                                                                        $('<input/>').attr(
                                                                            {
                                                                                'type' : 'radio',
                                                                                'name' : 'item-page',
                                                                                'value' : page.link,
                                                                                'id' : 'item-page'+page.id
                                                                            }
                                                                        )
                                                                     )
                                                                  )
                                                                  .click(function() {
                                                                      $(this).find('input').attr('checked', true);
                                                                  })

                                                            )
                                                        }
                                                 }
                                                    caption.text('Wybierz stronę, do której będzie prowadził odnośnik.');
                                              },
                                              before : function() {
                                                caption.text('Pobieranie listy stron...');
                                              },
                                              limit : 10
                                            });
                }
                this.pagination.request();
            },
            onSubmit : function(dialog, invoker, evt) {
                     evt.preventDefault();
                     var checked = dialog.find(':checked'),
                         selectedTab = $('#items-list').find('a.selected');
                     $(selectedTab.attr('href'))
                     .find('input[id*=link]').val(checked.val());
            }
        });

        invoker.click(function(evt) {
            evt.preventDefault();

        });
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
             var input = $('#item-name' + index),
                target = $('a[href="#item' + index + '"] > .name');
                target.data('default', target.text());
                input.keyup(function() {
                    var text = input.val();
                    if (text.length == 0) {
                        target.text(target.data('default'));
                    } else {
                        target.text(text);
                    }
              });
              var orderSelect = $('#item-order' + index),
                  orderTarget = $('a[href="#item' + index + '"] > .order');

                  orderSelect.change(function() {
                      orderTarget.text(orderSelect.val());
              });

           
            item.find('#item-group' + index).change(function() {
                var msgOutput = item.find('.ajax-msg').text('Pobieranie informacji...'),
                    groupId = $(this).val(),
                    itemSelect = item.find('#item-parent'+index);

                $.getJSON('/kohana/admin/menus/ajax_group_items','group_id='+groupId,
                        function(data, status) {
                            if (data.length > 0) {
                                msgOutput.text('Zakończono pobieranie odnośników.');
                            } else {
                                msgOutput.text('Nie ma żadnych odnośników w tej grupie.');
                            }
                            itemSelect.find('option').remove();
                            itemSelect.append(
                                                $("<option/>").attr('value', 0).text('')
                                            );
                            for (var key in data) {
                                if (data.hasOwnProperty(key)) {
                                    var item = data[key];
                                    itemSelect.append($("<option/>")
                                              .attr("value",item.id)
                                              .text(item.name));
                                }
                            }
                            
                        });
            })
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
        value.find('select').trigger('change');
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
ItemsEditor.prototype.getSize = function() {
    return this.items.length;
};



