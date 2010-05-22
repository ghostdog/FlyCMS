<?php defined('SYSPATH') or die('No direct access allowed');

    return array(

        'themes' => array(
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
        'menus' => array(
            'fail' => array(
                'add' => 'Próba dodania elementów nawigacji nie powiodła się.',
                'edit' => 'Próba edycji elementów nawigacji nie powiodła się.',
                'delete' => 'Próba usunięcia elementów nawigacji nie powiodła się.',
                'delete_item' => 'Próba usunięcia odnośnika nie powiodła się',
            ),
            'success' => array(
                'add' => 'Elementy nawigacji dodane z powodzeniem.',
                'edit' => 'Elementy nawigacji edytowane z powodzeniem.',
                'delete_item' => 'Odnośnik usunięty z powodzeniem.'
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
               'last_page' => ' W systemie musi pozostać co najmniej jedna strona.',
            ),
            'success' => array(
               'add' => 'Strona zapisana z powodzeniem.',
               'edit' => 'Strona edytowana z powodzeniem.',
               'delete' => 'Strona(y) usunięte z powodzeniem.',
            ),
        ),

        'auth' => array(
            'fail' => array(
               'login' => 'Niepoprawne hasło lub nazwa użytkownika.',
               'change' => 'Próba edycji danych nie powiodła się.',
            ),
            'success' => array(
               'change' => 'Ustawienia zmienione z powodzeniem.',
            ),
        ),
    )

?>
