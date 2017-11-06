
<?php

$menus = $params['menus'];

$form = new DepartmentForm();
$contents = $form->getDepartmentForm();

include PATH_TEMPLATE . '/admin/master.php';
