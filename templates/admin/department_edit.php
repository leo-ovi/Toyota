
<?php

$menus = $params['menus'];

$form = new DepartmentForm();
$form->setObj( Department::get( $params['id'] ) );
$contents = $form->getDepartmentForm();

include PATH_TEMPLATE . '/admin/master.php';
