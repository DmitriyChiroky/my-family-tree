<?php


$tree_id = get_the_ID();
$password_tree = get_post_meta($tree_id, 'wcl_password_tree', true);

$cookie_tree = $_COOKIE['wcl_allow_tree_' . $tree_id];

$instagram = get_field('instagram', 'option');
$version_app = get_field('version_app', 'option');
?>
<?php if (!empty($cookie_tree) && $cookie_tree == $password_tree) : ?>
    <footer class="wcl-footer">
        <div class="data-container wcl-container">
            <div class="data-row">
                <div class="data-copyright">
                    © <?php echo date("Y"); ?> Мої Рідні. Всі права захищено
                </div>

                <?php if (!empty($version_app)) : ?>
                    <div class="wcl-b1-version">
                        <?php echo $version_app; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </footer>
<?php endif; ?>


<?php wp_footer(); ?>

</body>

</html>