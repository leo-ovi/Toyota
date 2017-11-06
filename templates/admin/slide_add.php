
<?php

$menus = $params['menus'];

$form = new SlideForm();
$contents = $form->getSlideForm();

include PATH_TEMPLATE . '/admin/master.php';
