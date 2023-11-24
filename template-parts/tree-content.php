<?php

$tree_id       = get_the_ID();
$title_of_tree = get_field('title_of_tree');
?>
<div class="wcl-section-1">
    <div class="data-container wcl-container">
        <div class="data-row">
            <h1 class="data-title">
                Мої рідні
            </h1>

            <div class="data-name">
                <?php if (!empty($title_of_tree)) : ?>
                    <?php echo $title_of_tree; ?>
                <?php else : ?>
                    <?php echo get_the_title(); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>




<?php
$args = array(
    'post_type'      => 'wcl-family-member',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'fields'         => 'ids',
    'meta_query' => array(
        'relation' => 'AND',
        array(
            'key' => 'family_tree',
            'value' => $tree_id,
            'compare' => '=',
        ),
        array(
            'key' => 'side_of_tree',
            'value' => 'mama',
            'compare' => '=',
        )
    )
);

$query_obj   = new WP_Query($args);
$total_count = $query_obj->found_posts;
$post_array  = [];

if ($query_obj->have_posts()) {
    while ($query_obj->have_posts()) {
        $query_obj->the_post();
        $post_id = get_the_ID();

        $index = get_field('hierarchy_index');

        $hierarchy_index = get_field('hierarchy_index');
        $post_array[$hierarchy_index] = $post_id;
    }
}
wp_reset_postdata();

// var_dump($post_array);

$level = '';

foreach ($post_array as $key => $item) {
    if (str_contains($key, 'l4')) {
        $level = 'mod-level-l4';
    } elseif (str_contains($key, 'l3')) {
        $level = 'mod-level-l3';
    } elseif (str_contains($key, 'l2')) {
        $level = 'mod-level-l2';
    } elseif (str_contains($key, 'l1')) {
        $level = 'mod-level-l1';
    }

    if (!empty($level)) {
        break;
    }
}

// var_dump($level);

$level = (int)preg_replace('/[^0-9]/', '', $level);


function get_level_state($level, $index_current) {
    $data = [];

    if ($index_current <= $level) {
        $data[] = 'mod-level-active';
    }

    if ($index_current < $level) {
        $data[] = 'mod-level-line-active';
    }

    return implode(" ", $data);
}

?>

<div class="wcl-section-2" data-tree-id="<?php echo $tree_id; ?>" data-level="<?php echo $level; ?>">
    <div class="wcl-member-popup">
        <div class="data-overlay"></div>

        <div class="data-inner-out">
            <div class="data-inner">
                <div class="data-close">
                    <img src="<?php echo get_stylesheet_directory_uri() . '/img/popup_close.svg'; ?>" alt="img">
                </div>
            </div>
        </div>
    </div>

    <div class="data-nav">
        <div class="data-nav-item">
            <div class="data-nav-btn mod-full-screen">
                <img src="<?php echo get_stylesheet_directory_uri() . '/img/icon-full-screen.svg'; ?>" alt="img">
            </div>
        </div>

        <div class="data-nav-item">
            <div class="data-nav-btn mod-home">
                <img src="<?php echo get_stylesheet_directory_uri() . '/img/icon-home.svg'; ?>" alt="img">
            </div>
        </div>

        <div class="data-nav-item">
            <div class="data-nav-group">
                <div class="data-nav-btn mod-plus">
                    <img src="<?php echo get_stylesheet_directory_uri() . '/img/icon-plus.svg'; ?>" alt="img">
                </div>

                <div class="data-nav-line"></div>

                <div class="data-nav-btn mod-minus">
                    <img src="<?php echo get_stylesheet_directory_uri() . '/img/icon-minus.svg'; ?>" alt="img">
                </div>
            </div>
        </div>
    </div>

    <div class="data-inner data-tree-app" id="tree-app">
        <div class="data-inner-el"></div>
        <div class="data-container wcl-container">
            <?php
            $add_new_class = 'mod-level-' . $level;
            ?>
            <div class="data-add-new <?php echo $add_new_class; ?>">
                <div class="data-add-new-text">
                    Додати покоління
                </div>

                <img src="<?php echo get_stylesheet_directory_uri() . '/img/add-new-level.svg'; ?>" alt="img">
            </div>

            <div class="data-list">
                <!-- Left -->

                <!-- data-lvl-1 -->

                <div class="data-lvl-1 data-level <?php echo get_level_state($level, 1); ?>">
                    <div class="data-item mod-l-mama">
                        <?php
                        $args =  array(
                            'side_of_tree'    => 'mama',
                            'hierarchy_index' => 'l1',
                            'post_id'         => $post_array['l1'],
                        );

                        get_template_part('template-parts/tree_member', null, $args);
                        ?>
                    </div>
                </div>

                <!-- data-lvl-2 -->

                <div class="data-lvl-2 data-level <?php echo get_level_state($level, 2); ?>">
                    <div class="data-item mod-l-babusya">
                        <?php
                        $args =  array(
                            'side_of_tree'    => 'mama',
                            'hierarchy_index' => 'l2_1',
                            'post_id'         => $post_array['l2_1'],
                        );

                        get_template_part('template-parts/tree_member', null, $args);
                        ?>
                    </div>

                    <div class="data-item mod-l-didus">
                        <?php
                        $args =  array(
                            'side_of_tree'    => 'mama',
                            'hierarchy_index' => 'l2_2',
                            'post_id'         => $post_array['l2_2'],
                        );

                        get_template_part('template-parts/tree_member', null, $args);
                        ?>
                    </div>
                </div>

                <!-- data-lvl-3 -->

                <div class="data-lvl-3 data-level <?php echo get_level_state($level, 3); ?>">
                    <div class="data-item mod-l-3-1-prababusya">
                        <?php
                        $args =  array(
                            'side_of_tree'    => 'mama',
                            'hierarchy_index' => 'l3_1_1',
                            'post_id'         => $post_array['l3_1_1'],
                        );

                        get_template_part('template-parts/tree_member', null, $args);
                        ?>
                    </div>

                    <div class="data-item mod-l-3-1-pradidus">
                        <?php
                        $args =  array(
                            'side_of_tree'    => 'mama',
                            'hierarchy_index' => 'l3_1_2',
                            'post_id'         => $post_array['l3_1_2'],
                        );

                        get_template_part('template-parts/tree_member', null, $args);
                        ?>
                    </div>

                    <div class="data-item mod-l-3-2-prababusya">
                        <?php
                        $args =  array(
                            'side_of_tree'    => 'mama',
                            'hierarchy_index' => 'l3_2_1',
                            'post_id'         => $post_array['l3_2_1'],
                        );

                        get_template_part('template-parts/tree_member', null, $args);
                        ?>
                    </div>

                    <div class="data-item mod-l-3-2-pradidus">
                        <?php
                        $args =  array(
                            'side_of_tree'    => 'mama',
                            'hierarchy_index' => 'l3_2_2',
                            'post_id'         => $post_array['l3_2_2'],
                        );

                        get_template_part('template-parts/tree_member', null, $args);
                        ?>
                    </div>
                </div>

                <!-- data-lvl-4 -->

                <div class="data-lvl-4 data-level <?php echo get_level_state($level, 4); ?>">
                    <div class="data-item mod-l-4-1-prababusya">
                        <?php
                        $args =  array(
                            'side_of_tree'    => 'mama',
                            'hierarchy_index' => 'l4_1_1',
                            'post_id'         => $post_array['l4_1_1'],
                        );

                        get_template_part('template-parts/tree_member', null, $args);
                        ?>
                    </div>

                    <div class="data-item mod-l-4-1-pradidus">
                        <?php
                        $args =  array(
                            'side_of_tree'    => 'mama',
                            'hierarchy_index' => 'l4_1_2',
                            'post_id'         => $post_array['l4_1_2'],
                        );

                        get_template_part('template-parts/tree_member', null, $args);
                        ?>
                    </div>


                    <div class="data-item mod-l-4-2-prababusya">
                        <?php
                        $args =  array(
                            'side_of_tree'    => 'mama',
                            'hierarchy_index' => 'l4_2_1',
                            'post_id'         => $post_array['l4_2_1'],
                        );

                        get_template_part('template-parts/tree_member', null, $args);
                        ?>
                    </div>

                    <div class="data-item mod-l-4-2-pradidus">
                        <?php
                        $args =  array(
                            'side_of_tree'    => 'mama',
                            'hierarchy_index' => 'l4_2_2',
                            'post_id'         => $post_array['l4_2_2'],
                        );

                        get_template_part('template-parts/tree_member', null, $args);
                        ?>
                    </div>

                    <div class="data-item mod-l-4-3-prababusya">
                        <?php
                        $args =  array(
                            'side_of_tree'    => 'mama',
                            'hierarchy_index' => 'l4_3_1',
                            'post_id'         => $post_array['l4_3_1'],
                        );

                        get_template_part('template-parts/tree_member', null, $args);
                        ?>
                    </div>

                    <div class="data-item mod-l-4-3-pradidus">
                        <?php
                        $args =  array(
                            'side_of_tree'    => 'mama',
                            'hierarchy_index' => 'l4_3_2',
                            'post_id'         => $post_array['l4_3_2'],
                        );

                        get_template_part('template-parts/tree_member', null, $args);
                        ?>
                    </div>

                    <div class="data-item mod-l-4-4-prababusya">
                        <?php
                        $args =  array(
                            'side_of_tree'    => 'mama',
                            'hierarchy_index' => 'l4_4_1',
                            'post_id'         => $post_array['l4_4_1'],
                        );

                        get_template_part('template-parts/tree_member', null, $args);
                        ?>
                    </div>

                    <div class="data-item mod-l-4-4-pradidus">
                        <?php
                        $args =  array(
                            'side_of_tree'    => 'mama',
                            'hierarchy_index' => 'l4_4_2',
                            'post_id'         => $post_array['l4_4_2'],
                        );

                        get_template_part('template-parts/tree_member', null, $args);
                        ?>
                    </div>
                </div>





                <!-- Right -->

                <?php
                $args = array(
                    'post_type'      => 'wcl-family-member',
                    'posts_per_page' => -1,
                    'post_status'    => 'publish',
                    'fields'         => 'ids',
                    'meta_query' => array(
                        'relation' => 'AND',
                        array(
                            'key'     => 'family_tree',
                            'value'   => $tree_id,
                            'compare' => '=',
                        ),
                        array(
                            'key'     => 'side_of_tree',
                            'value'   => 'tato',
                            'compare' => '=',
                        )
                    )
                );

                $query_obj   = new WP_Query($args);
                $total_count = $query_obj->found_posts;
                $post_array  = [];

                if ($query_obj->have_posts()) {
                    while ($query_obj->have_posts()) {
                        $query_obj->the_post();
                        $post_id = get_the_ID();

                        $index = get_field('hierarchy_index');

                        $hierarchy_index = get_field('hierarchy_index');
                        $post_array[$hierarchy_index] = $post_id;
                    }
                }

                wp_reset_postdata();
                ?>


                <!-- data-lvl-1 -->

                <div class="data-lvl-1 data-level <?php echo get_level_state($level, 1); ?>">
                    <div class="data-item mod-r-tato">
                        <?php
                        $args =  array(
                            'side_of_tree'    => 'tato',
                            'hierarchy_index' => 'l1',
                            'post_id'         => $post_array['l1'],
                        );

                        get_template_part('template-parts/tree_member', null, $args);
                        ?>
                    </div>
                </div>

                <!-- data-lvl-2 -->

                <div class="data-lvl-2 data-level <?php echo get_level_state($level, 2); ?>">
                    <div class="data-item mod-r-babusya">
                        <?php
                        $args =  array(
                            'side_of_tree'    => 'tato',
                            'hierarchy_index' => 'l2_1',
                            'post_id'         => $post_array['l2_1'],
                        );

                        get_template_part('template-parts/tree_member', null, $args);
                        ?>
                    </div>

                    <div class="data-item mod-r-didus">
                        <?php
                        $args =  array(
                            'side_of_tree'    => 'tato',
                            'hierarchy_index' => 'l2_2',
                            'post_id'         => $post_array['l2_2'],
                        );

                        get_template_part('template-parts/tree_member', null, $args);
                        ?>
                    </div>
                </div>

                <!-- data-lvl-3 -->

                <div class="data-lvl-3 data-level <?php echo get_level_state($level, 3); ?>">
                    <div class="data-item mod-r-3-1-prababusya">
                        <?php
                        $args =  array(
                            'side_of_tree'    => 'tato',
                            'hierarchy_index' => 'l3_1_1',
                            'post_id'         => $post_array['l3_1_1'],
                        );

                        get_template_part('template-parts/tree_member', null, $args);
                        ?>
                    </div>

                    <div class="data-item mod-r-3-1-pradidus">
                        <?php
                        $args =  array(
                            'side_of_tree'    => 'tato',
                            'hierarchy_index' => 'l3_1_2',
                            'post_id'         => $post_array['l3_1_2'],
                        );

                        get_template_part('template-parts/tree_member', null, $args);
                        ?>
                    </div>

                    <div class="data-item mod-r-3-2-prababusya">
                        <?php
                        $args =  array(
                            'side_of_tree'    => 'tato',
                            'hierarchy_index' => 'l3_2_1',
                            'post_id'         => $post_array['l3_2_1'],
                        );

                        get_template_part('template-parts/tree_member', null, $args);
                        ?>
                    </div>

                    <div class="data-item mod-r-3-2-pradidus">
                        <?php
                        $args =  array(
                            'side_of_tree'    => 'tato',
                            'hierarchy_index' => 'l3_2_2',
                            'post_id'         => $post_array['l3_2_2'],
                        );

                        get_template_part('template-parts/tree_member', null, $args);
                        ?>
                    </div>
                </div>

                <!-- data-lvl-4 -->

                <div class="data-lvl-4 data-level <?php echo get_level_state($level, 4); ?>">
                    <div class="data-item mod-r-4-1-prababusya">
                        <?php
                        $args =  array(
                            'side_of_tree'    => 'tato',
                            'hierarchy_index' => 'l4_1_1',
                            'post_id'         => $post_array['l4_1_1'],
                        );

                        get_template_part('template-parts/tree_member', null, $args);
                        ?>
                    </div>

                    <div class="data-item mod-r-4-1-pradidus">
                        <?php
                        $args =  array(
                            'side_of_tree'    => 'tato',
                            'hierarchy_index' => 'l4_1_2',
                            'post_id'         => $post_array['l4_1_2'],
                        );

                        get_template_part('template-parts/tree_member', null, $args);
                        ?>
                    </div>


                    <div class="data-item mod-r-4-2-prababusya">
                        <?php
                        $args =  array(
                            'side_of_tree'    => 'tato',
                            'hierarchy_index' => 'l4_2_1',
                            'post_id'         => $post_array['l4_2_1'],
                        );

                        get_template_part('template-parts/tree_member', null, $args);
                        ?>
                    </div>

                    <div class="data-item mod-r-4-2-pradidus">
                        <?php
                        $args =  array(
                            'side_of_tree'    => 'tato',
                            'hierarchy_index' => 'l4_2_2',
                            'post_id'         => $post_array['l4_2_2'],
                        );

                        get_template_part('template-parts/tree_member', null, $args);
                        ?>
                    </div>

                    <div class="data-item mod-r-4-3-prababusya">
                        <?php
                        $args =  array(
                            'side_of_tree'    => 'tato',
                            'hierarchy_index' => 'l4_3_1',
                            'post_id'         => $post_array['l4_3_1'],
                        );

                        get_template_part('template-parts/tree_member', null, $args);
                        ?>
                    </div>

                    <div class="data-item mod-r-4-3-pradidus">
                        <?php
                        $args =  array(
                            'side_of_tree'    => 'tato',
                            'hierarchy_index' => 'l4_3_2',
                            'post_id'         => $post_array['l4_3_2'],
                        );

                        get_template_part('template-parts/tree_member', null, $args);
                        ?>
                    </div>

                    <div class="data-item mod-r-4-4-prababusya">
                        <?php
                        $args =  array(
                            'side_of_tree'    => 'tato',
                            'hierarchy_index' => 'l4_4_1',
                            'post_id'         => $post_array['l4_4_1'],
                        );

                        get_template_part('template-parts/tree_member', null, $args);
                        ?>
                    </div>

                    <div class="data-item mod-r-4-4-pradidus">
                        <?php
                        $args =  array(
                            'side_of_tree'    => 'tato',
                            'hierarchy_index' => 'l4_4_2',
                            'post_id'         => $post_array['l4_4_2'],
                        );

                        get_template_part('template-parts/tree_member', null, $args);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script src="https://unpkg.com/@panzoom/panzoom@4.5.1/dist/panzoom.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (document.querySelector('.wcl-section-2')) {
            let section = document.querySelector('.wcl-section-2');
            const tree_app = document.getElementById('tree-app');

            let minScale = 0.5;
            let startScale = 0.5
          //  startScale = 1

            if (window.matchMedia("(max-width: 776px)").matches) {
                minScale = 0.2;
                startScale = 0.4
            }

            const panzoom = Panzoom(tree_app, {
                minScale: minScale,
                maxScale: 2,
                smoothScroll: true,
                increment: 0.05,
                transition: true,
                animate: true,
                startScale: startScale,
            });

            tree_app.addEventListener('wheel', (e) => {
                panzoom.zoomWithWheel(e);
            });

            section.querySelector('.data-nav-btn.mod-home').addEventListener('click', panzoom.reset)
            section.querySelector('.data-nav-btn.mod-plus').addEventListener('click', panzoom.zoomIn)
            section.querySelector('.data-nav-btn.mod-minus').addEventListener('click', panzoom.zoomOut)




            /* 
            enterFullscreen
             */
            const panzoomContainer = document.querySelector('.wcl-section-2');
            let isFullscreen = false;

            section.querySelector('.data-nav-btn.mod-full-screen').addEventListener('click', function(e) {
                if (isFullscreen) {
                    exitFullscreen();
                } else {
                    enterFullscreen(panzoomContainer);
                }
                isFullscreen = !isFullscreen;
            })


            function enterFullscreen(element) {
                if (element.requestFullscreen) {
                    element.requestFullscreen();
                } else if (element.mozRequestFullScreen) {
                    element.mozRequestFullScreen();
                } else if (element.webkitRequestFullscreen) {
                    element.webkitRequestFullscreen();
                } else if (element.msRequestFullscreen) {
                    element.msRequestFullscreen();
                }
            }

            function exitFullscreen() {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                } else if (document.mozCancelFullScreen) {
                    document.mozCancelFullScreen();
                } else if (document.webkitExitFullscreen) {
                    document.webkitExitFullscreen();
                } else if (document.msExitFullscreen) {
                    document.msExitFullscreen();
                }
            }
        }
    });
</script>