<p style="padding: 1em 0 0 2em"><?php echo req ?> pola wymagane</p>
<?php    
    echo form::open('admin/settings/save');
    echo '<div id="column1">';
    echo form::fieldset('Nagłówek', array('id' => 'site-title'));
    echo form::cluetip('title', 'Nazwa strony może składać się z maksymalnie 50 znaków.');
    echo form::text_w_label('title', 'Nazwa strony'.req, html::decode_chars($settings->title));
    echo form::error($errors['title']);
    echo form::help('title', 'Nazwa strony wyświetlana jest w graficznym nagłówku każdej strony.
                                    Nie jest tym samym co tytuł strony....');
    echo form::cluetip('subtitle', 'Opis strony może składać się z maksymalnie 50 znaków.');
    echo form::text_w_label('subtitle', 'Opis strony', html::decode_chars($settings->subtitle));
    echo form::error($errors['subtitle']);
    echo form::help('subtitle', 'Opis strony powinienen zawierać krótki opis zawartości strony.
                                    Zwykle znajduje się poniżej nazwy strony, wyświetlany mniejszą czcionką, 
                                    poniżej nazwy strony, w zależności od ustawionego szablonu');
    echo form::text_w_label('author', 'Autor strony', html::decode_chars($settings->author));
    echo form::close_fieldset();

    echo form::fieldset('Meta dane', array('id' => 'site-meta'));
    echo form::cluetip('keywords-tip', 'Słowa kluczowe to maksymalnie 255 znaków. Rozdziel poszczególne frazy przecinkiem.');
    echo form::text_w_label('keywords', 'Słowa kluczowe', html::decode_chars($settings->keywords));
    echo form::error($errors['keywords']);
    echo form::help('keywords-help', 'Treść pomocy dla słów kluczowych');
    echo form::cluetip('description-tip', 'Treść podpowiedzi dla opisu stron');
    echo form::tarea_w_label('description-help', 'Opis stron', html::decode_chars($settings->description));
    echo form::error($errors['description']);
    echo form::help('description-help', 'Treść panelu pomocy dla opisu stron');
    echo form::close_fieldset();
    echo '</div>';
    echo '<div id="column2">';
    echo form::fieldset('Wygląd', array('id' => 'site-template'));
    foreach($templates as $tpl) {
        $tpls[$tpl->id] = $tpl->name;
    }
    echo '<div class="input-wrap">';
    echo form::label('template_id', 'Wybierz szablon');
    echo form::select('template_id', $tpls, $settings->template_id, array('id' => 'template_id'));
    echo '</div>';
    echo html::anchor(set_controller('templates', 'add'), 'Dodaj nowy', array('id' => 'add-anchor'));
    echo html::anchor(set_controller('templates', 'preview'), 'Podglądnij', array('id' => 'preview-anchor'));
    echo form::check_w_label('header_on', 'Nagłówek', $settings->header_on);
    echo form::check_w_label('footer_on', 'Stopka', $settings->footer_on);
    echo '<div class="input-wrap">';
    echo form::label('sidebar_on', 'Kolumna boczna');
    echo form::select('sidebar_on', array(1 => 'Lewa', 2 => 'Prawa', 0 => 'Brak') , $settings->sidebar_on, array('id' => 'sidebar_on'));
    echo '</div>';
    echo form::close_fieldset();

    echo '<div class="submit">';
    echo form::submit('settings-submit', 'Zapisz ustawienia');
    echo form::input('reset', 'Przywróć', array('type' => 'reset'));
    echo html::anchor('', 'Wyczyść' , array('class' => 'reset'));
    echo '</div>';
    echo '</div>';
    echo form::close();

?>