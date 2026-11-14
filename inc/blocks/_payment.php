<?php
$terms = get_sub_field('terms');
$steps = get_sub_field('steps');
$financing = get_sub_field('financing');
?>
<section class="payment">
    <div class="container">
        <div class="payment__wrapper">

            <?php if ($terms):
                $terms_title = $terms['terms-title'];
                $terms_list = $terms['terms-list'];
            ?>
                <div class="payment__block">
                    <?php if ($terms_title): ?>
                        <h2 class="payment__title"><?php echo wp_kses_post($terms_title); ?></h2>
                    <?php endif; ?>
                    <?php if ($terms_list): ?>
                        <ul class="payment__list">
                            <?php
                            // Разделяем полученный из textarea текст по переносу строки
                            $lines = explode("\n", str_replace("\r", "", $terms_list));
                            foreach ($lines as $line):
                                $line = trim($line);
                                if (empty($line)) continue;
                            ?>
                                <li class="payment__text">
                                    <?php echo wp_kses_post($line); ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>

            <?php endif; ?>

            <?php if ($steps):
                $steps_title = $steps['steps-title'];
                $steps_list = $steps['steps-list'];
                $p_text = $steps['p'];
            ?>
                <div class="payment__block">
                    <?php if ($steps_title): ?>
                        <h2 class="payment__title"><?php echo wp_kses_post($steps_title); ?></h2>
                    <?php endif; ?>
                    <?php if ($steps_list): ?>
                        <div class="payment__steps">
                            <?php foreach ($steps_list as $step):
                                $step_title = $step['steps-title'];
                                $step_desc = $step['steps-description'];
                            ?>
                                <article class="payment__step-item">
                                    <?php if ($step_title): ?>
                                        <h3 class="payment__step-title"><?php echo esc_html($step_title); ?></h3>
                                    <?php endif; ?>
                                    <?php if ($step_desc): ?>
                                        <p class="payment__step-desc"><?php echo esc_html($step_desc); ?></p>
                                    <?php endif; ?>
                                </article>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($p_text): ?>
                        <p class="payment__note"><?php echo esc_html($p_text); ?></p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if ($financing):
                $fin_title = $financing['financing-title'];
                $fin_desc = $financing['financing-description'];
                $fin_list = $financing['list'];
            ?>
                <div class="payment__block">
                    <?php if ($fin_title): ?>
                        <h2 class="payment__title"><?php echo wp_kses_post($fin_title); ?></h2>
                    <?php endif; ?>
                    <?php if ($fin_desc): ?>
                        <p class="payment__description"><?php echo esc_html($fin_desc); ?></p>
                    <?php endif; ?>
                    <?php if ($fin_list): ?>
                        <div class="payment__financing-list">
                            <?php foreach ($fin_list as $item):
                                $item_title = $item['list-title'];
                                $item_desc = $item['list-description'];
                            ?>
                                <div class="payment__financing-item">
                                    <?php if ($item_title): ?>
                                        <h3 class="payment__financing-title"><?php echo esc_html($item_title); ?></h3>
                                    <?php endif; ?>
                                    <?php if ($item_desc): ?>
                                        <p class="payment__financing-desc"><?php echo esc_html($item_desc); ?></p>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

        </div>
    </div>
</section>