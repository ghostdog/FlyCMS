<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of myfoo
 *
 * @author Marek
 */
//include 'myinterface.php';

class Examples_MyLove implements Examples_MyInterface {

    public function show_love() {
        return 'Show some love to Kohana people!';
    }
}
?>
