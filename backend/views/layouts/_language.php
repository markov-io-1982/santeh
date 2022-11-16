 <li>
    <div>
        <?php foreach (Yii::$app->params['languages'] as $key => $language): ?>
            <span class="language" id="<?= $key ?>"><?= $language ?> | </span>
        <?php endforeach; ?>
        <p><?=  Yii::$app->language ?></p>
    </div>
</li>