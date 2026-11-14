<?php

/**
 * Layout: _inform
 */

$title             = get_sub_field('title');
$subtitle          = get_sub_field('subtitle');
$date              = get_sub_field('date');
$intro_description = get_sub_field('description');
?>

<section class="inform">
    <div class="inform__container">
        <?php if ($title || $subtitle || $date) : ?>
            <div class="inform__header">
                <?php if ($title) : ?>
                    <h1 class="inform__title"><?php echo esc_html($title); ?></h1>
                <?php endif; ?>

                <?php if ($subtitle) : ?>
                    <p class="inform__subtitle"><?php echo esc_html($subtitle); ?></p>
                <?php endif; ?>

                <?php if ($date) : ?>
                    <p class="inform__date"><?php echo esc_html($date); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ($intro_description) : ?>
            <div class="inform__intro">
                <p class="inform__description">
                    <?php echo nl2br(esc_html($intro_description)); ?>
                </p>
            </div>
        <?php endif; ?>

        <?php if (have_rows('list')) : ?>
            <div class="inform__body">
                <?php while (have_rows('list')) : the_row();
                    $list_title = get_sub_field('list-title');
                ?>
                    <div class="inform__group">
                        <?php if ($list_title) : ?>
                            <h2 class="inform__group-title"><?php echo esc_html($list_title); ?></h2>
                        <?php endif; ?>

                        <?php if (have_rows('list-item')) : ?>
                            <div class="inform__items">
                                <?php while (have_rows('list-item')) : the_row();
                                    $description = get_sub_field('list-description');
                                ?>
                                    <?php if ($description) : ?>
                                        <p class="inform__description">
                                            <?php echo nl2br(esc_html($description)); ?>
                                        </p>
                                    <?php endif; ?>
                                <?php endwhile; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
    </div>
</section>