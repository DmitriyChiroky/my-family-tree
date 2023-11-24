<?php

get_header();

?>

<main id="wcl-page-content" class="wcl-page-content">

    <?php
    if (have_rows('page_content')) {
        while (have_rows('page_content')) {
            the_row();

            if (get_row_layout() == 'section_1') {
                get_template_part('template-parts/section-1');
            } elseif (get_row_layout() == 'section_1') {
                get_template_part('template-parts/section-1');
            }
        }
    } else {
        if (have_posts()) {
            while (have_posts()) {
                the_post();  ?>
                <div class="wcl-page">
                    <div class="data-container">
                        <h1 class="data-title">
                            <?php echo get_the_title(); ?>
                        </h1>

                        <div class="data-content">
                            <?php echo get_the_content(); ?>
                        </div>
                    </div>
                </div>
    <?php
            }
        }
    }
    ?>

</main>

<?php

get_footer();

?>