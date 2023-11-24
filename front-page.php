<?php


get_header();

$instagram   = get_field('instagram', 'option');
$version_app = get_field('version_app', 'option');
?>
<div class="wcl-opening-soon">
    <div class="data-container wcl-container">
        <?php if (!empty($version_app)) : ?>
            <div class="wcl-b1-version">
                <?php echo $version_app; ?>
            </div>
        <?php endif; ?>

        <div class="data-img">
            <img src="<?php echo get_stylesheet_directory_uri() . '/img/open-soon-img.png'; ?>" alt="img">
        </div>

        <div class="data-title">
            скоро відкриття
        </div>

        <div class="data-subscribe">
            <div class="data-subscribe-text">
                підпишіться на наш інстаграм, щоб стежити за оновленнями
            </div>

            <?php if (!empty($instagram)) : ?>
                <?php
                $link_url    = $instagram['url'];
                $link_title  = $instagram['title'];
                $link_target = $instagram['target'] ?: '_self';
                ?>
                <div class="data-subscribe-btn">
                    <a href="<?php echo $link_url; ?>" target="<?php echo $link_target; ?>">
                        Підписатись
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
get_footer();
?>