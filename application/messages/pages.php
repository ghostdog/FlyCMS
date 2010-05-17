<?php defined('SYSPATH') or die('No direct script access');

return array(

        'title' => array(
            'unique' => 'Istnieje już strona z takim tytułem. Musisz podać inny tytuł.',
            'min_length' => 'Minimalna długość tytułu strony to :param1 znaków',
            'max_length' => 'Maksymalna długość nazwy szablonu to :param1 znaków',
            'not_empty' => 'Podanie tytułu strony jest obowiązkowe.',
        ),
        'keywords' => array(
            'max_length' => 'Maksymalna długość słów kluczowych to :param1 znaków',

        ),
        'description' => array(
            'max_length' => 'Maksymalna długość słów kluczowych to :param1 znaków',
        ),
        'author' => array(
            'max_length' => 'Maksymalna długość nazwy autora to :param1',
        ),

)


?>
