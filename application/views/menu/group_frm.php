<?php defined('SYSPATH') or die('No direct script access');
    echo form::fieldset('Grupa odnośników', array('id' => 'menu-group'));
?>
<div style="width: 45%">
<div class="input-wrap" style="width: 100%">
<?php
    echo form::label('group-name', 'Nazwa grupy'.req);
    echo form::input('group[name]', $group->name, array('id' => 'group-name'));
    echo form::error($errors['name']);
    echo form::hidden('group[id]', $group->id);
?>
</div>
<div style="width: 100%">
    <div class="input-wrap-label-right" style="margin-left: 1em">
    <?php
        echo form::label('group-status', 'Globalna', array('style' => 'margin: -.2em 0 0 0'));
        $action = Request::instance()->action;
        if ($action == 'add' || $action == 'index' && empty($_POST)) {
            $checked = TRUE;
        } else {
            $checked = ($group->is_global) ? TRUE : FALSE;
        }
        echo form::checkbox('group[is_global]', 1, $checked, array('id' => 'group-status'));
    ?>
    </div>
    <?php echo form::error($errors['is_global']); ?>
    <div id="group-pages">
        <label>Lista stron zawierających tę grupę odnośników<?php echo req ?>:</label>
        <a href="#pages-data" id="page-list-inv" class="open">Wyświetl aktywne strony</a>
        <ul>
            <?php
                if (isset($_POST['group']['pages'])) {
                    $post_pages = $_POST['group']['pages'];
                    foreach($post_pages as $page) : ?>
                         <li>
                            <?php
                                echo form::label('page'.$page['id'], $page['title']);
                                echo form::checkbox('group[pages]['.$page['id'].'][id]', $page['id'], TRUE, array('id' => 'page'.$page['id']));
                                echo form::hidden('group[pages]['.$page['id'].'][title]', $page['title']);
                             ?>
                        </li>
             <?php endforeach; ?>
             <?php
                } else if (isset($pages)) {
                    foreach ($pages as $page) : ?>
                        <li>
                            <?php
                                echo form::label('page'.$page->id, $page->title);
                                echo form::checkbox('group[pages]['.$page->id.'][id]', $page->id, TRUE, array('id' => 'page'.$page->id));
                                echo form::hidden('group[pages]['.$page->id.'][title]', $page->title);
                             ?>
                        </li>
                    <?php endforeach; } ?>
        </ul>
    </div>
</div>
<div id="pages-data" style="width: 100%;">
<table id="pages" cellspacing="1">
    <caption>Wybierz strony, na których ma pojawić się grupa.</caption>
    <thead>
        <tr>
            <th style="padding: .3em .5em">Tytuł strony</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
<div id="page-pagination-links" class="pagination-links"></div>
</div>
</div>
<?php echo form::fieldset('Położenie grupy', array('class' => 'location-chooser')) ?>
<div class="select-wrap">
<?php
    $locations = array(0 => 'Nagłówek', 1 => 'Kolumna boczna', 2 => 'Zawartość strony');
    $order = array();
     for ($i = 0; $i < 100; $i++) {
        $order[] = $i;
    }
    echo form::label('group-location', 'Lokalizacja'.req);
    echo form::select('group[location]', $locations, (empty($group->location)) ? -1 : $group->location, array('id' => 'group-location'));
?>
</div>
<?php   ?>
<div class="select-wrap" style="float: right; clear: none; ">
<?php
    echo form::label('group-order', 'Kolejność');
    echo form::select('group[order]', $order, $group->ord, array('id' => 'group-order', 'class' => 'order-chooser'));
?>
</div>
<?php
    echo form::error($errors['location']);
?>
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
