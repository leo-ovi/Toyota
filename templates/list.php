<?php include PATH_PARTIAL . '/header.php'; ?>

<?php $keyword = (isset($_GET['search'])) ? $_GET['search']: ''; ?>

<div class="container marginTop">
  <div class="col-xs-8 col-xs-offset-2">
    <h3 class="text-center">
      ขั้นตอนการปฏิบัติ : <?=$params['department']['department_name']?>
      <span class="label label-primary"><?=Progress::size(' WHERE department_id='. $params['department']['department_id'] .' ')['size']?></span>
    </h3>
    <form action="#" method="get">
      <div class="form-group">
        <input type="text" class="form-control" name="search" id="forTitle" placeholder="คำค้น" value="">
      </div>
      <button type="submit" style="width: 100%" class="btn btn-default">ค้นหา</button>
    </form>
    <hr>
    <div class="list-group">
      <?php $list = Progress::getList(" WHERE progresses.department_id='". $params['department']['department_id'] ."' "); ?>
      <?php while( $progress = array_pop($list)): ?>
        <?php if(($keyword == '') || (strpos($progress['title'], $keyword) > -1) || strpos($progress['content'], $keyword) > -1): ?>
          <a href="/p/<?=$progress['id']?>" class="list-group-item">
            <!-- <span class="badge">14</span> -->
            <?=$progress['title']?>
          </a>
        <?php endif; ?>
      <?php endwhile; ?>
    </div>
  </div>
</div>

<?php include PATH_PARTIAL . '/footer.php'; ?>
