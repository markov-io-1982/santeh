<li class="list-accor">
    <a>
        <?php if (isset($category['childs'])): ?>
            <span class="pull-left" style="padding-left: 8px;"><i class="glyphicon glyphicon-share-alt"></i></span>
            <?php else: ?>
        <?php endif; ?>
    </a>
    <span class="block-tree-pointer" id="<?= $category['id'];?>" data-id="<?= $category['id'];?>" data-name="<?= ucfirst($category['name_' . Yii::$app->language]);?>">
        <?= ucfirst($category['name_' . Yii::$app->language]) ?>
    </span>
    <?php if (isset($category['childs'])): ?>
        <ul>
            <?= $this->getMenuHtml($category['childs']); ?>
        </ul>
    <?php endif; ?>
</li>
