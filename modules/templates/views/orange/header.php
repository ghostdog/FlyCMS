<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="css/no_cols.css" type="text/css"/>
<title><?php echo $page->title ?></title>
</head>
<body>
<div id="wrap">
<div id="header">

        <h1><?php echo $settings->title ?> <span id="desc"><?php echo $settigs->subtitle ?>s</span></h1>
<!--        <ul>
         <li><a href="" class="active" id="first_item"><span>Strona główna</span></a></li>
         <li><a href=""><span>O nas</span></a></li>
         <li><a href=""><span>Portfolio</span></a></li>
         <li><a href="" id="last_item"><span>Kontakt</span></a></li>
       </ul>

-->
<?php
    foreach ($menus as $menu) {
        create_links($menu->menuitems);
    }
?>
</div>