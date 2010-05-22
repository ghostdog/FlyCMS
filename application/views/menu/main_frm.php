<?php defined('SYSPATH') or die('No direct script access');
$action = Request::instance()->action;
$frm_act = $action;
if ($action == 'edit') {
    $frm_act .= '/'.Request::instance()->param('id');
}

echo form::open('admin/menus/'.$frm_act);
if ($action == 'add') {
?>
    <h3>Co mam utworzyć?:</h3>
    <div style="margin: .5em 0 .5em 0">
    <?php
        echo form::label('item', 'Pojedyncze odnośniki menu');
        echo form::radio('menu_type', 'item', form::radio_checked('menu_type', 'item'), array('id' => 'item'));
        echo form::label('group', 'Nową grupę odnośników', array('style' => 'margin-left: 1em'));
        echo form::radio('menu_type', 'group', form::radio_checked('menu_type', 'group'), array('id' => 'group'));
    ?>
        <a href="#" id="groups-list-inv" class="open" style="padding: 0 1.5em .5em 0">Wyświetl dostępne grupy</a>
    </div>
<?php } ?>
<table id="groups-list" cellspacing="0">
        <caption></caption>
        <thead>
            <tr>
                <th class="name">Nazwa</th>
                <th>Lokalizacja</th>
                <th>Czy globalna?</th>
                <th>Kolejność</th>
                <th>Ilość odnośników</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
</table>
<h4 id="req-text">
<em class="required">*</em> - elementy obowiązkowe</h4>
<?php
    echo $group;
?>
<div id="quantity-chooser" style="float:right; width:40%; margin-top: 4em">
    <h3 style="margin-top: .5em">Zmień liczbę odnośników na:</h3>
<?php
    for ($i = 0; $i < 10;) {
        $values[++$i] = $i ;
    }
    echo form::select('items_quantity', $values, form::value('items_quantity'),
                       array('id' => 'items-quantity-chooser',
                           'style' => 'margin-left: 1em;
                                      width: 10em;
                      '));

    echo form::submit('quantity_submit','Odśwież', array('style' => 'margin-left: 1em; width: 5em', 'id' => 'quantity-submit'));
?>
    <span id="refresh-msg"></span>
</div>
<ul id="items-list" style="float: left; clear: left">
    <?php $i = 0;
        foreach($items as $item) : ?>
    <li>
        <?php
            $i += 1;
            $item_order = (empty($item->ord)) ? ' [<span class="ord" title="Kolejność">0</span>]' : ' [<span class="ord" title="Kolejność">'.$item->order.'</span>]';
            $name = (empty($item->name)) ? '<span class="name">Odnośnik '.$i.'</span> ': '<span class="name">'.$item->name.'</span>';
            $error_mark = (isset($items_errors[$i - 1])) ? ' <strong style="color:red; text-decoration: underline">Błąd!</strong>' : '';
            echo html::anchor('#item'.$i, $name.$item_order.$error_mark);
        ?>
    </li>
    <?php endforeach ?>
</ul>
<div id="items-wrap">
<?php
    echo View::factory('menu/item_frm', array('items' => $items, 'groups' => $groups, 'i' => 0, 'errors' => (isset($items_errors)) ? $items_errors : array()));
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
    echo html::script('media/js/pagination.js');
    echo html::script('media/js/jquery.dialog.js');
?>
<div id="dialog">
    <div id="dialog-header">
        <h4>Tytuł dialogu</h4>
        <a href="#"><?php echo html::image('media/img/x_btn.png') ?></a>
    </div>
    <div id="dialog-content">
        <table id="item-pages-list" style="float: left; width: 100%" cellspacing="0">
            <caption></caption>
            <tbody>

            </tbody>
        </table>
        <div id="dialog-footer">
            <div id="item-page-pagination" class="pagination-links">
            </div>
            <input type="submit" id="dialog-submit" value="Zatwierdź wybór"/>
        </div>
    </div>
</div>
<style type="text/css">
#dialog table tr:hover {
    background-color: #d5d5d5;
    cursor: pointer;
}
</style>
<script type="text/javascript">

        var Editor = function() {
                this.items = new ItemsEditor($('.item'), <?php echo url::site() ?>  + 'admin/pages/index/',
                                                        <?php echo url::site() ?>  + 'admin/menus/ajax_group_items');
                this.group = new GroupEditor(<?php echo url::site() ?> + 'admin/menus/ajax_groups_by_location',
                                            <?php echo url::site() ?>  + 'admin/pages/index/');
                this.groupRadio = $('#group');
                this.itemRadio = $('#item');
                this.quantityChooser = $('#quantity-chooser');
                this.submitBtn = $('#safe-btn');
                this.reqText = $('#req-text');
                this.itemsList =$('#items-list');
                this.addListeners();
                this.init();
        };
        Editor.prototype.init = function() {
            if (this.isGroupRadioChecked()) {
                    this.groupRadio.trigger('click');
            } else if (this.isItemRadioChecked()) {
                    this.itemRadio.trigger('click');
                } else {
                if (this.groupRadio.length > 0) {
                    this.itemsList.hide();
                    this.quantityChooser.hide();
                    this.group.hide();
                    this.items.hideAll();
                    this.reqText.hide();
                    this.submitBtn.hide();
                } else {
                    this.items.showAll();
                    makeTabs();
                    this.itemsList.find('a:first').click();
                }
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
                    that.itemsList.hide();
                    $('.ajax-msg').hide();
                    showCommonElements();
                });
                this.itemRadio.click(function() {
                    that.group.hide('medium');
                    that.items.showAll();
                    that.items.enableInputs();
                    $('.ajax-msg').show();
                    showCommonElements();
                });

                function showCommonElements() {
                    that.itemsList.show('fast');
                    that.reqText.fadeIn();
                    that.submitBtn.fadeIn(1100);
                    that.quantityChooser.fadeIn(1500);
                    $('#items-list a').filter(':first').trigger('click');
                }
        };

        function makeTabs() {
            var tabContainers = $('fieldset[id^=item]').hide();
            $('#items-list a').click(function () {
                tabContainers.hide().filter(this.hash).show();
                $('#items-list a').removeClass('selected');
                $(this).addClass('selected');
                return false;
            });
        }

        function removeItemTabs(quantity, editor) {
            var items = editor.items.items,
                tabs = $('#items-list li'),
                idx = editor.items.getSize() - 1;
            while (idx > 0) {
               if (quantity > 0) {
                   items[idx].remove();
                   $(tabs[idx]).remove();
                   quantity--;
               }
               idx -= 1;
           }
           editor.items.setItems($('.item'));
           makeTabs();
           $('#items-list a').filter(':first').click();
        }
        $(document).ready(function() {
                        makeTabs();
                        $('#groups-list').hide();

                        $.ajaxSetup({
                            type : 'GET'
                        });
                        var editor = new Editor();
                        $('#quantity-submit').click(function(evt) {
                            evt.preventDefault();
                            var submit = $(this),
                                requestSize = editor.quantityChooser.find('select').val();
                                changeTabs(requestSize);
                               
                        });
                        $('#clearer').click(function(evt) {
                            evt.preventDefault();
                            editor.items.clearAll();
                            editor.group.clear();
                        });
                       var hideTable = function(evt) {
                             evt.preventDefault();
                             var invoker = $(this);
                                $('#groups-list').slideUp('medium');
                                invoker.unbind('click', hideTable)
                                .bind('click', getGroups).removeClass('close').addClass('open');
                       }

//                          function markRow(row) {
//                             row.find(':checkbox').attr('checked', true);
//                             row.addClass('marked');
//                         }
//
//                         function unmarkRow(row) {
//                             row.find(':checkbox').attr('checked', false);
//                             row.removeClass('marked');
//                         }
                         var getGroups = function(evt) {
                                evt.preventDefault();
                                var invoker = $(this),
                                    outputTable = $('#groups-list').show(),
                                    body = outputTable.find('tbody').hide(),
                                    msgOutput = outputTable.find('caption');
                                msgOutput.text('Pobieranie listy grup...');

                                $.ajax({
                                            dataType : 'html',
                                            data : '',
                                            url : <?php echo url::site() ?> + 'admin/menus/ajax_groups_list',
                                            error : function(err, xhr, status) {
                                                msgOutput.text('Wystąpił błąd podczas próby pobrania grup.');
                                            },
                                            success : function(data, xhr, textStatus) {
                                                if (data.length > 0) {
                                                    body.find('tr').remove();
                                                    body.append(data).slideDown('medium');
                                                    msgOutput.text('List grup pobrana z powodzeniem.');
                                                    outputTable.slideDown('medium');
                                                    body.find('tr').each(function(index) {
                                                        var tr = $(this);
                                                        tr.find('td.name div').hide();
                                                        ((index & 1) == 0) ? tr.addClass('even') : tr.addClass('odd');
                                                        tr.hover(function() {
                                                            tr.find('td.name > div').show();
                                                        }, function() {
                                                            tr.find('td.name > div').hide();
                                                        })
                                                   });
                                                } else {
                                                    msgOutput.text('Nie ma żadnych dostępnych grup');
                                                }
                                          }
                                });
                                invoker.unbind('click', getGroups).bind('click', hideTable).removeClass('open').addClass('close');
                        }
        var groupListInvoker = $('#groups-list-inv').bind('click', getGroups);

        function changeTabs(reqSize) {
                    var itemsSize = editor.items.getSize(),
                    changeSize = 0,
                    msgOutput = $('#refresh-msg'),
                    requestSize = reqSize,
                    showGroupChooser = 1;
                    if ($('#group').attr('checked') == true) {
                            showGroupChooser = 0;
                    }
                    if (requestSize == itemsSize) {
                   
                    } else if(requestSize > itemsSize) {
                        changeSize = requestSize - itemsSize;
                        var nextId = itemsSize;
                        msgOutput.text('Odświeżam...');
                        $.ajax({
                            dataType : 'html',
                            data : 'add_sz='+changeSize+'&next_id='+nextId+'&show_group_chooser='+showGroupChooser,
                            url : <?php echo url::site() ?>  + 'admin/menus/ajax_items_refresh',
                            error : function(err, xhr, status) {
                                msgOutput.text('Błąd.');
                            },
                            success : function(data, xhr, textStatus) {
                               msgOutput.text('');
                               $('#items-wrap').append(data);
                                for (i = 0; i < changeSize; i++) {
                                    nextId += 1;
                                    $('#items-list').append($('<li/>')
                                                    .append(
                                                    $('<a/>')
                                                      .attr('href', '#item'+nextId)
                                                      .append(
                                                        $('<span/>').addClass('name').text('Odnośnik '+nextId)
                                                      )
                                                      .append(' [<span class="ord">0</span>]')
                                                   )
                                                )
                                }

                                editor.items.setItems($('.item'));
                                makeTabs();
                                $('#items-list a').filter(':first').click();
   
                            }
                        });

                    } else if (requestSize < itemsSize) {
                        changeSize = itemsSize - requestSize;
                        removeItemTabs(changeSize, editor);
                    }
                }
 
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