<?php
$check = get_sub_field('check');
$methods = get_sub_field('methods');
$payment = get_sub_field('payment');
?>
<section class="delivery">
    <div class="container">
        <div class="delivery__wrapper">

            <?php if ($check):
                $check_title = $check['check-title'];
                $check_list = $check['check-list'];
            ?>
                <div class="delivery__block">
                    <?php if ($check_title): ?>
                        <h2 class="delivery__title"><?php echo wp_kses_post($check_title); ?></h2>
                    <?php endif; ?>

                    <?php if ($check_list): ?>
                        <ul class="delivery__check-list">
                            <?php foreach ($check_list as $item):
                                $item_title = $item['check-list-title'];
                                $item_desc = $item['check-list-description'];
                            ?>
                                <li class="delivery__check-item">
                                    <article>
                                        <?php if ($item_title): ?>
                                            <h3 class="delivery__check-title"><?php echo esc_html($item_title); ?></h3>
                                        <?php endif; ?>
                                        <?php if ($item_desc): ?>
                                            <p class="delivery__check-desc"><?php echo esc_html($item_desc); ?></p>
                                        <?php endif; ?>
                                    </article>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if ($methods):
                $methods_title = $methods['methods-title'];
                $methods_list = $methods['methods-list'];
            ?>
                <div class="delivery__block">
                    <?php if ($methods_title): ?>
                        <h2 class="delivery__title"><?php echo wp_kses_post($methods_title); ?></h2>
                    <?php endif; ?>

                    <?php if ($methods_list): ?>
                        <ul class="delivery__methods-list">
                            <?php foreach ($methods_list as $method):
                                $method_title = $method['methods-list-title'];
                                $method_desc = $method['methods-list-description'];
                            ?>
                                <li class="delivery__method-card">
                                    <?php if ($method_title): ?>
                                        <h3 class="delivery__method-name"><?php echo esc_html($method_title); ?></h3>
                                    <?php endif; ?>
                                    <?php if ($method_desc): ?>
                                        <p class="delivery__method-time"><?php echo esc_html($method_desc); ?></p>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if ($payment):
                $payment_title = $payment['payment-title'];
                $payment_desc = $payment['payment-description'];
                $p_text = $payment['p'];
            ?>
                <div class="delivery__block">
                    <?php if ($payment_title): ?>
                        <h2 class="delivery__title"><?php echo wp_kses_post($payment_title); ?></h2>
                    <?php endif; ?>

                    <?php if ($payment_desc): ?>
                        <div class="delivery__payment-desc">
                            <?php
                            $lines = explode("\n", str_replace("\r", "", $payment_desc));
                            foreach ($lines as $line):
                                $line = trim($line);
                                if (empty($line)) continue;
                            ?>
                                <p><?php echo wp_kses_post($line); ?></p>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($p_text): ?>
                        <p class="delivery__note"><?php echo esc_html($p_text); ?></p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

        </div>
    </div>
</section>