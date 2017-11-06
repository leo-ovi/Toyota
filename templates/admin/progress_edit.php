
<?php

$menus = $params['menus'];

$form = new ProgressForm();
$form->setObj( Progress::get( $params['id'] ) );
$contents = $form->getProgressForm();

include PATH_TEMPLATE . '/admin/master.php';
