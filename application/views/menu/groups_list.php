<?php defined('SYSPATH') or die('No direct script access'); 
foreach($groups as $group) :
?>
<tr>
    <td class="name">
        <?php
            echo $group->name;
        ?>
        <div>
            <?php
                 echo html::anchor('/admin/menus/edit/'.$group->id, 'Edytuj');
                 echo html::anchor('/admin/menus/remove/'.$group->id, 'Usuń', array('class' => 'delete'));
             ?>
        </div>
    </td>
    <td><?php
            switch($group->location) {
                case 0 : echo 'Nagłówek';
                         break;
                case 1 : echo 'Kolumna boczna';
                         break;
                case 2 : echo 'Zawartość strony';
                         break;
            }
         ?>
    </td>
    <td><?php echo ($group->is_global) ? 'Tak' : 'Liczba stron zawierających grupę: '.$group->pages->count_all() ?></td>
    <td><?php echo $group->ord ?></td>
    <td><?php echo $group->menuitems->count_all() ?></td>
</tr>
<?php endforeach; ?>

