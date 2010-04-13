<?php defined('SYSPATH') or die('No direct script access allowed');

define('IMGS_PATH', 'media/img/tpl_examples/');

function get_tpl_img($tpl_name) {
    $img_file = file::search_img_by_name($tpl_name, IMGS_PATH);
    return html::image(IMGS_PATH.$img_file, array('alt' => 'Miniaturka obrazka szablonu'));
}

?>
<ul id="tpl-menu">
    <li><?php echo html::anchor('admin/templates/add', 'Nowy szablon') ?></li>
    <li><?php echo html::anchor('admin/templates/', 'Dostępne szablony') ?></li>
</ul>
<div id="tpl-content">
    <?php
        echo misc::print_if($msg);
        echo $tpl_content;
    ?>
</div>