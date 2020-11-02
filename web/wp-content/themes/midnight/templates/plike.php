<div class="bwl-like<?php echo self::is_liked() ? ' bwl-liked' : ''; ?>" data-post-id="<?php echo get_the_ID(); ?>">
    <p>Likes:
    <span class="bwl-count">
        <?php echo Plikes::get_likes(); ?>
    </span>
    </p>
</div>