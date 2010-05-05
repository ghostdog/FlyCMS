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
    <td>
        <?php
             foreach ($groups as $group) {
                 $options[$group->id] = $group->name;
             }
             echo form::select('item-group[]', $options, $item->group_id, array('id' => 'item-group'.$i));
            
        ?>
    </td>
</tr>
<tr class="select-wrap item-parent">
    <td><?php echo form::label('item-parent'.$i, 'Odnośnik nadrzędny'); ?></td>
    <td><?php
        $options = array('-1' => 'Brak');
        echo form::select('parent[]', $options,
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
echo html::script('media/js/jquery.dialog.js');
?>
<div id="dialog">
    <div id="dialog-header">
        <h4>Tytuł dialogu</h4>
        <a href="#"><?php echo html::image('media/img/x_btn.png') ?></a>
    </div>
    <div id="dialog-content">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse lacus nibh, semper non sollicitudin at, adipiscing id risus. Phasellus cursus purus vitae orci aliquam vestibulum. Maecenas id nibh at est fermentum tempus. Cras vel ante neque. Vivamus est dolor, varius vitae elementum vel, venenatis in ipsum. Vivamus eleifend placerat egestas. Maecenas luctus malesuada vehicula. Vivamus a lectus felis, eget elementum nisi. Donec nisl velit, ornare vel auctor molestie, condimentum  at diam. Phasellus interdum elit mattis quam rutrum viverra. Maecenas consectetur przykładowy obrazek  interdum mi sit amet blandit. Vestibulum orci arcu, semper ac mattis et, tristique vel nisl. Fusce nec ornare neque. Aenean lobortis felis eu lacus egestas laoreet. Pellentesque pretium vulputate neque nec condimentum. Nullam gravida eros in justo sollicitudin lacinia. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Proin ultricies nisl non justo viverra eu condimentum enim feugiat. 
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('.page-list-caller').each(function() {
            $(this).dialog();
        })
    })
</script>
