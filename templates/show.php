<?php include PATH_PARTIAL . '/header.php'; ?>

<div class="container marginTop">
  <div class="page-header">
    <h1><?=$params['progress']['title']?> <small><?=$params['progress']['department_name']?></small></h1>
    <?php if(!empty($params['progress']['file_path'])): ?>
      <a href="/uploads/<?=$params['progress']['file_path']?>">DOWNLOAD</a>
    <?php endif; ?>
  </div>
  <div class="panel panel-default">
    <div class="panel-body">
      <?=$params['progress']['content']?>
    </div>
  </div>
  <?php $images = Image::getImagesByProgress($params['progress']['id']);?>
  <?php while( $image = array_pop($images)): ?>
    <img src="/uploads/<?=$image['name']?>" width="100%" alt="">
    <br><br>
  <?php endwhile; ?>
</div>

<?php include PATH_PARTIAL . '/footer.php'; ?>
