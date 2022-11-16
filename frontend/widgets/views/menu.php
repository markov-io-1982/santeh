<li class="list-accor">
    <a>
        <?php if (isset($category['childs'])): ?>
            <span class="pull-left" style="padding-left: 8px;"><i class="glyphicon glyphicon-chevron-right"></i></span>
        <?php endif; ?>
    </a>
    <a href="<?= \yii\helpers\Url::to(['/products/'.$category['slug']]); ?>" title="<?= ucfirst($category['name_' . Yii::$app->language]) ?>">
        <?= ucfirst($category['name_' . Yii::$app->language]) ?>
    </a>
    <?php if (isset($category['childs'])): ?>
        <ul>
            <?= $this->getMenuHtml($category['childs']); ?>
        </ul>
    <?php endif; ?>
</li>