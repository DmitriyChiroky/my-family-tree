<?php

get_header();

?>

<div class="wcl-404">
    <div class="data-container wcl-container">
        <div class="data-subhead">
            <?php _e('This page doesn\'t seem to exist .', 'theme'); ?>
        </div>

        <h1 class="data-title">
            <?php _e('404', 'theme'); ?>
        </h1>

        <div class="data-link">
            <a href="<?php echo site_url('/'); ?>" class="wcl-link">
                <?php _e('Home', 'theme'); ?>
            </a>
        </div>
    </div>
</div>

<?php get_footer(); ?>