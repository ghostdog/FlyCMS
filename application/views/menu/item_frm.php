<?php defined('SYSPATH') or die('No direct script access');
    define('required', '<em class="required">*</em>');

for ($j = 0; $j < 100; $j++) {
    $order[] = $j;
}
$i;
fire::log($i, 'i');
foreach($items as $item) :
    $i++;
    echo form::fieldset((empty($item->name)) ? 'Odnośnik '.$i : $item->name, array('id' => 'item'.$i, 'class' => 'item'));
        
?>
    <div class="item-props-wrap">
    <div class="input-wrap">
<?php
    echo form::label('item-name'.$i, 'Nazwa odnośnika'.required);
    echo form::input('name[]', $item->name, array('id' => 'item-name'.$i, 'class' => 'text-name'));
?>
    </div>
    <div class="item-type-chooser select-wrap" style="width: 49%">
<?php
    echo form::label('type-chooser'.$i, 'Typ odnośnika');
    echo form::select('type[]', array(0 => 'Wewnętrzny', 1 => 'Zewnętrzny'),
                                    $item->type, array('id' => 'type-chooser'.$i, 'style' => 'width: 10em;'));
?>
    </div>
    <div class="input-wrap">
<?php
    echo form::label('link'.$i, 'Adres docelowy'.required);
    echo form::input('link[]', $item->link, array('id' => 'link'.$i, 'class' => 'text-link'));
?>
    <a href="#page-list1" class="page-list-caller">Wyświetl listę dostępnych stron</a>

</div>
<div class="input-wrap">
<?php
    echo form::label('title'.$i, 'Atrybut "title"');
    echo form::input('title[]', $item->title, array('id' => 'title'.$i, 'class' => 'text-link'));
?>
</div>
</div>
<?php
    echo form::fieldset('Położenie odnośnika', array('class' => 'item-location location-chooser'));
?>
<table cellspacing="0">
<tr class="select-wrap item-group">
    <td><?php echo form::label('item-group'.$i, 'Grupa odnośników'); ?></td>
    <td>
        <?php
             foreach ($groups as $group) {
                 $options[$group->id] = $group->name;
             }
             echo form::select('item-group[]', $options, $item->menugroup_id, array('id' => 'item-group'.$i));
        ?>
        
    </td>
</tr>
<tr>
    <td class="ajax-msg" colspan="2" style="text-align: right"></td>
</tr>
<tr class="select-wrap item-parent">
    <td><?php echo form::label('item-parent'.$i, 'Odnośnik nadrzędny'); ?></td>
    <td><?php

        echo form::select('parent[]', $options,
                        $item->parent, array('id' => 'item-parent'.$i));?></td>
</tr>
<tr class="select-wrap item-order">
    <td><?php echo form::label('item-order'.$i, 'Pierwszeństwo'); ?></td>
    <td><?php echo form::select('order[]',$order, $item->order, array('id' => 'item-order'.$i));?></td>
</tr>
</table>
<?php
    echo form::close_fieldset();
    echo form::close_fieldset();
endforeach;
?>
