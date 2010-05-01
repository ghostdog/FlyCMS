<?php defined('SYSPATH') or die('No direct script access');
    echo form::fieldset('Grupa odnośników', array('id' => 'menu-group'));
?>
<div style="width: 45%">
<div class="input-wrap" style="width: 100%">
<?php
    echo form::label('group-name', 'Nazwa grupy'.req);
    echo form::input('group[name]', $group->name, array('id' => 'group-name'));
?>
</div>
<div class="input-wrap-label-right" style="margin-left: 1em">
<?php
    echo form::label('group-status', 'Globalna', array('style' => 'margin: -.2em 0 0 0'));
    echo form::checkbox('group[global]', 1, (empty($group->is_global)) ? TRUE : $group->is_global, array('id' => 'group-status'));
?>
</div>
</div>
<?php echo form::fieldset('Położenie grupy', array('class' => 'location-chooser')) ?>
<div class="select-wrap">
<?php
    $locations = array(-1 => '', 0 => 'Nagłówek', 1 => 'Kolumna boczna', 2 => 'Zawartość strony');
    $order = array();
     for ($i = 0; $i < 100; $i++) {
        $order[] = $i;
    }
    echo form::label('group-location', 'Lokalizacja'.req);
    echo form::select('group[location]', $locations, (empty($group->location)) ? -1 : $group->location, array('id' => 'group-location'));
?>
</div>
<div class="select-wrap" style="float: right; clear: none; ">
<?php
    echo form::label('group-order', 'Pierwszeństwo');
    echo form::select('group[order]', $order, $group->order, array('id' => 'group-order', 'class' => 'order-chooser'));
?>
</div>
<table id="groups" cellspacing="2">
    <caption>Grupy aktywne w tej lokalizacji</caption>
    <thead>
        <tr>
            <th>Nazwa grupy</th>
            <th>Pierwszeństwo</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Grupa 1</td>
            <td>98</td>
        </tr>
    </tbody>
</table>
<?php
    echo form::close_fieldset();
    echo form::close_fieldset();
    fire::log($group, 'group');
?>
<script type="text/javascript">
    $('#group-name').counter({maxLength : 100});
</script>
