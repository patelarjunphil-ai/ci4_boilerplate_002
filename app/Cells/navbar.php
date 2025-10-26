<ul>
    <?php foreach ($links as $link): ?>
        <li>
            <a href="<?= $link->url ?>">
                <?php if ($link->icon): ?>
                    <i class="<?= $link->icon ?>"></i>
                <?php endif; ?>
                <?= $link->title ?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>
