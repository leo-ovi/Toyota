
<?php

$menus = $params['menus'];

$form = new UserForm();
$form->setObj( User::get( $params['id'] ) );
$contents = $form->getUserForm();

include PATH_TEMPLATE . '/admin/master.php';
