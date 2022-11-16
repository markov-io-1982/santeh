	<div class="app-filters" style="display:none;" data-url="/<?= Yii::$app->request->pathInfo ?>" data-filters='<?= Yii::$app->request->get('filter') ?>'></div>

	<?php foreach ($filters as $filter): ?>

		<div class="panel panel-default">
			<!-- Default panel contents -->
			<div class="panel-heading">
				<?= $filter['name'] ?>
			</div>
			<div class="panel-body" id="filter-<?= $filter['id'] ?>">
				<?php foreach ($filter['values'] as $values): ?>
					<?php $name = 'name_' . Yii::$app->language ?>
					<div class="checkbox">
						<label>
							<input type="checkbox" id="<?= $values['slug'] ?>" value="<?= $values['slug'] ?>"> <?= $values[$name] ?>
						</label>
					</div>						
				<?php endforeach; ?>
				
				<span class="app-filter btn btn-app-default" title="<?= Yii::t('app', 'Apply a filter on the set parameters') ?>"><i class="fa fa-check"></i> <?= Yii::t('app', 'Filter') ?></span>
				<span class="app-clear-filter btn btn-warning" title="<?= Yii::t('app', 'Reset filter') ?>"><i class="fa fa-times" style="margin-right: 0px;"></i></span>

			</div>
		</div>

	<?php endforeach; ?>