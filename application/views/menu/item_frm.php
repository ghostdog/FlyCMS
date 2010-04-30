<?php defined('SYSPATH') or die('No direct script access');
for ($i = 0; $i < 100; $i++) {
    $order[] = $i;
}

$i = 0;
fire::log($items, 'items');
foreach($items as $item) :
    $i++;
    echo form::fieldset((empty($item->name)) ? 'Odnośnik '.$i : $item->name, array('id' => 'item'.$i, 'class' => 'item'));
        
?>
    <div class="item-props-wrap">
    <div class="input-wrap">
<?php
    echo form::label('item-name'.$i, 'Nazwa odnośnika');
    echo form::input('name[]', $item->name, array('id' => 'item-name'.$i, 'class' => 'text-name'));
?>
    </div>
    <div class="item-type-chooser select-wrap" style="width: 49%">
<?php
    echo form::label('type-chooser'.$i, 'Typ odnośnika');
    echo form::select('type[]', array(0 => 'Wewnętrzny', 1 => 'Zewnętrzny'),
                                    $item->type, array('id' => 'type-chooser'.$i, 'style' => 'width: 10em;'));
//    echo form::radio('type.'.$i.'[]', 0, (isset($item->type)) ? $item->type : false, array('id' => 'item-inner'.$i));
//    echo form::label('item-outer'.$i, 'Zewnętrzny');
//    echo form::radio('type.'.$i.'[]', 1, (isset($item->type)) ? $item->type : false, array('id' => 'item-outer'.$i));
?>
    </div>
    <div class="input-wrap">
<?php
    echo form::label('link'.$i, 'Adres docelowy');
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
    <td><?php echo form::select('item-group[]',
            array('1' => 'Grupa 1'), $item->group_id, array('id' => 'item-group'.$i)); ?></td>
</tr>
<tr class="select-wrap item-parent">
    <td><?php echo form::label('item-parent'.$i, 'Odnośnik nadrzędny'); ?></td>
    <td><?php echo form::select('parent[]', array('1' => 'Nadrzędny 1'),
                        $item->parent, array('id' => 'item-parent'.$i));?></td>
</tr>
<tr class="select-wrap item-order">
    <td><?php echo form::label('item-order'.$i, 'Pierwszeństwo'); ?></td>
    <td><?php echo form::select('order[]',$order, $item->order, null, array('id' => 'item-order'.$i));?></td>
</tr>
</table>
<?php
    echo form::close_fieldset();
    echo form::close_fieldset();
endforeach;
?>
