<?php

$tree_id = get_the_ID();
$password_tree = get_post_meta($tree_id, 'wcl_password_tree', true);

$cookie_tree = $_COOKIE['wcl_allow_tree_' . $tree_id];

get_header();

if (!empty($cookie_tree) && $cookie_tree == $password_tree) {
    get_template_part('template-parts/tree-content');
} else {
    get_template_part('template-parts/enter-pass');
}
?>

<?php
get_footer();
?>