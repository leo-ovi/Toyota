
<?php

$menus = $params['menus'];

$listPage = new ListPage(
  'Progress',
  '/admin/progresses',
  [
    'หัวข้อ',
    'เนื้อหา',
    'แผนก'
  ],
  [
    'title',
    'content',
    'department_name'
  ],
  [
    'title',
    'content'
  ]
);

$contents = $listPage->getListPage("<i class='fa fa-list-alt' aria-hidden='true'></i> ขั้นตอนการปฏิบัติ");

include PATH_TEMPLATE . '/admin/master.php'; ?>
