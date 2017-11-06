<?php include PATH_PARTIAL . '/header.php'; ?>

<?php $slides = Slide::getList(); ?>

<div class="container--home">
  <div class="gallery autoplay items-<?=count($slides)?>">
    <?php for ($i=0; $i<count($slides); $i++) { ?>
      <div id="item-<?=$i?>" class="control-operator"></div>
    <?php } ?>

    <?php for ($i=0; $i<count($slides); $i++) { ?>
      <figure class="item" style="background-image: url(/uploads/<?=$slides[$i]['image']?>);">
        <div class="content">
          <h1><?=$slides[$i]['title']?></h1>
          <p><?=$slides[$i]['description']?></p>
        </div>
      </figure>
    <?php } ?>

    <div class="controls">
      <?php for ($i=0; $i<count($slides); $i++) { ?>
        <a href="#item-<?=$i?>" class="control-button">•</a>
      <?php } ?>
    </div>

  </div>
</div>

<?php include PATH_PARTIAL . '/footer.php'; ?>
