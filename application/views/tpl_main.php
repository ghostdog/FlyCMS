<?php defined('SYSPATH') or die('No direct script access allowed');

?>

<div id="tpl-content">   
   <p><em><?php echo misc::print_if($msg); ?></em></p>
   <?php
        echo $tpl_content;
    ?>
</div>