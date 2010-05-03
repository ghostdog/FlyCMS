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
    echo form::checkbox('group[global]', 1, (isset($group->is_global)) ? $group->is_global : FALSE, array('id' => 'group-status'));
?>
</div>
<div id="pages-data" style="width: 100%;">
<table id="pages" cellspacing="2">
    <caption>Wybierz strony, na których ma pojawić się grupa.</caption>
    <thead>
        <tr>
            <th>Nazwa</th>
        </tr>
    </thead>
    <tbody>
        
    </tbody>
</table>
<div id="pagination-links">
</div>
<div id="pagination-icons">
<?php
            echo html::image('media/img/first_disabled.png', array('id' => 'first-disabled'));
            echo html::image('media/img/first_enabled.png', array('id' => 'first-enabled'));
            echo html::image('media/img/last_disabled.png', array('id' => 'last-disabled'));
            echo html::image('media/img/last_enabled.png', array('id' => 'last-enabled'));
            echo html::image('media/img/next_enabled.png', array('id' => 'next-enabled'));
            echo html::image('media/img/next_disabled.png', array('id' => 'next-disabled'));
            echo html::image('media/img/prev_disabled.png', array('id' => 'prev-disabled'));
            echo html::image('media/img/prev_enabled.png', array('id' => 'prev-enabled'));
?>
</div>
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
    echo form::label('group-order', 'Kolejność');
    echo form::select('group[order]', $order, $group->order, array('id' => 'group-order', 'class' => 'order-chooser'));
?>
</div>
<table id="groups" cellspacing="2">
    <caption>Grupy obecne w tej lokalizacji</caption>
    <thead>
        <tr>
            <th>Nazwa</th>
            <th>Kolejność</th>
            <th>Globalna</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
<?php
    echo form::close_fieldset();
    echo form::close_fieldset();
?>
<script type="text/javascript">
    $('#group-name').counter({maxLength : 100});
</script>
