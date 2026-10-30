<?php
/*
Template Name: Головна сторінка
*/
get_header(); ?>

<main class="main-homepage">
    <?php
   
    if (have_rows('homepage_blocks')) :
        while (have_rows('homepage_blocks')) : the_row();

            get_template_part('inc/blocks/' . get_row_layout());

        endwhile;
    endif;
    ?>
</main>

<?php get_footer(); ?>