<?php include PATH_PARTIAL . '/header.php'; ?>

<div class="container--fluid">
  <div class="container--admin">
    <div class="col-md-2 col-sm-3 col-xs-4 left">
      <?php if(isset($menus)): ?>
        <h3 class="text-center"><?=$menus['title']?></h3>
        <hr>
        <div class="list-group">
          <?php foreach( $menus['list'] as $list ) { ?>
            <a href="<?=$list['url']?>" class="list-group-item <?=isActive($list['url'])?>">
              <?=$list['name']?>
            </a>
          <?php } ?>
        </div>
      <?php endif; ?>
      <div class="clear"></div>
      <h3 class="text-center">ตัวเลือกการจัดการ</h3>
      <hr>
      <div class="list-group">
        <a href="/admin/slides" class="list-group-item <?=isActive('/admin/slides')?>">สไลด์</a>
        <a href="/admin" class="list-group-item <?=isActive('/admin')?>">
          สมาชิก
        </a>
        <a href="/admin/departments" class="list-group-item <?=isActive('/admin/departments')?>">แผนก</a>
        <a href="/admin/progresses" class="list-group-item <?=isActive('/admin/progresses')?>">ขั้นตอนปฏิบัติ</a>
      </div>
    </div>
    <div class="col-md-10 col-sm-9 col-xs-8 right">
      <?=$contents?>
    </div>
  </div>
</div>

<?php include PATH_PARTIAL . '/footer.php'; ?>
