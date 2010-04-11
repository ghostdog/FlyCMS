<?php defined('SYSPATH') or die('No direct script access allowed');?>
<ul id="tpl-menu">
    <li><?php echo html::anchor('admin/templates/add', 'Nowy Szablon') ?></li>
    <li><?php echo html::anchor('admin/templates/', 'Wybierz Szablon') ?></li>
</ul>
<div id="tpl-content">
    <?php echo $tpl_content ?>
</div>