
<?php

$menus = $params['menus'];

$form = new ProgressForm();
$contents = $form->getProgressForm();

include PATH_TEMPLATE . '/admin/master.php';
