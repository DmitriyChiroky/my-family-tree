<?php

$hierarchy_index = $args['hierarchy_index'];
$side_of_tree    = $args['side_of_tree'];
$post_id         = $args['post_id'];

$full_name       = get_field('full_name', $post_id);
//$side_of_tree    = get_field('side_of_tree', $post_id);
$family_tree     = get_field('family_tree', $post_id);

$member_type = get_member_type($hierarchy_index, $side_of_tree);

$class_exist = '';

if (!empty($post_id)) {
    $class_exist = 'mod-exist';
} else{
    $class_exist = 'mod-empty';   
}
?>
<div class="data-parent <?php echo $class_exist; ?>" data-post-id="<?php echo $post_id; ?>" data-hierarchy-index="<?php echo $hierarchy_index; ?>" data-side-tree="<?php echo $side_of_tree; ?>">
    <?php if (!empty($member_type)) : ?>
        <div class="data-parent-type">
            <?php echo $member_type; ?>
        </div>
    <?php else : ?>
        <div class="data-parent-type">
            Member Type
        </div>
    <?php endif; ?>

    <div class="data-parent-name">
        <?php if (!empty($full_name)) : ?>
            <?php echo $full_name; ?>
        <?php else : ?>
            -
        <?php endif; ?>
    </div>
</div>