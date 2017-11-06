
<?php

$menus = $params['menus'];

$listPage = new ListPage(
  'User',
  '/admin',
  [
    'รหัสพนักงาน:15%',
    'ชื่อ',
    'ตำแหน่ง',
    'แผนก',
    'ยูเซอร์เนม'
  ],
  [
    'no',
    'fullname',
    'position',
    'department_name',
    'username'
  ],
  [
    'no',
    'fullname',
    'position',
    'username'
  ]
);

$contents = $listPage->getListPage("<i class='fa fa-users' aria-hidden='true'></i> จัดการสมาชิก");

include PATH_TEMPLATE . '/admin/master.php'; ?>
