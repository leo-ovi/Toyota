
<?php

$menus = $params['menus'];

$form = new UserForm();
$contents = $form->getUserForm();

include PATH_TEMPLATE . '/admin/master.php';
