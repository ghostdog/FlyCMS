<?php defined('SYSPATH') or die('No direct script access');
for ($i = 0; $i < 100; $i++) {
    $order[] = $i;
}

$i = 0;
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
    <div class="item-type-chooser">
    <h3>Określ typ odnośnika:</h3>
<?php
    echo form::label('item-inner'.$i, 'Wewnętrzny');
    echo form::radio('type.'.$i.'[]', 0, $item->type, array('id' => 'item-inner'.$i));
    echo form::label('item-outer'.$i, 'Zewnętrzny');
    echo form::radio('type.'.$i.'[]', 1, $item->type, array('id' => 'item-outer'.$i));
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
<div class="input-wrap-label-right item-group">
<?php
    echo form::label('item-group'.$i, 'Grupa odnośników');
    echo form::select('item-group[]', array('1' => 'Grupa 1'), $item->group_id, array('id' => 'item-group'.$i));
?>
</div>
<div class="input-wrap-label-right item-parent">
<?php
    echo form::label('item-parent'.$i, 'Odnośnik nadrzędny');
    echo form::select('parent[]', array('1' => 'Nadrzędny 1'), $item->parent, array('id' => 'item-parent'.$i));
?>
</div>
<div class="input-wrap-label-right item-order">
<?php
    echo form::label('item-order'.$i, 'Pierwszeństwo');
    echo form::select('order[]', $item->order, null, array('id' => 'item-order'.$i));
?>
</div>
<?php
    echo form::close_fieldset();
    echo form::close_fieldset();
endforeach;
?>
