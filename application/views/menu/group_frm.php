<?php defined('SYSPATH') or die('No direct script access');
    echo form::fieldset('Grupa odnośników', array('id' => 'menu-group'));
?>
<div style="width: 45%">
<div class="input-wrap" style="width: 100%">
<?php
    echo form::label('group-name', 'Nazwa grupy'.req);
    echo form::input('name[]', 'Grupa menu', array('id' => 'group-name'));
?>
</div>
<div class="input-wrap-label-right" style="margin-left: 1em">
<?php
    echo form::label('group-status', 'Globalna', array('style' => 'margin: -.2em 0 0 0'));
    echo form::checkbox('is_global', 1, TRUE, array('id' => 'group-status'));
?>
</div>
</div>
<?php echo form::fieldset('Położenie grupy', array('class' => 'location-chooser')) ?>
<div class="input-wrap-label-right">
<?php
    $locations = array(-1 => '', 0 => 'Nagłówek', 1 => 'Kolumna boczna', 2 => 'Zawartość strony');
    $order = array();
     for ($i = 0; $i < 100; $i++) {
        $order[] = $i;
    }
    echo form::label('group-location', 'Lokalizacja'.req);
    echo form::select('location[]', $locations, -1, array('id' => 'group-location'));
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
