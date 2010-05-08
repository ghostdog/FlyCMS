<?php defined('SYSPATH') or die('No direct script access');
return array(
        'name' => array(
            'min_length' => 'Minimalna długość nazwy grupy odnośników to :param1 znaków.',
            'max_length' => 'Maksymalna długość nazwy grupy odnośników to :param1 znaków.',
            'not_empty' => 'Musisz poodać nazwę dla grupy odnośników.',
            'unique' => 'Istnieje już grupa z taką nazwą. Musisz podać inną.'
        ),
        'location' => array(
            'range' => 'Musisz podać lokalizację grupy',
        ),
        'is_global' => array(
            'range' => 'Przekazano nie prawidłową wartość określającą status grupy.',
            'no_pages' => 'W przypadku grupy <u>nie</u> globalnej, musisz wybrać strony, na których ma się ona znajdować.'
        ),
        'ord' => array(
            'digit' => 'Przekazano nie prawidłową wartość kolejności grupy.',
        ),

)
?>