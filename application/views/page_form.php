<?php defined('SYSPATH') or die('No direct script access'); 
    $options = array('-1' => 'Użyj ustawień globalnych', '0' => 'Wyłącz', '1' => 'Włącz');
    $sidebar_options = array('-1' => 'Użyj ustawień globalnych', '1' => 'Lewa', '2' => 'Prawa', '0' => 'Brak');
    $tpls['-1'] = 'Użyj szablonu globalnego';
    foreach ($templates as $tpl) {
        $tpls[$tpl->id] = $tpl->name;
    }
    
    echo form::open('admin/pages/'.$action);
    (Request::instance()->action == 'edit') ?
                    create_link('Usuń', 'pages', 'delete', $page->id, array('class' => 'delete remove')) : '';
    echo form::submit('submit1', 'Zapisz stronę', array('style' => 'float: right'));
    echo form::fieldset('Zawartość', array('id' => 'title-and-content'));
    //echo form::cluetip('title', 'Treść podpowiedzi dla tytułu strony');
    echo form::text_w_label('title', 'Tytuł strony', html::chars($page->title));
    echo form::error($errors['title']);
    echo form::help('title', 'Treść panelu pomocy dla tytułu');
?>
<div class="input-wrap-label-right" style="width: 16.5em; margin-left: 1em">
<?php
    echo form::label('is_main', 'Ustaw stronę jako główną');
    echo form::checkbox('is_main',1, ($page->is_main) ? TRUE : FALSE, array('id' => 'is_main'));
?>
</div>
<?php
    //echo form::cluetip('content', 'Treść podpowiedzi dla zawartości strony');
    echo form::error($errors['content']);
    echo form::tarea_w_label('content', 'Edytor zawartości', html::chars($page->content));
    echo form::close_fieldset();

    echo form::fieldset('Meta dane', array('id' => 'metas'));
    echo form::check_w_label('set_keywords', 'Ustaw słowa kluczowe dla tej strony');
   // echo form::cluetip('keywords', 'Treść podpowiedzi dla słów kluczowych');
    echo form::text_w_label('keywords', 'Słowa kluczowe', html::chars($page->keywords));
    echo form::error($errors['keywords']);
    echo form::help('keywords', 'Treść panelu pomocy dla słów kluczowych');
    echo form::check_w_label('set_description', 'Ustaw opis dla tej strony');
   // echo form::cluetip('description', 'Treść panelu pomocy dla słów kluczowych');
    echo form::tarea_w_label('description', 'Opis strony', html::chars($page->description));
    echo form::error($errors['keywords']);
    echo form::help('description', 'Treść panelu pomocy dla słów kluczowych');
    echo form::close_fieldset();

    echo form::fieldset('Wygląd', array('id' => 'appearence', 'style' => 'padding-bottom: 3.7em'));
    echo form::select_w_label('template_id', 'Wybierz szablon', $page->template_id, $tpls);
    echo form::select_w_label('header_on', 'Nagłówek', (is_null($page->header_on)) ? '-1' : $page->header_on , $options);
    echo form::select_w_label('footer_on', 'Stopka', (is_null($page->footer_on)) ? '-1' : $page->footer_on, $options);
    echo form::select_w_label('sidebar_on', 'Kolumna boczna', (is_null($page->sidebar_on)) ? '-1' : $page->sidebar_on, $sidebar_options);
    echo form::close_fieldset(); ?>
<div style="float: right">
<?php echo form::submit('submit2', 'Zapisz stronę'); ?>
</div>
<?php
    echo form::close();
    echo html::script('media/js/jquery.c-dialog.js');
?>

<script type="text/javascript">
$(document).ready(function() {
    $('#title').counter({maxLength : 100});
    $('.delete').c_dialog();
    $('#page-content input[type="text"]:first').focus();
    $('#set_keywords, #set_description').each(function() {
        var input = $(this),
            targetId = input.attr('id').replace('set_', ""),
            target = $('#'+targetId);
        target.data('bg', target.css('background'));
        if (target.hasValue()) {
            input.attr('checked', 'checked');
        } else {
           target.attr("disabled", "disabled");
           input.removeAttr('checked');
           target.css('background', '#f1f1f1');
        }
        input.change(
             function() {
                 var invoker = $(this);
                 if (invoker.hasClass("toggleon")) {
                     invoker.removeAttr("checked").removeClass("toggleon");
                       target.attr("disabled", "disabled").css("background", "#f1f1f1")
                  } else {
                     invoker.attr("checked","checked").addClass("toggleon");
                     target.removeAttr("disabled").css('background', target.data('bg')).focus();
                 }
            }
       );
    });
});
</script>
