var Editor = {};

Editor.init = function() {
    Editor.MenuGroup.body = $('#menu-group');
    Editor.MenuItem.setItems($('.item'));
},
Editor.createMenuGroup = function() {
    Editor.MenuGroup.createNew();
},
Editor.reset = function() {
    Editor.MenuItem.removeAllExceptFirst();
}
Editor.clearVals = function(elements) {

    if (typeof elements.sort == 'function') {
        var length = elements.length;
        for (i = 0; i < length; i++) {
            clearElement($(elements[i]));
        }
    } else {
        elements.each(function() {
            clearElement($(this));
        });
    }

    function clearElement(element) {
        element.find('input, select').each(function() {
                 var input = $(this);
                 var type = input.attr('type').toLowerCase();
                 if (type == 'text') {
                        input.val('');
                 } else if (type == 'select-one') {
                     input.val(0);
                 }

        });
    }
    
}

Editor.disableInputs = function(element) {
    element.hide();
    element.find('input, select').attr('disabled', true);
},
Editor.enableInput = function(element) {
    element.show();
    element.find('input, select').attr('disabled', false);
}
Editor.getItemsCount = function() {
    return Editor.MenuItem.quantity;
},
Editor.hideMenuGroup = function(speed) {
    Editor.MenuGroup.hide(speed);
}

MenuGroup =  {
    body : undefined,
    isVisible : true,
 
    createNew : function() {
        //Editor.MenuItem.removeAllExceptFirst();
        this.clear();
        if (this.isVisible == false) {
            this.show();
        }
    },
    clear: function() {
        Editor.clearVals(this.body);
    },
    show : function(speed) {
        if (speed === undefined) {
            this.body.show();
        } else {
            this.body.slideDown(speed);
        }
        this.body.show(speed);
        this.isVisible = true;
    },
    hide : function(speed) {
        if (speed === undefined) {
            this.body.hide(speed);
        } else this.body.slideUp(speed);
        this.isVisible = false;
        this.clear();
    }
}

Editor.MenuItem = {
    quantity : 0,
    items : [],
    itemGroups : undefined,
    setItems : function(items) {
          var that = this;
           items.each(function() {
               that.quantity += 1;
               var curr = $(this);
               that.addListeners(curr);
               that.items.push(curr);
           });
           
           
    },
//    addNewItems : function(quantity) {
//        var lastItem = this.items[this.quantity - 1],
//            i = 0;
//        for (i = 0; i < quantity; i++ ) {
//            var newItem = this.clone(lastItem);
//            this.clear(newItem);
//            this.setItems(newItem);
//            this.setAttrSuffix(newItem, 'id', this.quantity);
//            newItem.find('legend').text('Odnośnik ' + this.quantity);
//            newItem.appendTo(this.container);
//        }
//    },
//    removeItems : function(quantity) {
//        for (var i = 0; i < quantity; i++) {
//            this.items.pop().remove();
//        }
//        this.quantity -= 1;
//    },

    addListeners : function(item) {
            var itemIdx = this.quantity,
                pageListBtn = item.find('.page-list-caller'),
                linkField = item.find('#link' + itemIdx);

            item.find('#item-outer' + itemIdx).click(function() {
                var radioOuter = $(this);
                linkField.data('prevValue', linkField.val());
                linkField.val('http://');
                pageListBtn.hide();
            });
            item.find('#item-inner' + itemIdx).click(function() {
                var oldValue = linkField.data('prevValue');
                if (oldValue === 'http://') {
                    oldValue = '';
                }
                linkField.val(oldValue);
                pageListBtn.show();
            });
            item.find('input[type="text"]').each(function() {
                $(this).counter({maxLength : 100});
            });
//            var removeBtn = item.find('.remove-item'),
//                that = this;
//            if (this.quantity < 2) {
//                removeBtn.hide();
//            } else {
//                removeBtn.click(function(evt) {
//                   evt.preventDefault();
//
//                   console.log(that.quantity, 'that quantity');
//                }).show();
//            }
    },
//    clone : function(item) {
//        var newItem = item.clone(false),
//            nextId = this.quantity + 1,
//            that = this;
//        newItem.find('*').each(function() {
//            var curr = $(this);
//            if (curr.tagName() == 'label') {
//                that.setAttrSuffix(curr, 'for', nextId);
//            } else if (curr.attr('id') != undefined) {
//                that.setAttrSuffix(curr, 'id', nextId);
//            }
//        })
//        return newItem;
//
//    },
//    setAttrSuffix : function(item, attrName, suffix) {
//            item.attr(attrName, item.attr(attrName).replace(/\d+/, suffix));
//    },
    removeAllExceptFirst : function() {
        if (this.quantity > 1) {
            $.each(this.items, function(index, value) {
                if (! index === 0) {
                    value.remove();
                }
            });

        }
        Editor.disableInputs(this.items[0].find('.item-group, .item-parent'));
        this.clearAll();
    },
    clear : function(item) {
        Editor.clearVals(item);
    },
    clearAll : function() {
        Editor.clearVals(this.items);
    },
    ItemGroup : function(id, name) {
        this.id = id;
        this.name = name;
    }
}

