<?php
//use Yii;
use yii\helpers\ArrayHelper;

?>

<div class="panel panel-default">
	<div class="panel-heading">
		<i class="fa fa-bars"></i> <a href="/products">Каталог</a> <?php // echo Yii::t('app', 'Categories') ?>
	</div>
	<div class="panel-body">

		<?php 
		$name = 'name_'.Yii::$app->language;
		foreach ($categories as $cat): ?>
			<?php if ($cat->parent_id == 0): ?>
				<?php $child = []; ?>
				<?php foreach ($categories as $sub): ?>
					<?php 
						if ($sub->parent_id == $cat->id) {
							$child[] = $sub;
					 	}
					 ?>
				<?php endforeach; ?>
				<?php if (empty($child)): ?>
					<a title="<?= $cat->$name ?>" class="list-group-item <?= ($category == $cat->id OR $category == $cat->slug) ? 'active' : '' ?>" href="/products/<?= $cat->slug ?>" aria-expanded="false">
						<?= $cat->$name ?>
					</a>	
				<?php endif; ?>
				<?php if (!empty($child)): ?>

					<?php 
						$sub_slugs = \yii\helpers\ArrayHelper::getColumn($child, 'slug');
						if (in_array($category, $sub_slugs) || $category == $cat->slug) {
							$active = 'active';
							$class_in = 'in';
							$aria_expanded = 'true';
						} else {
							$active = '';
							$class_in = '';
							$aria_expanded = 'false';
						}

					?>

					<a title="<?= $cat->$name ?>" class="list-group-item collapsed <?= $active ?>" data-submenu="<?= $cat->slug ?>" data-href="<?= Yii::$app->request->baseUrl; ?>/products/<?= $cat->slug ?>" href="#<?= $cat->slug ?>" data-toggle="collapse" data-parent="" aria-expanded="<?= $aria_expanded ?>">
                        <?= $cat->$name ?> <b class="caret"></b>
                    </a>
					<div id="<?= $cat->slug ?>" class="submenu panel-collapse collapse <?= $class_in ?>" aria-expanded="<?= $aria_expanded ?>" role="navigation">
					<?php foreach($child as $sub): ?>
						<a class="<?= $sub->$name ?> list-group-item <?= ($category == $sub->id OR $category == $sub->slug) ? 'active' : '' ?>" href="<?= Yii::$app->request->baseUrl; ?>/products/<?= $sub->slug ?>">
							<i class="fa fa-angle-right fa-fw"></i><?= $sub->$name ?>
						</a>
					<?php endforeach; ?>
					</div>
				<?php endif; ?>
					
			<?php endif; ?>
		<?php endforeach; ?>

	</div>							
</div>

<script>
	
// jQuery(document).ready(function($) {

// 	// function collapseOpen () {

// 	// }

// 	$('.list-group-item').hover(function(event) {
// 		//event.preventDefault();
// 		if ($(this).hasClass('collapsed') ) {
// 			console.log('hover');

// 			$(this).removeClass('collapsed').attr('aria-expanded', 'true');
// 			var id = $(this).data('submenu');
// 			var sub = $('#'+id );
// 			console.log(id);
// 			sub.addClass('in').attr('aria-expanded', 'true');

// 		}
// 	});

	

// });

</script>