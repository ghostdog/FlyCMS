<?php defined('SYSPATH') or die('No direct script access');
    echo form::fieldset('Grupa odnośników', array('id' => 'menu-group'));
?>
<div class="input-wrap">
<?php
    echo form::label('group-name', 'Nazwa grupy');
    echo form::input('name[]', 'Grupa menu', array('id' => 'group-name'));
?>
</div>
<?php echo form::fieldset('Położenie grupy', array('class' => 'location-chooser')) ?>
<div class="input-wrap-label-right">
<?php
    $locations = array(0 => 'Nagłówek', 1 => 'Kolumna boczna', 2 => 'Zawartość strony');
    $order = array();
     for ($i = 0; $i < 100; $i++) {
        $order[] = $i;
    }
    echo form::label('group-location', 'Lokalizacja');
    echo form::select('location[]', $locations, 0, array('id' => 'group-location'));
?>
</div>
<div class="input-wrap-label-right" style="float: right; clear: none; ">
<?php
    echo form::label('group-order', 'Pierwszeństwo');
    echo form::select('order[]', $order, 0, array('id' => 'group-order', 'class' => 'order-chooser'));
?>
</div>
<?php
    echo form::close_fieldset();
    echo form::close_fieldset();
?>
<script type="text/javascript">
    $('#group-name').counter({maxLength : 100});
</script>
