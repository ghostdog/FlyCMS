<?php defined('SYSPATH') or die('No direct script access');
    echo form::open('admin/menugroups/add');
 ?>
<h3>Co mam utworzyć?:</h3>
<div style="margin: .5em 0 .5em 0">
<?php
    echo form::label('item', 'Pojedyncze odnośniki menu');
    echo form::radio('menu_type', 'item', form::radioChecked('menu_type', 'item'), array('id' => 'item'));
    echo form::label('group', 'Nową grupę odnośników', array('style' => 'margin-left: 1em'));
    echo form::radio('menu_type', 'group', form::radioChecked('menu_type', 'group'), array('id' => 'group'));
?>
<h3 id="req-text" style="float: left; clear: both; margin: .5em;">
    <em class="required">*</em> - elementy obowiązkowe</h3>
<?php
    echo View::factory('menu/group_frm', array('group' => $group));
?>
</div>
<div id="quantity-chooser" style="float: left; clear: left;">
    <h3 style="margin-top: .5em">Ile odnośników mam utworzyć?:</h3>
<?php
    for ($i = 0; $i < 10;) {
        $values[++$i] = $i ;
    }
    echo form::select('items_quantity', $values, form::value('items_quantity'),
                       array('id' => 'items-quantity-chooser',
                           'style' => 'margin-left: 1em;
                                      width: 10em;
                      '));

    echo form::submit('quantity_submit','Odśwież', array('style' => 'margin-left: 1em; width: 5em'));
?>
</div>
<div id="items-wrap">
<?php
    echo View::factory('menu/item_frm', array('items_count' => $items_count, 'items' => $items));
?>
</div>
<div id="safe-btn" style="float: right">
<?php 
    echo form::submit('submit', 'Zapisz', array('style' => 'width: 10em'));
    echo form::input('restore', 'Przywróć', array('type' => 'reset', 'style' => 'border: none'));
    echo form::input('clear', 'Wyczyść', array('type' => 'reset', 'style' => 'border: none', 'id' => 'clearer'));

?>
</div>
<?php
echo form::close();
echo html::script('media/js/items.editor.js');
echo html::script('media/js/group.editor.js');
?>
<script type="text/javascript">


        var Editor = function() {
                this.items = new ItemsEditor($('.item'));
                this.group = new GroupEditor();
                this.groupRadio = $('#group');
                this.itemRadio = $('#item');
                this.quantityChooser = $('#quantity-chooser');
                this.submitBtn = $('#safe-btn');
                this.reqText = $('#req-text');
                this.addListeners();
                this.init();
        };
        Editor.prototype.init = function() {
            if (this.isGroupRadioChecked()) {
                    this.groupRadio.trigger('click');
            } else if (this.isItemRadioChecked()) {
                    this.itemRadio.trigger('click');
            } else {
                this.quantityChooser.hide();
                this.group.hide();
                this.items.hideAll();
                this.reqText.hide();
                this.submitBtn.hide();
            }
        };
        Editor.prototype.isGroupRadioChecked = function() {
            return (this.groupRadio.attr('checked') == true);
        };
        Editor.prototype.isItemRadioChecked = function() {
            return (this.itemRadio.attr('checked') == true);
        };
        Editor.prototype.addListeners = function() {
                var that = this;
                this.groupRadio.click(function() {
                    that.group.show('fast');
                    that.items.disableInputs();
                    showCommonElements();
                });
                this.itemRadio.click(function() {
                    that.group.hide('fast');
                    that.items.showAll();
                    that.items.enableInputs();
                    showCommonElements();
                });

                function showCommonElements() {
                    that.reqText.fadeIn();
                    that.submitBtn.fadeIn('slow');
                    that.quantityChooser.fadeIn('slow');
                }
        };

        $(document).ready(function() {
            var editor = new Editor();


            $('#clearer').click(function(evt) {
                evt.preventDefault();
                editor.items.clearAll();
                editor.group.clear();
            });
        });
               
 

////              //Menu.Group.body = $('#menu-group');
////              Editor.init();
//              var groupRadio = $('#group'),
//                  itemRadio = $('#item'),
//                  menuGroup = Editor.MenuGroup,
//                  quantityChooser = $('#quantity-chooser'),
//                  safeBtn = $('#safe-btn');
//
////              quantityChooser.find('select').change(function() {
////                     var quantity = ($(this).val()),
////                         currentQuantity = Editor.getItemsCount();
////                         console.log(quantity, 'quantity');
////                         console.log(currentQuantity, 'currentQuantity');
////                         if (quantity > currentQuantity) {
////                             quantity = quantity - currentQuantity;
////                             Editor.appendNewItems(quantity);
////
////                         } else {
////                             Editor.removeItems(currentQuantity - quantity);
////                         }
////
////              });
////
//              var groupChecked = groupRadio.attr('checked'),
//                  itemChecked = itemRadio.attr('checked');
//              if (groupChecked === false &&  itemChecked === false) {
//                  menuGroup.hide();
//                  quantityChooser.hide();
//                  safeBtn.hide();
//                  $('.item').hide();
//              } else if (groupChecked !== false) {
//                  menuGroup.show();
//              } else {
//                  menuGroup.hide();
//              }
////              if (groupRadio.attr('checked') !== undefined) {
////                Editor.MenuGroup.hide();
////              }
//
//              groupRadio.click(function() {
////                  Editor.createMenuGroup();
//                  quantityChooser.show();
//                  Editor.reset();
//                  setTimeout('$(\'.item\').slideDown(\'fast\');', 300);
//                  setTimeout('$(\'#safe-btn\').show();', 500);
//              });
//              itemRadio.click(function() {
//                  Editor.hideMenuGroup('fast');
//                  quantityChooser.show();
//                  $('.item-parent, .item-group').each(function() {
//                      Editor.enableInput($(this));
//                  });
//                  $('.item').slideDown('fast');
//                  setTimeout('$(\'#safe-btn\').show();', 500);
//            });
    
</script>