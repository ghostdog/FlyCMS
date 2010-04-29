<?php defined('SYSPATH') or die('No direct script access');
    for ($i = 0; $i < 100; $i++) {
        $order[] = $i;
    }
    echo form::fieldset('Odnośnik 1', array('id' => 'item1', 'class' => 'item'));
?>
<div class="item-props-wrap">
<div class="input-wrap">
<?php
    echo form::label('item-name1', 'Nazwa odnośnika');
    echo form::input('name[]', 'Nazwa odnośnika', array('id' => 'item-name1', 'class' => 'text-name'));
?>
</div>
<div class="item-type-chooser">
<h3>Określ typ odnośnika:</h3>
<?php

    echo form::label('item-inner1', 'Wewnętrzny');
    echo form::radio('internal[]', 0, TRUE, array('id' => 'item-inner1'));
    echo form::label('item-outer1', 'Zewnętrzny');
    echo form::radio('internal[]', 1, FALSE, array('id' => 'item-outer1'));
?>
</div>
<div class="input-wrap">
<?php
    echo form::label('link1', 'Adres docelowy');
    echo form::input('link[]', 'Strona docelowy', array('id' => 'link1', 'class' => 'text-link'));
?>
    <a href="#page-list1" class="page-list-caller">Wyświetl listę dostępnych stron</a>
<!--    <ul class="page-list">
        <?php for ($i = 0; $i < 10; $i++) : ?>
        <li>
            <?php
                echo form::label('page'.$i, 'Tytuł strony '.$i);
                echo form::radio('page', $i, FALSE, array('id' => 'page'.$i));
            ?>
        </li>
        <?php endfor; ?>
    </ul>
-->
</div>
<div class="input-wrap">
<?php
    echo form::label('title1', 'Atrybut "title"');
    echo form::input('title[]', 'Jakaś tam wartość', array('id' => 'title1', 'class' => 'text-link'));
?>
</div>
</div>
<?php
    echo form::fieldset('Położenie odnośnika', array('class' => 'item-location location-chooser'));
?>
<div class="input-wrap-label-right item-group">
<?php
    echo form::label('item-group1', 'Grupa odnośników');
    echo form::select('item-group[]', array('1' => 'Grupa 1'), null, array('id' => 'item-group1'));
?>
</div>
<div class="input-wrap-label-right item-parent">
<?php
    echo form::label('item-parent1', 'Odnośnik nadrzędny');
    echo form::select('parent[]', array('1' => 'Nadrzędny 1'), null, array('id' => 'item-parent1'));
?>
</div>
<div class="input-wrap-label-right item-order">
<?php
    echo form::label('item-order1', 'Pierwszeństwo');
    echo form::select('order[]', $order, null, array('id' => 'item-order1'));
?>
</div>
<?php
    echo form::hidden('type[]', 'item');
    echo form::close_fieldset();
?>
<?php
    echo form::close_fieldset();
?>
<script type="text/javascript">
//         $('input[type="text"]').each(function(index) {
//             if (index == 0) $(this).focus();
//             $(this).counter({maxLength : 100});
//         })


</script>