<?php


$version_app = get_field('version_app', 'option');
?>
<div class="wcl-enter-pass" data-tree-id="<?php echo get_the_ID(); ?>">
    <?php if (!empty($version_app)) : ?>
        <div class="wcl-b1-version">
            <?php echo $version_app; ?>
        </div>
    <?php endif; ?>

    <div class="data-container wcl-container">
        <div class="data-inner">
            <h1 class="data-title">
                Мої рідні
            </h1>

            <div class="data-subtitle">
                будь-ласка, введіть пароль
            </div>

            <form class="data-form">
                <div class="data-form-inner">
                    <div class="data-form-pass">
                        <input type="text" name="password" maxlength="4" required autocomplete="off">
                    </div>

                    <button type="submit">
                        Ввійти
                        <img src="<?php echo get_stylesheet_directory_uri() . '/img/icon-arrow-right.svg'; ?>" alt="img">
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>