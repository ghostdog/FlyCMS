<?php defined('SYSPATH') or die('No direct script access');
    echo html::script('media/js/menu.editor.js');
    echo form::open('admin/menus/add');
 ?>
<h3>Co mam utworzyć?:</h3>
<div style="margin: .5em 0 .5em 0">
<?php
    echo form::label('item', 'Pojedyncze odnośniki menu');
    echo form::radio('type[]', 'item', FALSE, array('id' => 'item'));
    echo form::label('group', 'Nową grupę odnośników', array('style' => 'margin-left: 1em'));
    echo form::radio('type[]', 'group', FALSE, array('id' => 'group'));
    echo View::factory('menu/group_frm');
?>
</div>
<div id="quantity-chooser">
    <h3 style="margin-top: .5em">Ile odnośników mam utworzyć?:</h3>
<?php
    for ($i = 1; $i < 11; $i++) {
        $values[$i] = $i ;
    }
    echo form::select('items-quantity', $values, null,
                       array('id' => 'items-quantity-chooser',
                           'style' => 'margin-left: 1em;
                                      width: 10em;
                      '));

?>
</div>
<div id="items-wrap">
<?php
    echo View::factory('menu/item_frm');
?>
</div>
<div id="safe-btn" style="float: right">
<?php echo form::submit('submit', 'Zapisz', array('style' => 'width: 10em'));  ?>
</div>
<?php echo form::close(); ?>
<script type="text/javascript">
      $(document).ready(function() {
              //Menu.Group.body = $('#menu-group');
              Editor.init();
              var groupRadio = $('#group'),
                  itemRadio = $('#item'),
                  menuGroup = Editor.MenuGroup,
                  quantityChooser = $('#quantity-chooser'),
                  safeBtn = $('#safe-btn');
           
//              quantityChooser.find('select').change(function() {
//                     var quantity = ($(this).val()),
//                         currentQuantity = Editor.getItemsCount();
//                         console.log(quantity, 'quantity');
//                         console.log(currentQuantity, 'currentQuantity');
//                         if (quantity > currentQuantity) {
//                             quantity = quantity - currentQuantity;
//                             Editor.appendNewItems(quantity);
//
//                         } else {
//                             Editor.removeItems(currentQuantity - quantity);
//                         }
//
//              });
//
              var groupChecked = groupRadio.attr('checked'),
                  itemChecked = itemRadio.attr('checked');
              if (groupChecked === false &&  itemChecked === false) {
                  menuGroup.hide();
                  quantityChooser.hide();
                  safeBtn.hide();
                  $('.item').hide();
              } else if (groupChecked !== false) {
                  menuGroup.show();
              } else {
                  menuGroup.hide();
              }
//              if (groupRadio.attr('checked') !== undefined) {
//                Editor.MenuGroup.hide();
//              }

              groupRadio.click(function() {
                  Editor.createMenuGroup();
                  quantityChooser.show();
                  Editor.reset();
                  setTimeout('$(\'.item\').slideDown(\'fast\');', 300);
                  setTimeout('$(\'#safe-btn\').show();', 500);
              });
              itemRadio.click(function() {
                  Editor.hideMenuGroup('fast');
                  quantityChooser.show();
                  $('.item-parent, .item-group').each(function() {
                      Editor.enableInput($(this));
                  });
                  $('.item').slideDown('fast');
                  setTimeout('$(\'#safe-btn\').show();', 500);
            });
      });
</script>