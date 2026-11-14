<?php

/**
 * Макет: Навчання та підтримка (_steps)
 */

$main_title = get_sub_field('main-title'); // Имя поля из вашего запроса
$subtitle   = get_sub_field('subtitle');   // Имя поля из вашего запроса
$steps      = get_sub_field('step');       // Имя поля-репитера из вашего запроса
?>

<section class="steps-section">
    <div class="container">

        <div class="steps-header">
            <?php if ($main_title) : ?>
                <h2 class="steps-main-title">
                    <?php echo wp_kses_post($main_title); ?>
                </h2>
            <?php endif; ?>

            <?php if ($subtitle) : ?>
                <p class="steps-subtitle">
                    <?php echo nl2br(wp_kses_post($subtitle)); ?>
                </p>
            <?php endif; ?>
        </div>

        <?php if (! empty($steps) && is_array($steps)) : ?>
            <div class="steps-grid">
                <?php foreach ($steps as $index => $step) :
                    $step_title = $step['title'];
                    $step_desc  = $step['description'];
                    if (! $step_title && ! $step_desc) continue;

                    $step_number = $index + 1;
                ?>
                    <div class="step-item">
                        <div class="step-meta">
                            <span class="step-number"><?php echo $step_number; ?></span>
                            <div class="step">
                                <?php if ($step_title) : ?>
                                    <h3 class="step-title">
                                        <?php echo esc_html($step_title); ?>
                                    </h3>
                                <?php endif; ?>
                                <?php if ($step_desc) : ?>
                                    <p class="step-desc">
                                        <?php echo nl2br(esc_html($step_desc)); ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>


                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</section>