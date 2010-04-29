<?php defined('SYSPATH') or die('No direct access allowed');

    return array(

        'templates' => array(
            'fail' => array(
                'add' => 'Próba dodania szablony nie powiodła się.',
                'edit' => 'Próba edycji szablonu nie powiodła się.',
                'delete' => 'Próba usunięcia nie powiodła się. Możliwa przyczyna: dostępny jest tylko jeden szablon.',
                'global' => 'Próba ustawienia szablonu jako globalnego nie powiodła się.',
            ),
            'success' => array(
                'add' => 'Szablon zapisany z powodzeniem.',
                'edit' => 'Szablon edytowany z powodzeniem.',
                'delete' => 'Szablon usunięty z powodzeniem.',
                'global' => 'Szablon został ustawiony jako globalny',
            )
        ),

        'settings' => array(
            'fail' => array(
               'save' => 'Próba zapisania ustawień nie powiodła się',
            ),
            'success' => array(
                'save' => 'Ustawienia zapisane z powodzeniem.',
            )
        ),

        'pages' => array(
            'fail' => array(
               'add' => 'Próba zapisania strony nie powiodła się.',
               'edit' => 'Próba edycji strony nie powiodła się.',
               'delete' => 'Próba usunięcia strony nie powiodła się.',
               'group_delete' => 'Nie udało się usunąć wybranych stron.'
            ),
            'success' => array(
               'add' => 'Strona zapisana z powodzeniem.',
               'edit' => 'Strona edytowana z powodzeniem.',
               'delete' => 'Strona usunięta z powodzeniem.',
               'group_delete' => ':param strony zostały usunięte.',
            ),
        ),
    )

?>
