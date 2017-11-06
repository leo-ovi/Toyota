<div class="header--nav">
  <ul class="breadcrumb-new">
    <li class="li <?=isActive('/')?>">
      <a href="/"><i class="fa fa-home" aria-hidden="true"></i> หน้าแรก</a>
    </li>
    <li class="li dropdown-new-toggle">
      <a href="#"><i class="fa fa-list-alt" aria-hidden="true"></i> ขั้นตอนปฏิบัติ <i class="fa fa-caret-down" aria-hidden="true"></i></a>
      <ul class="dropdown-new-menu">
        <?php foreach (Department::getList() as $department) {
          if($department['sub'] < 1) {
        ?>
          <li>
            <?=$department['name']?>
            <ul>
              <?php foreach (Department::getSubList($department['department_id']) as $sub) { ?>
                <li><a href="/d/<?=$sub['department_id']?>"><?=$sub['name']?></a></li>
              <?php } ?>
            </ul>
          </li>
        <?php
            }
          }
        ?>
      </ul>
    </li>
    <?php if(isset($GLOBALS['user'])): ?>
      <?php if($GLOBALS['user']['position'] === 'ผู้ดูแลระบบ'): ?>
        <li class="li dropdown-new-toggle">
          <a href="/admin"><i class="fa fa-tachometer" aria-hidden="true"></i> จัดการระบบ</a>
          <ul class="dropdown-new-menu">
            <li><a href="/admin/slides">สไลด์</a></li>
            <li><a href="/admin">สมาชิก</a></li>
            <li><a href="/admin/departments">แผนก</a></li>
            <li><a href="/admin/progresses">ขั้นตอนปฏิบัติ</a></li>
          </ul>
        </li>
      <?php endif; ?>
      <li class="li dropdown-new-toggle">
        <a href="#">ยินดีต้อนรับ, <strong><?=$GLOBALS['user']['fullname']?></strong></a>
        <ul class="dropdown-new-menu">
          <li><a href="/logout">ออกจากระบบ</a></li>
        </ul>
      </li>
    <?php else: ?>
      <li class="li"><a href="/login"><i class="fa fa-sign-in" aria-hidden="true"></i> เข้าสู่ระบบ</a></li>
    <?php endif; ?>
  </ul>
  <div class="clear"></div>
</div>
