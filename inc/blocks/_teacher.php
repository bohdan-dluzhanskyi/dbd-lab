<?php
$name = get_sub_field('name');
$description = get_sub_field('description');
$image_layout = get_sub_field('image-layout');
$photo = get_sub_field('photo');
$select = get_sub_field('select');
$education = get_sub_field('education');

$layout_class = ($image_layout === 'right') ? 'teacher--image-right' : 'teacher--image-left';
?>
<section class="teacher <?php echo esc_attr($layout_class); ?>">
    <div class="container">
        <div class="teacher__inner">

            <div class="teacher__image-col">
                <?php if ($photo): ?>
                    <div class="teacher__photo-wrapper">
                        <?php echo wp_get_attachment_image($photo['ID'], 'large', false, array('class' => 'teacher__photo', 'loading' => 'lazy')); ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="teacher__content-col">
                <?php if ($name): ?>
                    <h2 class="teacher__name"><?php echo wp_kses_post($name); ?></h2>
                <?php endif; ?>

                <?php if ($description): ?>
                    <p class="teacher__description"><?php echo esc_html($description); ?></p>
                <?php endif; ?>

                <?php if ($select && $education):
                    $edu_title = $education['title'];
                    $edu_price = $education['prise'];
                    $edu_report = $education['report'];
                ?>
                    <div class="teacher__education">
                        <?php if ($edu_title || $edu_price): ?>
                            <div class="teacher__education-header">
                                <?php if ($edu_title): ?>
                                    <h3 class="teacher__education-title"><?php echo esc_html($edu_title); ?></h3>
                                <?php endif; ?>
                                <?php if ($edu_price): ?>
                                    <span class="teacher__education-price"><?php echo esc_html($edu_price); ?></span>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($edu_report): ?>
                            <p class="teacher__education-report"><?php echo esc_html($edu_report); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</section>