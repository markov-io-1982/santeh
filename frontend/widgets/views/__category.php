<?php
//use Yii;
use yii\helpers\ArrayHelper;
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;

?>

<div class="panel panel-default">
	<div class="panel-heading">
		<i class="fa fa-bars"></i> <?= Yii::t('app', 'Categories') ?>
	</div>
	<div class="panel-body">


		<?php
			$name = 'name_'.Yii::$app->language;
			$items = [];

			foreach ($categories as $cat) {

				if ($cat->parent_id == 0) {

					$child = [];

					foreach ($categories as $sub) {
						if ($sub->parent_id == $cat->id) {
							$child[] = $sub;
					 	}
					}

					if (empty($child)) {
						$item['url'] = ['/products/'.$cat->slug];
						$item['label'] = $cat->$name;
						$item['linkOptions'] = [
							//'style' => 'color:red;',
							'class' => ''
						];
						$item['active'] = ($category == $cat->id OR $category == $cat->slug) ? true : '';
						
						$items[] = $item;						
					}

					if (!empty($child)) {
						$item['url'] = ['/products/'.$cat->slug];
						$item['label'] = $cat->$name;
						$item['items'] = [];

						foreach($child as $sub) {

							$active = ($category == $sub->id OR $category == $sub->slug) ? true : '';

							$sub_item['url'] = ['/products/'.$sub->slug];
							$sub_item['label'] = $sub->$name;
							$sub_item['linkOptions'] = [
								'class' => '',
							];
							$sub_item['active'] = $active;
							$item['items'][] = $sub_item;					
						}
						
						$item['linkOptions'] = [
							//'style' => 'color:red;',
							'class' => 'collapsed'
						];
						$item['active'] = $active;

						$items[] = $item;
					}

				}



			}

			echo Nav::widget([
			    'options' => [
			        'class' => 'category-menu'
			    ],
			    'items' => $items,
			    'activateItems' => true,
			    'activateParents' => true
			]);


		?>

	</div>							
</div>