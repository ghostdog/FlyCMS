<?php defined('SYSPATH') or die('No direct script access allowed'); 
    echo form::open('admin/templates/add', array('enctype' => 'multipart/form-data', 'id' => 'template_frm'));
    echo form::fieldset('Dodaj Szablon');
    //echo form::cluetip('name', 'Treść podpowiedzi dla nazwy szablonu');
    echo form::text_w_label('name', 'Nazwa szablonu'.req, $template->name);
    echo form::error($errors['name']);
    echo '<div class="input-wrap">';
    echo form::label('file', 'Umieść pliki szablonu na serwerze, jeśli nie użyłeś klienta FTP.'
            ,array('style' => 'font-size: 90%'));
    echo form::file('file', array('id' => 'file'));
    echo form::error($errors['file']);
    echo '</div>';
 //   echo form::cluetip('description', 'Treść podpowiedzi');
    echo form::tarea_w_label('description', 'Opis szablonu', html::chars($template->description));
    echo form::error($errors['description']);
    echo form::submit_div('template_submit', 'Dodaj Szablon');
    echo form::close_fieldset();
    echo form::close();
?>
<?php
foreach($templates as $tpl): ?>
        <dl>
            <dt><?php echo $tpl->name; if ($tpl->is_global) echo ' (aktywny)' ?></dt>
            <dd>
                <?php if ($tpl->has_img) {
                       echo get_tpl_img($tpl->name);
                } else echo 'Brak obrazka' ?>
                <div>
                    <?php
                        $id = $tpl->id;
                        create_link(html::image('media/img/preview_icon.png'), 'templates', 'preview', $id, array('title' => 'Podglądnij'));
                        create_link(html::image('media/img/delete_icon.png'), 'templates', 'delete', $id, array('title' => 'Usuń', 'class' => 'delete'));
                        create_link(html::image('media/img/global_icon.png'), 'templates', 'global', $id, array('title' => 'Ustaw jako globalny'));
//                        echo html::anchor(set_controller('templates', 'preview', $id),
//                                   html::image('media/img/preview_icon.png'), array('title' => 'Podglądnij'));
//                        echo html::anchor(set_controller('templates', 'remove', $id),
//                                   html::image('media/img/delete_icon.png'), array('title' => 'Usuń'));
//                        echo html::anchor(set_controller('templates', 'global', $id),
//                                   html::image('media/img/global_icon.png'), array('title' => 'Ustaw jako globalny'));
                    ?>
                </div>
            </dd>
        </dl>
<?php endforeach;
     echo html::script('media/js/jquery.c-dialog.js') ?>
<script type="text/javascript">
    $('.delete').c_dialog();
    $('#name').counter({maxLength : 50});
    $('#description').counter({maxLength : 255});
</script>
