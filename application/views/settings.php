<p><?php echo req ?> pola wymagane</p>
<p><em><?php echo misc::print_if($msg); ?></em></p>
<?php
    if (isset($_POST['settings_submit'])) $settings = arr::merge($settings, $_POST);
    
    echo form::open('admin/settings/save');
    echo form::fieldset('Nagłówek');
    echo form::cluetip('title', 'Nazwa strony może składać się z maksymalnie 50 znaków.');
    echo form::text_w_label('title', 'Nazwa strony', $settings['title']);
    echo form::error($errors['title']);
    echo form::help('title', 'Nazwa strony wyświetlana jest w graficznym nagłówku każdej strony.
                                    Nie jest tym samym co tytuł strony....');
    echo form::cluetip('subtitle', 'Opis strony może składać się z maksymalnie 50 znaków.');
    echo form::text_w_label('subtitle', 'Opis strony', $settings['subtitle']);
    echo form::error($errors['subtitle']);
    echo form::help('subtitle', 'Opis strony powinienen zawierać krótki opis zawartości strony.
                                    Zwykle znajduje się poniżej nazwy strony, wyświetlany mniejszą czcionką, 
                                    poniżej nazwy strony, w zależności od ustawionego szablonu');
    echo form::close_fieldset();
    echo form::fieldset('Szablon witryny');
   // echo form::select_w_label('template_id', 'Wybierz szablon', $settings['template_id'], $templates);
?>
   <div id="templates-chooser">
       <em>Wybierz globalny szablon</em>
       <ul>
           <?php foreach ($templates as $tpl): ?>
           <li>
               <?php 
                    echo get_tpl_img($tpl->name);
                    echo html::anchor('admin/templates/preview/'.$tpl->id, 'Podglądnij');
                    echo form::hidden($tpl->name, $tpl->id);
               ?>
           </li>
           <?php endforeach ?>
       </ul>
   </div>
<?php
    echo html::anchor('admin/templates/add', 'Dodaj nowy');

    echo form::close_fieldset();

    echo form::fieldset('Elementy witryny');
    echo form::check_w_label('header_on', 'Nagłówek', $settings['header_on']);
    echo form::check_w_label('footer_on', 'Stopka', $settings['footer_on']);
    echo form::select('column', array(1 => 'Lewa', 2 => 'Prawa', 3 => 'Brak'), $settings['column']);
    echo form::close_fieldset();
    
    echo form::fieldset('Meta dane');
    echo form::cluetip('keywords-tip', 'Słowa kluczowe to maksymalnie 255 znaków. Rozdziel poszczególne frazy przecinkiem.');
    echo form::text_w_label('keywords', 'Słowa kluczowe', $settings['keywords']);
    echo form::error($errors['keywords']);
    echo form::help('keywords-help', 'Treść pomocy dla słów kluczowych');
    echo form::cluetip('description-tip', 'Treść podpowiedzi dla opisu stron');
    echo form::tarea_w_label('description-help', 'Opis stron', $settings['description']);
    echo form::error($errors['description']);
    echo form::help('description-help', 'Treść panelu pomocy dla opisu stron');
    echo form::close_fieldset();
    
    echo form::submit('settings-submit', 'Zapisz ustawienia');
    echo html::anchor('#', 'Wyczyść');
    echo form::close();

?>