<?php defined('SYSPATH') or die('No direct script access');

return array(

        'name' => array(
            'unique' => 'Istnieje już sekcja o takiej nazwie. Musisz podać inną.',
            'min_length' => 'Minimalna długość nazwy sekcji to :param1 znaków',
            'max_length' => 'Maksymalna długość nazwy sekcji to :param1 znaków',
            'not_empty' => 'Podanie nazwy dla każdej sekcji jest obowiązkowe.',
            'validate::standard_text' => 'Nazwa sekcji może składać się z liter, cyfr i białych znaków',
        ),
        'content' => array(
            'not_empty' => 'Zawartość sekcji nie może być pusta',
        ),
)


?>
