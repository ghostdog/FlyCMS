<?php defined('SYSPATH') or die('No direct script access'); ?>
<p><?php echo req ?> pola wymagane</p>
<p><em><?php echo misc::print_if($msg); ?></em></p>
<?php
    echo form::open('admin/templates/add', array('enctype' => 'multipart/form-data'));
    echo form::fieldset('Dodaj Szablon');
    echo form::cluetip('name', 'Treść podpowiedzi dla nazwy szablonu');
    echo form::text_w_label('name', 'Nazwa szablonu*', $template['name']);
    echo form::error($errors['name']);
    echo '<div class="input-wrap">';
    echo form::label('file', 'Umieść pliki szablonu na serwerze, jeśli nie użyłeś klienta FTP.');
    echo form::file('file');
    echo '</div>';
    echo form::cluetip('description', 'Treść podpowiedzi');
    echo form::tarea_w_label('description', 'Opis szablonu', $template['description']);
    echo form::error($errors['description']);
    echo form::submit('template_submit', 'Dodaj Szablon');
    echo form::close();
?>