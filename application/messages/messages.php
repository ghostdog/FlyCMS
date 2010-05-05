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
        'menugroups' => array(
            'fail' => array(
                'add' => 'Próba dodania grupy odnośników nie powiodła się.',
                'edit' => 'Próba edycji grupy odnośników nie powiodła się.',
                'delete' => 'Próba usunięcia grupy odnośników nie powiodła się.',
            ),
            'success' => array(
                'add' => 'Grupa odnośników dodana z powodzeniem.',
                'edit' => 'Grupa odnośników edytowana z powodzeniem.',
                'delete' => 'Usunięcie grupy odnośników powiodło się.'
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
               'delete' => 'Nie udało się usunąć wybranych stron(y).',
               'main_page' => 'Nie możesz usunąć strony głównej. Musisz najpierw określić inną jako główną.',

            ),
            'success' => array(
               'add' => 'Strona zapisana z powodzeniem.',
               'edit' => 'Strona edytowana z powodzeniem.',
               'delete' => 'Strona(y) usunięte z powodzeniem.',
            ),
        ),
    )

?>
