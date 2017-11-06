
<?php

$menus = $params['menus'];

$listPage = new ListPage(
  'Slide',
  '/admin/slides',
  [
    'ชื่อ',
    'รายละเอียด',
    'รูป',
    'เมื่อ'
  ],
  [
    'title',
    'description',
    'image:image',
    'create_date'
  ],
  [
    'title',
    'description'
  ]
);

$contents = $listPage->getListPage("<i class='fa fa-slideshare' aria-hidden='true'></i> จัดการสไลด์");

include PATH_TEMPLATE . '/admin/master.php'; ?>
