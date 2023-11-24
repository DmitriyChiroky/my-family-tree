<?php


/*
* Plug for VS
*/
if (false) {
    function get_field() {
    }
    function acf_add_options_page() {
    }
    function get_sub_field() {
    }
    function have_rows() {
    }
    function the_row() {
    }
    function get_row_layout() {
    }
    function get_field_object() {
    }
    function update_field() {
    }
    function acf_register_block_type() {
    }
}



/*
* wcl_add_slug_body_class
*/
function wcl_add_slug_body_class($classes) {
    global $post;
    if (isset($post)) {
        $classes[] = $post->post_type . '-' . $post->post_name;
    }
    return $classes;
}
add_filter('body_class', 'wcl_add_slug_body_class');





/*
* wcl_post_type_family_tree
*/
function wcl_post_type_family_tree() {
    $labels = array(
        'name'               => _x('Family Tree', 'Post Type General Name'),
        'singular_name'      => _x('Family Tree', 'Post Type Singular Name'),
        'add_new'            => __('Add New'),
        'add_new_item'       => __('Add New Family Tree'),
        'edit_item'          => __('Edit Family Tree'),
        'new_item'           => __('New Family Tree'),
        'all_items'          => __('All Family Tree'),
        'view_item'          => __('View Family Tree'),
        'search_items'       => __('Search Family Tree'),
        'not_found'          => __('Not Found'),
        'not_found_in_trash' => __('Not found in Trash'),
        'parent_item_colon'  => '',
        'menu_name'          => __('Family Tree'),
    );

    $args = array(
        'label'             => __('Family Tree'),
        'labels'            => $labels,
        'public'            => true,
        'show_ui'           => true,
        'supports'          => array('title', 'thumbnail'),
        'show_in_nav_menus' => true,
        '_builtin'          => false,
        'has_archive'       => false,
        'menu_position'     => 5,
        // 'menu_icon'         => 'dashicons-family_tree',
        //  'rewrite'           => array('slug' => 'tree'),
    );

    register_post_type('wcl-family-tree', $args);
}
add_action('init', 'wcl_post_type_family_tree');



function na_remove_slug($post_link, $post, $leavename) {

    if ('wcl-family-tree' != $post->post_type || 'publish' != $post->post_status) {
        return $post_link;
    }

    $post_link = str_replace('/' . $post->post_type . '/', '/', $post_link);

    return $post_link;
}
add_filter('post_type_link', 'na_remove_slug', 10, 3);

function na_parse_request($query) {

    if (!$query->is_main_query() || 2 != count($query->query) || !isset($query->query['page'])) {
        return;
    }

    if (!empty($query->query['name'])) {
        $query->set('post_type', array('post', 'wcl-family-tree', 'page'));
    }
}
add_action('pre_get_posts', 'na_parse_request');




/*
* wcl_post_type_family_member
*/
function wcl_post_type_family_member() {
    $labels = array(
        'name'               => _x('Family Member', 'Post Type General Name'),
        'singular_name'      => _x('Family Member', 'Post Type Singular Name'),
        'add_new'            => __('Add New'),
        'add_new_item'       => __('Add New Family Member'),
        'edit_item'          => __('Edit Family Member'),
        'new_item'           => __('New Family Member'),
        'all_items'          => __('All Family Member'),
        'view_item'          => __('View Family Member'),
        'search_items'       => __('Search Family Member'),
        'not_found'          => __('Not Found'),
        'not_found_in_trash' => __('Not found in Trash'),
        'parent_item_colon'  => '',
        'menu_name'          => __('Family Member'),
    );

    $args = array(
        'label'             => __('Family Member'),
        'labels'            => $labels,
        'public'            => false,
        'show_ui'           => true,
        'supports'          => array('title', 'thumbnail'),
        'show_in_nav_menus' => true,
        '_builtin'          => false,
        'has_archive'       => false,
        'menu_position'     => 5,
        //  'menu_icon'         => 'dashicons-family_member',
    );

    register_post_type('wcl-family-member', $args);
}
add_action('init', 'wcl_post_type_family_member');






/**
 * member_info
 */
function member_info() {
    $post_id = $_POST['post_id'];

    $full_name            = get_field('full_name', $post_id);
    $date_of_birth        = get_field('date_of_birth', $post_id);
    $place_of_birth       = get_field('place_of_birth', $post_id);
    $biography            = get_field('biography', $post_id);
    $audio_recording      = get_field('audio_recording', $post_id);
    $brothers_and_sisters = get_field('brothers_and_sisters', $post_id);
    $hierarchy_index      = get_field('hierarchy_index', $post_id);
    $side_of_tree         = get_field('side_of_tree', $post_id);
    $family_tree          = get_field('family_tree', $post_id);
    $thumbnail            = get_the_post_thumbnail($post_id, 'image-size-2');

    $member_type = get_member_type($hierarchy_index, $side_of_tree);

    ob_start();
?>
    <div class="data-inner-two">
        <div class="data-b1">
            <?php if (!empty($thumbnail)) : ?>
                <div class="data-img mod-have">
                    <?php echo $thumbnail; ?>
                </div>
            <?php else : ?>
                <div class="wcl-b2-img-loader data-img-loader">
                    <label for="picture">
                        <input type="file" id="picture" name="picture" accept="image/*" />

                        <img src="<?php echo get_stylesheet_directory_uri() . '/img/picture-icon.svg'; ?>" alt="img">

                        <div class="b2-text mod-label">
                            Додати фото
                        </div>
                    </label>
                </div>
            <?php endif; ?>

            <div class="data-b1-content">
                <?php if (!empty($member_type)) : ?>
                    <div class="data-type">
                        <?php echo $member_type; ?>
                    </div>
                <?php else : ?>
                    <div class="data-type">
                        Member Type
                    </div>
                <?php endif; ?>

                <div class="data-name">
                    <div class="data-name-label mod-label">
                        <?php
                        if (strpos(mb_strtolower($member_type), 'дідусь') !== false || strpos(mb_strtolower($member_type), 'тато') !== false) {
                            echo 'Прізвище, імя, по-батькові:';
                        } else {
                            echo 'Прізвище (дівоче прізвище), імя, по-батькові:';
                        }
                        ?>
                    </div>

                    <div class="data-name-val">
                        <?php if (!empty($full_name)) : ?>
                            <?php echo $full_name; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="data-b3">
                    <?php if (!empty($date_of_birth)) : ?>
                        <div class="data-b3-item">
                            <div class="data-b3-item-label mod-label">
                                Дата народження
                            </div>

                            <div class="data-b3-item-text">
                                <?php echo $date_of_birth; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($place_of_birth)) : ?>
                        <div class="data-b3-item">

                            <div class="data-b3-item-label mod-label">
                                Місце народження
                            </div>

                            <div class="data-b3-item-text">
                                <?php echo $place_of_birth; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <?php if (!empty($biography)) : ?>
            <div class="data-biography">
                <div class="data-biography-label mod-label">
                    Біографія
                </div>

                <div class="data-biography-text">
                    <?php echo $biography; ?>
                </div>
            </div>
        <?php endif; ?>

        <?php
        $audio_recording_url = wp_get_attachment_url($audio_recording);
        ?>
        <div class="data-b2">
            <?php if (!empty($audio_recording_url)) : ?>
                <div class="data-voice">
                    <audio controls>
                        <source src="<?php echo $audio_recording_url; ?>" type="audio/mpeg">
                    </audio>

                    <div class="data-voice-label mod-label">
                        Голос
                    </div>

                    <div class="data-voice-btn">
                        <div class="data-voice-btn-icon">
                            <img src="<?php echo get_stylesheet_directory_uri() . '/img/voice-play.svg'; ?>" alt="img">
                            <img src="<?php echo get_stylesheet_directory_uri() . '/img/voice-pause.svg'; ?>" alt="img">
                        </div>

                        <div class="data-voice-btn-wave">
                            <img src="<?php echo get_stylesheet_directory_uri() . '/img/voice-btn-wave.svg'; ?>" alt="img">
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!empty($brothers_and_sisters)) : ?>
                <div class="data-siblings">
                    <div class="data-siblings-label mod-label">
                        Рідні брати та сестри
                    </div>

                    <div class="data-siblings-text">
                        <?php echo $brothers_and_sisters; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="data-edit">
            <div class="data-btn-back wcl-btn">
                <img src="<?php echo get_stylesheet_directory_uri() . '/img/icon-arrow-left.svg'; ?>" alt="img">
                Назад
            </div>

            <div class="data-edit-btn wcl-btn">
                <img src="<?php echo get_stylesheet_directory_uri() . '/img/btn-edit.svg'; ?>" alt="img">
                Редагувати
            </div>
        </div>
    </div>
<?php
    $output['post'] = ob_get_clean();
    echo json_encode($output);
    wp_die();
}
add_action('wp_ajax_member_info', 'member_info');
add_action('wp_ajax_nopriv_member_info', 'member_info');






/**
 * member_info_edit
 */
function member_info_edit() {
    $post_id = $_POST['post_id'];
    $state   = $_POST['state'];

    $full_name            = get_field('full_name', $post_id);
    $date_of_birth        = get_field('date_of_birth', $post_id);
    $place_of_birth       = get_field('place_of_birth', $post_id);
    $biography            = get_field('biography', $post_id);
    $audio_recording      = get_field('audio_recording', $post_id);
    $brothers_and_sisters = get_field('brothers_and_sisters', $post_id);
    $date_of_death        = get_field('date_of_death', $post_id);
    $burial_place         = get_field('burial_place', $post_id);
    $hierarchy_index      = get_field('hierarchy_index', $post_id);
    $side_of_tree         = get_field('side_of_tree', $post_id);
    $family_tree          = get_field('family_tree', $post_id);
    $thumbnail            = get_the_post_thumbnail($post_id, 'image-size-2');

    $data_new_member = '';

    if (!empty($state) && $state == 'new_member') {
        $state           = $_POST['state'];
        $side_of_tree    = $_POST['side_of_tree'];
        $hierarchy_index = $_POST['hierarchy_index'];
        $family_tree     = $_POST['family_tree'];
        $data_new_member = ['side_of_tree' => $side_of_tree, 'hierarchy_index' => $hierarchy_index, 'family_tree' => $family_tree];
        $data_new_member = esc_attr(json_encode($data_new_member));
        $data_new_member = 'data-new-member="' . $data_new_member . '"';
    }

    $member_type = get_member_type($hierarchy_index, $side_of_tree);

    ob_start();
?>
    <form class="data-inner-three" <?php echo $data_new_member; ?>>
        <div class="data-b1">
            <div class="wcl-b2-img-loader data-img-loader">
                <label for="picture">
                    <input type="file" id="picture" name="picture" accept="image/*" />

                    <img src="<?php echo get_stylesheet_directory_uri() . '/img/picture-icon.svg'; ?>" alt="img">

                    <div class="b2-text mod-label">
                        Додати фото
                    </div>
                </label>
            </div>

            <div class="data-b1-content">
                <?php if (!empty($member_type)) : ?>
                    <div class="data-type">
                        <?php echo $member_type; ?>
                    </div>
                <?php else : ?>
                    <div class="data-type">
                        Member Type
                    </div>
                <?php endif; ?>

                <div class="data-name">
                    <div class="data-name-label mod-label">
                        <?php
                        if (strpos(mb_strtolower($member_type), 'дідусь') !== false || strpos(mb_strtolower($member_type), 'тато') !== false) {
                            echo 'Прізвище, імя, по-батькові:';
                        } else {
                            echo 'Прізвище (дівоче прізвище), імя, по-батькові:';
                        }
                        ?>
                    </div>

                    <div class="data-name-field">
                        <input type="text" name="full_name" value="<?php echo $full_name; ?>" placeholder="Введіть ім'я">
                    </div>
                </div>

                <div class="data-b3">
                    <div class="data-b3-item">
                        <div class="data-b3-item-label mod-label">
                            Дата народження
                        </div>

                        <?php
                        $date_new = date("Y-m-d", strtotime(str_replace(".", "-", $date_of_birth)));
                        $date_value = '';

                        if (!empty($date_of_birth)) {
                            $date_value = $date_new;
                        }
                        ?>
                        <div class="data-b3-item-field">
                            <input type="date" name="date_of_birth" value="<?php echo $date_value; ?>" placeholder="дд.мм.рррр" />
                        </div>
                    </div>

                    <div class="data-b3-item">
                        <div class="data-b3-item-label mod-label">
                            Місце народження
                        </div>

                        <div class="data-b3-item-field">
                            <input type="text" name="place_of_birth" value="<?php echo $place_of_birth; ?>" placeholder="Населений пункт">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="data-biography">
            <div class="data-biography-label mod-label">
                Біографія
            </div>

            <div class="data-biography-field">
                <textarea name="biography" placeholder="Опишіть життя вашого родича. Ким працював? Де жив? Де бував?..."><?php echo $biography; ?></textarea>
            </div>
        </div>

        <?php
        $audio_recording_title = get_the_title($audio_recording);
        ?>
        <div class="data-b2">
            <div class="data-voice">
                <div class="data-voice-label mod-label">
                    Голос
                </div>

                <div class="data-voice-field">
                    <input type="file" id="audio_recording" name="audio_recording" accept="audio/*" />

                    <label for="audio_recording">
                        <img src="<?php echo get_stylesheet_directory_uri() . '/img/add-audio-icon.svg'; ?>" alt="img">

                        <?php if (!empty($audio_recording_title)) : ?>
                            <span>
                                <?php echo $audio_recording_title; ?>
                            </span>
                        <?php else : ?>
                            <span>Додати аудіо</span>
                        <?php endif; ?>
                    </label>

                    <?php
                    $class_audio = '';

                    if (!empty($audio_recording)) {
                        $class_audio = 'show';
                    }
                    ?>
                    <div class="data-voice-field-delete-audio <?php echo $class_audio; ?>">
                        Видалити
                    </div>
                </div>
            </div>

            <?php
            $brothers_and_sisters_new = explode(", ", $brothers_and_sisters);
            ?>
            <div class="data-siblings">
                <div class="data-siblings-label mod-label">
                    Рідні брати та сестри
                </div>

                <div class="data-siblings-field">
                    <input type="text" name="brothers_and_sisters" id="brothers_and_sisters" placeholder="Введіть ім'я">

                    <ul class="data-siblings-list" id="brothers_and_sisters_list">
                        <?php if (!empty($brothers_and_sisters)) : ?>
                            <?php foreach ($brothers_and_sisters_new as $key => $value) : ?>
                                <li class="data-siblings-item">
                                    <span><?php echo $value; ?></span>
                                    <div class="data-siblings-delete-button">Видалити</div>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>

                    <button type="button" class="data-siblings-btn-add" id="brothers_and_sisters_add">
                        <div class="data-siblings-btn-add-icon">
                            <img src="<?php echo get_stylesheet_directory_uri() . '/img/plus-icon.svg'; ?>" alt="img">
                        </div>

                        <span>додати</span>
                    </button>
                </div>
            </div>
        </div>

        <?php
        $date_new = date("Y-m-d", strtotime(str_replace(".", "-", $date_of_death)));
        $date_value = '';

        if (!empty($date_of_death)) {
            $date_value = $date_new;
        }
        ?>
        <div class="data-b3 data-b3-2">
            <div class="data-b3-item">
                <div class="data-b3-item-label mod-label">
                    Дата смерті
                </div>

                <div class="data-b3-item-field">
                    <input type="date" name="date_of_death" placeholder="дд.мм.рррр" value="<?php echo $date_value; ?>" />
                </div>
            </div>

            <div class="data-b3-item">
                <div class="data-b3-item-label mod-label">
                    Місце поховання або кладовище
                </div>

                <div class="data-b3-item-field">
                    <input type="text" name="burial_place" value="<?php echo $burial_place; ?>" placeholder="Населений пункт">
                </div>
            </div>
        </div>

        <div class="data-edit">
            <div class="data-btn-back wcl-btn">
                <img src="<?php echo get_stylesheet_directory_uri() . '/img/icon-arrow-left.svg'; ?>" alt="img">
                Назад
            </div>

            <?php if ($state == 'new_member') : ?>
                <button type="submit" class="data-edit-btn wcl-btn" name="submit">Додати інформацію</button>
            <?php else : ?>
                <button type="submit" class="data-edit-btn wcl-btn" name="submit">Оновити інформацію</button>
            <?php endif; ?>

            <div class="data-form-notify"></div>

            <div class="data-form-loader">
                <img src="<?php echo get_stylesheet_directory_uri() . '/img/loader-form-icon.svg'; ?>" alt="img">
            </div>
        </div>
    </form>
<?php
    $output['post'] = ob_get_clean();
    echo json_encode($output);
    wp_die();
}
add_action('wp_ajax_member_info_edit', 'member_info_edit');
add_action('wp_ajax_nopriv_member_info_edit', 'member_info_edit');





/* 
get_member_type
 */
function get_member_type($hierarchy_index, $side_of_tree) {
    $member_type = '';
    if ($hierarchy_index == 'l1') {
        if ($side_of_tree == 'mama') {
            $member_type = 'Мама';
        } else {
            $member_type = 'Тато';
        }
    } elseif ($hierarchy_index == 'l2_1') {
        $member_type = 'Бабуся';
    } elseif ($hierarchy_index == 'l2_2') {
        $member_type = 'Дідусь';
    } elseif ($hierarchy_index == 'l3_1_1' || $hierarchy_index == 'l3_2_1') {
        $member_type = 'ПраБабуся';
    } elseif ($hierarchy_index == 'l3_1_2' || $hierarchy_index == 'l3_2_2') {
        $member_type = 'ПраДідусь';
    } elseif ($hierarchy_index == 'l4_1_1' || $hierarchy_index == 'l4_2_1' || $hierarchy_index == 'l4_3_1' || $hierarchy_index == 'l4_4_1') {
        $member_type = 'ПраПраБабуся';
    } elseif ($hierarchy_index == 'l4_1_2' || $hierarchy_index == 'l4_2_2' || $hierarchy_index == 'l4_3_2' || $hierarchy_index == 'l4_4_2') {
        $member_type = 'ПраПраДідусь';
    } else {
        $member_type = 'Member Type';
    }

    return $member_type;
}





/*
* member_info_update
*/
function member_info_update() {
    $user                 = wp_get_current_user();
    $post_id              = $_POST['post_id'];
    $full_name            = $_POST['full_name'];
    $date_of_birth        = $_POST['date_of_birth'];
    $place_of_birth       = $_POST['place_of_birth'];
    $biography            = $_POST['biography'];
    $date_of_death        = $_POST['date_of_death'];
    $burial_place         = $_POST['burial_place'];
    $brothers_and_sisters = $_POST['brothers_and_sisters'];
    $audio_deleted        = $_POST['audio_deleted'];
    $data = [];

    if (!empty($full_name)) {
        if (!empty($_FILES['picture'])) {
            $picture_id = media_handle_upload('picture', $post_id);
            set_post_thumbnail($post_id, $picture_id);
        }

        if (!empty($_FILES['audio_recording'])) {
            $audio_recording_id = media_handle_upload('audio_recording', 0);
            $data[] = update_field('audio_recording', $audio_recording_id, $post_id);
        }

        if ($audio_deleted == true) {
            $data[] = update_field('audio_recording', '', $post_id);
        }

        $data[] = update_field('full_name', $full_name, $post_id);
        $data[] = update_field('date_of_birth', $date_of_birth, $post_id);
        $data[] = update_field('place_of_birth', $place_of_birth, $post_id);
        $data[] = update_field('biography', $biography, $post_id);
        $data[] = update_field('date_of_death', $date_of_death, $post_id);
        $data[] = update_field('burial_place', $burial_place, $post_id);
        $data[] = update_field('brothers_and_sisters', $brothers_and_sisters, $post_id);

        // Update the post
        $post_data = array(
            'ID'         => $post_id,
            'post_title' => $full_name,
        );

        $post_updated = wp_update_post($post_data);

        if (is_wp_error($post_updated)) {
            $data[] = "Error updating post title: " . $post_updated->get_error_message();
        } else {
            $data[] = "Post title updated successfully!";
        }

        $data['submit'] = 'Інформація успішно оновлена';
    } else {
        $data['error'] = 'Треба задати основну інформацію';
    }

    //$data[] = $brothers_and_sisters;

    echo json_encode($data);
    wp_die();
}
add_action('wp_ajax_member_info_update', 'member_info_update');
add_action('wp_ajax_nopriv_member_info_update', 'member_info_update');





/*
* member_info_add_new
*/
function member_info_add_new() {
    $user            = wp_get_current_user();

    $full_name            = $_POST['full_name'];
    $date_of_birth        = $_POST['date_of_birth'];
    $place_of_birth       = $_POST['place_of_birth'];
    $biography            = $_POST['biography'];
    $date_of_death        = $_POST['date_of_death'];
    $burial_place         = $_POST['burial_place'];
    $brothers_and_sisters = $_POST['brothers_and_sisters'];

    $new_member_data = $_POST['new_member_data'];
    $new_member_data = json_decode(stripslashes($new_member_data), true);

    $data[] = $new_member_data;

    if (!empty($full_name)) {
        $new_member = array(
            'post_title'  => $full_name,
            'post_status' => 'publish',
            'post_type'   => 'wcl-family-member',
        );

        $new_member_id = wp_insert_post($new_member);

        if ($new_member_id) {
            $data[] = 'New member post created with ID: ' . $new_member_id;
        } else {
            $data[] = 'Failed to create a new member post.';
        }

        // ACF

        if (!empty($_FILES['picture'])) {
            $picture_id = media_handle_upload('picture', $new_member_id);
            set_post_thumbnail($new_member_id, $picture_id);
        }
        if (!empty($_FILES['audio_recording'])) {
            $audio_recording_id = media_handle_upload('audio_recording', 0);
            $data[] = update_field('audio_recording', $audio_recording_id, $new_member_id);
        }

        $data[] = update_field('full_name', $full_name, $new_member_id);
        $data[] = update_field('date_of_birth', $date_of_birth, $new_member_id);
        $data[] = update_field('place_of_birth', $place_of_birth, $new_member_id);
        $data[] = update_field('biography', $biography, $new_member_id);
        $data[] = update_field('date_of_death', $date_of_death, $new_member_id);
        $data[] = update_field('burial_place', $burial_place, $new_member_id);
        $data[] = update_field('brothers_and_sisters', $brothers_and_sisters, $new_member_id);
        $data[] = update_field('side_of_tree', $new_member_data['side_of_tree'], $new_member_id);
        $data[] = update_field('hierarchy_index', $new_member_data['hierarchy_index'], $new_member_id);
        $data[] = update_field('family_tree', $new_member_data['family_tree'], $new_member_id);

        // ob_start();

        // $data['post'] = ob_get_clean();

        $data['submit'] = 'Інформація успішно додана';
    } else {
        $data['error'] = 'Треба задати основну інформацію';
    }

    //$data[] = $brothers_and_sisters;

    echo json_encode($data);
    wp_die();
}
add_action('wp_ajax_member_info_add_new', 'member_info_add_new');
add_action('wp_ajax_nopriv_member_info_add_new', 'member_info_add_new');






/*
* member_add_picture
*/
function member_add_picture() {
    $user    = wp_get_current_user();
    $post_id = $_POST['post_id'];
    $data    = [];

    if (!empty($_FILES['picture'])) {
        $picture_id = media_handle_upload('picture', $post_id);
        set_post_thumbnail($post_id, $picture_id);
        $data['submit'] = 'Інформація успішно оновлена';
    }

    echo json_encode($data);
    wp_die();
}
add_action('wp_ajax_member_add_picture', 'member_add_picture');
add_action('wp_ajax_nopriv_member_add_picture', 'member_add_picture');





/* 
Gen Password for Tree
 */

// Add a custom metabox to the post editor screen
function add_password_metabox() {
    add_meta_box(
        'password-metabox',
        '4-Digit Password',
        'display_password_metabox',
        'wcl-family-tree', // Change 'post' to the post type where you want the metabox
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'add_password_metabox');

// Callback to display the metabox content
function display_password_metabox($post) {
    // Retrieve the existing password (if any)
    $existing_password = get_post_meta($post->ID, 'wcl_password_tree', true);
?>
    <div class="wcl-admin-sc-password">
        <label for="custom_password">Generated Password:</label>
        <input type="number" id="custom_password" pattern="[0-9]{4}" name="custom_password" value="<?php echo esc_attr($existing_password); ?>">
        <button type="button" id="generate_password">Generate New Password</button>
    </div>

    <script>
        // JavaScript to generate a 4-digit password and update the input field
        document.getElementById('generate_password').addEventListener('click', function() {
            var newPassword = Math.floor(1000 + Math.random() * 9000);
            document.getElementById('custom_password').value = newPassword;
        });

        document.getElementById('custom_password').addEventListener("input", function() {
            let inputField = this;
            let inputValue = inputField.value;

            // Remove any non-digit characters
            inputValue = inputValue.replace(/\D/g, '');

            // Truncate to at most four digits
            if (inputValue.length > 4) {
                inputValue = inputValue.slice(0, 4);
            }

            inputField.value = inputValue;
        });
    </script>
<?php
}

// Save the custom password when the post is updated or saved
function save_custom_password($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (isset($_POST['custom_password'])) {
        $custom_password = sanitize_text_field($_POST['custom_password']);
        update_post_meta($post_id, 'wcl_password_tree', $custom_password);
    }
}
add_action('save_post', 'save_custom_password');







/*
* enter_password_check
*/
function enter_password_check() {
    $password_user = $_POST['password'];
    $tree_id       = $_POST['tree_id'];

    $password_tree = get_post_meta($tree_id, 'wcl_password_tree', true);

    if (!empty($password_user)) {
        if ($password_user == $password_tree) {
            $data['submit'] = 'Пароль вірний';

            $expiration =  time() + 60 * 60 * 24; // 24 hours
            setcookie('wcl_allow_tree_' . $tree_id, $password_tree, $expiration, COOKIEPATH, COOKIE_DOMAIN);
        } else {
            $data['error'] = 'Неправильний пароль';
        }
    } else {
        $data['error'] = 'Будь ласка введіть пароль';
    }

    echo json_encode($data);
    wp_die();
}
add_action('wp_ajax_enter_password_check', 'enter_password_check');
add_action('wp_ajax_nopriv_enter_password_check', 'enter_password_check');
