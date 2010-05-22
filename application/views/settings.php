<p style="padding: 1em 0 0 2em"><?php echo req ?> pola wymagane</p>
<?php    
    echo form::open('admin/settings/save', array('id' => 'settings_frm'));
    echo '<div id="column1">';
    echo form::fieldset('Nagłówek', array('id' => 'site-title'));
    echo form::text_w_label('title', 'Nazwa'.req, html::chars($settings->title));
    echo form::error($errors['title']);
    echo form::help('title', 'Nazwa strony wyświetlana jest w graficznym nagłówku każdej strony.
                                    Nie jest tym samym co tytuł strony....');
    echo form::text_w_label('subtitle', 'Podpis', html::chars($settings->subtitle));
    echo form::error($errors['subtitle']);
    echo form::help('subtitle', 'Opis strony powinienen zawierać krótki opis zawartości strony.
                                    Zwykle znajduje się poniżej nazwy strony, wyświetlany mniejszą czcionką, 
                                    poniżej nazwy strony, w zależności od ustawionego szablonu');
    echo form::text_w_label('author', 'Autor strony', html::chars($settings->author));
    echo form::close_fieldset();

    echo form::fieldset('Meta dane', array('id' => 'site-meta'));
    echo form::text_w_label('keywords', 'Słowa kluczowe', html::chars($settings->keywords));
    echo form::error($errors['keywords']);
    echo form::cluetip('keywords', 'Rozdziel poszczególne frazy przecinkiem.');
    echo form::help('keywords', 'Treść pomocy dla słów kluczowych');
    echo form::tarea_w_label('description', 'Opis stron', html::chars($settings->description));
    echo form::error($errors['description']);
    echo form::help('description-help', 'Treść panelu pomocy dla opisu stron');
    echo form::close_fieldset();
    echo '<div class="submit">';
    echo form::submit('settings-submit', 'Zapisz ustawienia');
    echo form::input('reset', 'Przywróć', array('type' => 'reset'));
    echo html::anchor('', 'Wyczyść' , array('class' => 'reset'));
    echo '</div>';
    echo '</div>';
    echo '<div id="column2">';
    echo form::fieldset('Wygląd', array('id' => 'site-theme'));
    foreach($themes as $theme) {
        $themes_options[$theme->id] = $theme->name;
    }
    echo '<div class="input-wrap">';
    echo form::label('theme_id', 'Wybierz szablon'.req);
    echo form::select('theme_id', $themes_options, $settings->theme_id, array('id' => 'theme_id'));
    echo '</div>';
    echo html::anchor(set_controller('themes', 'add'), 'Dodaj nowy', array('id' => 'add-anchor'));
    echo html::anchor(set_controller('themes', 'preview'), 'Podglądnij', array('id' => 'preview-anchor'));
    echo form::check_w_label('header_on', 'Nagłówek', $settings->header_on);
    echo form::check_w_label('footer_on', 'Stopka', $settings->footer_on);
    echo '<div class="input-wrap">';
    echo form::label('sidebar_on', 'Kolumna boczna');
    echo form::select('sidebar_on', array(1 => 'Lewa', 2 => 'Prawa', 0 => 'Brak') , $settings->sidebar_on, array('id' => 'sidebar_on'));
    echo '</div>';
    echo form::close_fieldset();
    echo form::close();
    echo form::fieldset('Zmiana nazwy użytkownika i hasła', array('id' => 'user-frm'));
    echo form::open('admin/change');
    echo form::text_w_label('username', 'Nazwa użytkownika', $user['username']);
    echo form::error($errors['username']);
    echo form::pass_w_label('old_pass', 'Wprowadź poprzednie hasło');
    echo form::error($errors['old_pass']);
    echo form::pass_w_label('pass1', 'Wprowadź nowe hasło');
    echo form::error($errors['pass1']);
    echo form::pass_w_label('pass2', 'Wprowadź ponownie nowe hasło');
    echo form::error($errors['pass2']);
    echo form::submit('change', 'Zmień dane użytkownika', array('style' => 'width: 15em; float: right'));
    echo form::close();
    echo form::close_fieldset();
    echo '</div>';
?>
<script type="text/javascript">
$(document).ready(function(){
     $('#title').counter({maxLength : 50});
     $('#subtitle').counter({maxLength : 50});
     $('#author').counter({maxLength : 50});
     $('#keywords').counter({maxLength : 255});
     $('#description').counter({maxLength : 255});
     $('#username').counter({maxLength : 25});
})
</script>