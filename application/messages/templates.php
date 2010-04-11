<?php defined('SYSPATH') or die('No direct script access');

return array(

        'name' => array(
            'min_length' => 'Minimalna długość nazwy szablonu to :param1 znaki',
            'max_length' => 'Maksymalna długość nazwy szablonu to :param1 znaki',
            'not_empty' => 'Musisz podać nazwę szablonu.',
            'alpha_dash' => 'Nazwa szablonu może składać się z liter, cyfr, znaku podkreślnika i myślnika, bez białych znaków',
            'unique' => 'Istnieje już szablon z taką nazwą. Musisz podać inną.',
        ),

        'file' => array(
            'Upload::not_empty' => 'Musisz wybrać plik do wysłania.',
            'Upload::valid' => 'Upload pliku zakończony niepowodzeniem.',
            'Upload::type' => 'Niepoprawne rozszerzenie przekazanego pliku. Dopuszczalne rozszerzenia to: :param1',
            'invalid' => 'Brak wymaganych plików szablonu',
        ),
)


?>
