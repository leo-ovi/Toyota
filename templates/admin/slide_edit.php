
<?php

$menus = $params['menus'];

$form = new SlideForm();
$form->setObj( Slide::get( $params['id'] ) );
$contents = $form->getSlideForm();

include PATH_TEMPLATE . '/admin/master.php';
