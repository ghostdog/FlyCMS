<?php defined('SYSPATH') or die('No direct script access');
return array(
        'name' => array(
            'min_length' => 'Minimalna długość nazwy odnośnika to :param1 znaków.',
            'max_length' => 'Maksymalna długość nazwy odnośnika to :param1 znaków.',
            'not_empty' => 'Musisz podać nazwę dla tego odnośnika.',
        ),
        'link' => array(
            'min_length' => 'Minimalna długość adresu docelowego to :param1 znaków.',
            'max_length' => 'Maksymalna długość nazwy adresu docelowego to :param1 znaków.',
            'not_empty' => 'Musisz poodać adres docelowy dla tego odnośnika.',
        ),
        'title' => array(
            'max_length' => 'Maksymalna długość atrybutu "title" to :param1 znaków.',
        ),


)
?>