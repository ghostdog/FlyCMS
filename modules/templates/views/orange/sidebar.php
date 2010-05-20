<?php defined('SYSPATH') or die('No direct script access') ?>
<div id="sidebar">
<?php

    foreach ($menus as $menu) {
        create_links($menu->menuitems);
    }
?>
</div>


