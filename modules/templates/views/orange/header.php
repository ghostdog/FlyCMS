<?php
    defined('SYSPATH') or die('No direct script access');
    $site_name = preg_split('/[\s,]+/', $title, 2);
?>
<div id="header">
    <h1><span style="color: #ff9400; font-style:italic; "><?php echo html::chars($site_name[0]) ?> </span><?php echo $site_name[1] ?><span id="desc"><?php echo html::chars($subtitle) ?></span></h1>
    <?php
          $count = $menus->count();
          $active_link = Request::instance()->param('id');
          fire::log($active_link, 'active_link');
          $i = 0;
          if ($count) {
          foreach($menus as $menu) :
    ?>
        <ul>
            <?php 
                $menuitems = $menu->menuitems->find_all();
                foreach($menuitems as $item) : ?>
                <li>
                    <?php
                       $attr = array();
                       if ($i == 0) {
                           $attr['id'] = 'first_item';
                       }
                       if ($i == $count - 1) {
                           $attr['id'] = 'last_item';
                       }
                       if ($active_link == $item->link) {
                           $attr['class'] = 'active';
                       }
                       $i++;
                       if ((int) $item->type == 0) {
                       echo html::anchor(Route::get('page')->uri(array('id' => $item->link)), $item->name, $attr);
                       } else {
                           echo html::anchor($item->link);
                       }
                    ?>
                </li>
             <?php endforeach ?>
        </ul>
    <?php endforeach; } ?>
</div>
