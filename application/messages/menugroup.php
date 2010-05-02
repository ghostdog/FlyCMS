<?php defined('SYSPATH') or die('No direct script access');
return array(
        'name' => array(
            'min_length' => 'Minimalna długość nazwy grupy odnośników to :param1 znaków.',
            'max_length' => 'Maksymalna długość nazwy grupy odnośników to :param1 znaków.',
            'not_empty' => 'Musisz poodać nazwę dla grupy odnośników.',
            'unique' => 'Istnieje już grupa z taką nazwą. Musisz podać inną.'
        ),
        'location' => array(
            'range' => 'Podanie lokalizacji grupy jest wymagane.',
        ),
        'is_global' => array(
            'range' => 'Przekazano nie prawidłową wartość określającą status grupy.',
        ),
        'order' => array(
            'digit' => 'Przekazano nie prawidłową wartość pierwszeństwa grupy.',
        )
)
?>