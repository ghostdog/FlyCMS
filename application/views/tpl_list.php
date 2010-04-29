<?php defined('SYSPATH') or die('No direct script access'); ?>
<h2>Dostępne szablony</h2>
<ul id="templates">
<?php

foreach($templates as $tpl): ?>
    <li>
        <dl>
            <dt><?php echo $tpl->name ?>, dodano: <span><?php echo $tpl->created; if ($tpl->is_global) echo ' (aktywny)' ?></span></dt>
            <dd>
                <?php if ($tpl->has_img) {
                       echo get_tpl_img($tpl->name);
                } else echo 'Brak obrazka' ?>
                <div>
                    <?php
                        $id = $tpl->id;
                        echo html::anchor(set_controller('templates', 'preview', $id), 'Podglądnij');
                        echo html::anchor(set_controller('templates', 'remove', $id), 'Usuń');
                        echo html::anchor(set_controller('templates', 'global', $id), 'Ustaw jako szablon globalny');
                    ?>
                </div>
            </dd>
        </dl>
    </li>
<?php endforeach ?>
</ul>