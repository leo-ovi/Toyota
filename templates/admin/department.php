
<?php

$menus = $params['menus'];

$listPage = new ListPage(
  'Department',
  '/admin/departments',
  [
    'ชื่อ',
    'แผนกหลัก'
  ],
  [
    'name',
    'sub:sub'
  ],
  [
    'name',
    'sub'
  ]
);

$contents = $listPage->getListPage("<i class='fa fa-location-arrow' aria-hidden='true'></i> จัดการแผนก");

include PATH_TEMPLATE . '/admin/master.php'; ?>
