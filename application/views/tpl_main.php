<?php defined('SYSPATH') or die('No direct script access allowed');

?>
<ul id="tpl-menu">
    <li><?php echo html::anchor('admin/templates/add', 'Nowy szablon') ?></li>
    <li><?php echo html::anchor('admin/templates/', 'Dostępne szablony') ?></li>
</ul>
<div id="tpl-content">   
   <p><em><?php echo misc::print_if($msg); ?></em></p>
   <?php
        echo $tpl_content;
    ?>
</div>