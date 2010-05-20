<?php defined('SYSPATH') or die('No direct script access'); 
    $options = array('-1' => 'Użyj ustawień globalnych', '0' => 'Wyłącz', '1' => 'Włącz');
    $sidebar_options = array('-1' => 'Użyj ustawień globalnych', '1' => 'Lewa', '2' => 'Prawa', '0' => 'Brak');
    $themes_options['-1'] = 'Użyj szablonu globalnego';
    foreach ($themes as $theme) {
        $themes_options[$theme->id] = $theme->name;
    }
    
    echo form::open('admin/pages/'.$action);
    (Request::instance()->action == 'edit') ?
                    create_link('Usuń', 'pages', 'delete', $page->id, array('class' => 'delete remove')) : '';
    echo form::submit('submit1', 'Zapisz stronę', array('style' => 'float: right'));
    echo form::fieldset('Zawartość', array('id' => 'title-and-content'));
    //echo form::cluetip('title', 'Treść podpowiedzi dla tytułu strony');

    echo form::text_w_label('page[title]', 'Tytuł strony'.req, html::chars($page->title));
    echo form::error($errors['title']);
    echo form::help('title', 'Treść panelu pomocy dla tytułu');
?>
<div class="input-wrap-label-right" style="width: 16.5em; margin-left: 1em">
<?php
    echo form::label('is_main', 'Ustaw stronę jako główną');
    echo form::checkbox('page[is_main]',1, ($page->is_main) ? TRUE : FALSE, array('id' => 'is_main'));
?>
</div>
<div id="quantity-chooser" style="float:right; width:40%; margin-top: 4em">
    <h3 style="margin-top: .5em">Zmień liczbą sekcji na:</h3>
<?php
    for ($i = 0; $i < 10;) {
        $values[++$i] = $i ;
    }
    echo form::select('sections_quantity', $values, form::value('sections_quantity'),
                       array('id' => 'sections-quantity-chooser',
                           'style' => 'margin-left: 1em;
                                      width: 10em;
                      '));

    echo form::submit('quantity_submit','Odśwież', array('style' => 'margin-left: 1em; width: 5em', 'id' => 'quantity-submit'));
?>
    <span id="refresh-msg"></span>
</div>
<ul id="sections-list" style="float: left; clear: left">
    <?php
        $i = 0;
        foreach($sections as $section) : 
     ?>
    <li>
        <?php
            $i += 1;
            $section_order = (empty($section->ord)) ? ' [<span class="ord" title="Kolejność">0</span>]' : ' [<span class="ord" title="Kolejność">'.$section->ord.'</span>]';
            $name = (empty($section->name)) ? '<span class="name">Sekcja '.$i.'</span> ': '<span class="name">'.$section->name.'</span>';
            $error_mark = (isset($sections_errors[$i])) ? ' <strong style="color:red; text-decoration: underline">Błąd!</strong>' : '';
            echo html::anchor('#section'.$i, $name.$section_order.$error_mark);
        ?>
    </li>
    <?php endforeach ?>
</ul>
<?php
    echo View::factory('section', array('sections' => $sections, 'i' => 0,'action' => $action, 'errors' => (isset($sections_errors)) ? $sections_errors : array()));

    echo form::close_fieldset();

    echo form::fieldset('Meta dane', array('id' => 'metas'));
    echo form::check_w_label('set_keywords', 'Ustaw słowa kluczowe dla tej strony');
   // echo form::cluetip('keywords', 'Treść podpowiedzi dla słów kluczowych');
    echo form::text_w_label('page[keywords]', 'Słowa kluczowe', html::chars($page->keywords), array('class' => 'optional'));
    echo form::error($errors['keywords']);
    echo form::help('keywords', 'Treść panelu pomocy dla słów kluczowych');
    echo form::check_w_label('set_description', 'Ustaw opis dla tej strony');
   // echo form::cluetip('description', 'Treść panelu pomocy dla słów kluczowych');
    echo form::tarea_w_label('page[description]', 'Opis strony', html::chars($page->description), array('class' => 'optional'));
    echo form::error($errors['keywords']);
    echo form::help('description', 'Treść panelu pomocy dla słów kluczowych');
    echo form::close_fieldset();

    echo form::fieldset('Wygląd', array('id' => 'appearence', 'style' => 'padding-bottom: 3.7em'));
    echo form::select_w_label('page[theme_id]', 'Wybierz szablon', $page->theme_id, $themes_options);
    echo form::select_w_label('page[header_on]', 'Nagłówek', (is_null($page->header_on)) ? '-1' : $page->header_on , $options);
    echo form::select_w_label('page[footer_on]', 'Stopka', (is_null($page->footer_on)) ? '-1' : $page->footer_on, $options);
    echo form::select_w_label('page[sidebar_on]', 'Kolumna boczna', (is_null($page->sidebar_on)) ? '-1' : $page->sidebar_on, $sidebar_options);
    echo form::close_fieldset(); ?>
<div style="float: right">
<?php echo form::submit('submit2', 'Zapisz stronę'); ?>
</div>
<?php
    echo form::close();
    echo html::script('media/js/jquery.c-dialog.js');
    echo html::script('media/js/tiny/jquery.tinymce.js');
?>
<script type="text/javascript">
function makeTabs() {
    var tabContainers = $('fieldset[id^=section]').hide();
    $('#sections-list a').click(function () {
        tabContainers.hide().filter(this.hash).show();
        $('#sections-list a').removeClass('selected');
        $(this).addClass('selected');
        return false;
    });
    $('#sections-list a').filter(':first').trigger('click');
}

function changeTabs(reqSize) {
        var itemsSize = $('fieldset[id^=section]').length,
        changeSize = 0,
        msgOutput = $('#refresh-msg'),
        requestSize = reqSize;

        if (requestSize == itemsSize) {

        } else if (requestSize > itemsSize) {
            changeSize = requestSize - itemsSize;
            var nextId = itemsSize;
            msgOutput.text('Odświeżanie...');
            $.ajax({
                dataType : 'html',
                data : 'add_sz='+changeSize+'&next_id='+nextId,
                url : '/kohana/admin/pages/ajax_sections_refresh',
                error : function(err, xhr, status) {
                    msgOutput.text('Błąd');
                },
                success : function(data, xhr, textStatus) {
                    msgOutput.text('');

                    $('#sections-wrap').append(data);

                    for (i = 0; i < changeSize; i++) {
                        nextId += 1;
                        $('#sections-list').append($('<li/>')
                                        .append(
                                        $('<a/>')
                                          .attr('href', '#section'+nextId)
                                          .append(
                                            $('<span/>').addClass('name').text('Sekcja '+nextId)
                                          )
                                          .append(' [<span class="ord">0</span>]')
                                       )
                                    )
                    }
                    makeTabs();
                    $('#sections-list a').filter(':first').click();

                }
            });

        } else if (requestSize < itemsSize) {
            changeSize = itemsSize - requestSize;
            removeSectionTabs(changeSize);
        }
}
function removeSectionTabs(quantity) {
    var items = $('fieldset[id^=section]'),
        tabs = $('#sections-list li'),
        idx = items.length - 1;
    while (idx > 0) {
       if (quantity > 0) {
           $(items[idx]).remove();
           $(tabs[idx]).remove();
           quantity--;
       }
       idx -= 1;
   }
   makeTabs();
   $('#sections-list a').filter(':first').click();
}
$(document).ready(function() {
    makeTabs();
    $('#quantity-submit').click(function(evt) {
        evt.preventDefault();
        var submit = $(this),
            requestSize = $('#sections-quantity-chooser').val();
            changeTabs(requestSize);
    });
    $('.delete').c_dialog();
    $('#page-content input[type="text"]:first').focus().counter({maxLength: 100});
    $('#set_keywords, #set_description').each(function() {
        var input = $(this),
            target = input.parent().next().find('.optional');
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
//
// $('#content').tinymce({
//			// Location of TinyMCE script
//			script_url : '/kohana/media/js/tiny/tiny_mce.js',
//
//			// General options
//	mode : "textareas",
//	theme : "advanced",
//	plugins : "safari,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,theme",
//
//	// Theme options
//	theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
//	theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
//	theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
//	theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,theme,blockquote,pagebreak,|,insertfile,insertimage",
//	theme_advanced_toolbar_location : "top",
//	theme_advanced_toolbar_align : "left",
//	theme_advanced_statusbar_location : "bottom",
//	theme_advanced_resizing : true,
//
//			// Example content CSS (should be your site CSS)
//			content_css : "css/content.css",
//
//			// Drop lists for link/image/media/theme dialogs
//			theme_external_list_url : "lists/theme_list.js",
//			external_link_list_url : "lists/link_list.js",
//			external_image_list_url : "lists/image_list.js",
//			media_external_list_url : "lists/media_list.js",
//
//			// Replace values for the theme plugin
//			theme_replace_values : {
//				username : "Some User",
//				staffid : "991234"
//			}
//		});
 });

     


  



</script>
