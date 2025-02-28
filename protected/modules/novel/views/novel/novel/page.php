<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\modules\novel\models\NovelPage;

?>
<style media="screen">

  .graphic-novel-page{
    position: relative;
  }
  
  .graphic-novel-page img{
    position: absolute; top: 0; width: 100%;
  }
  
  <?php if (!Yii::$app->user->getIdentity()->has_read_novel && Yii::$app->user->getIdentity()->group->name != "Mentors"): ?>
    .topbar, .footer {
      display: none;
    }

    body {
      padding-top: 1em;
    }
  <?php endif; ?>
  
</style>

<div class="container">
<!--   <div class="row justify-content-md-center">
    <div class="col-9 col-md-auto"> -->
      
      <?php if($page->chapter): ?>
        <div class="alchemy">
          <img src="<?php echo Url::to('@web/themes/Evoke/img/alchemy.png') ?>" alt="alchemy" width=50 height=50 />
        </div>
        <b>
          <?php echo Yii::t('NovelModule.base', 'Mission') ?> <?= $page->chapter->mission->position ?>, <?php echo Yii::t('NovelModule.base', 'Chapter') ?> <?= $page->chapter->number ?>
        </b>
      <?php endif; ?>
      


    <div class="graphic-novel-page" style="">

      
        <?php if($page->markup != ""): ?>
          <?= $page->markup ?>
        <?php else: ?>
          <img src="<?= $page->page_image ?>" />
        <?php endif; ?>
      

      <?php if ($page->page_number !== 1): ?>
        <?php echo Html::a(
            '<',
            ['graphic-novel', 'page' => ($page->page_number - 1)], array('class' => 'button-back page-button')); ?>
      <?php endif; ?>
      <?php echo Html::a(
          '>',
          ['graphic-novel', 'page' => ($page->page_number + 1)], array('class' => 'button-next page-button')); ?>

    </div>
   
<!--     </div>
  </div> -->
</div>
