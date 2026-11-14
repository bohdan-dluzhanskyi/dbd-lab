<?php
$title = get_sub_field('title');
$cards = get_sub_field('card');
?>
<section class="benefits">
    <div class="container">
        <div class="benefits__grid">
            <?php if ($title): ?>
                <div class="benefits__main-card">
                    <h2 class="benefits__main-title"><?php echo wp_kses_post($title); ?></h2>
                </div>
            <?php endif; ?>

            <?php if ($cards): ?>
                <div class="benefits__content-subgrid">
                    <?php foreach ($cards as $card):
                        $subtitle = $card['subtitle'];
                        $description = $card['description'];
                    ?>
                        <article class="benefits__card">
                            <?php if ($subtitle): ?>
                                <h3 class="benefits__card-subtitle"><?php echo esc_html($subtitle); ?></h3>
                            <?php endif; ?>
                            <?php if ($description): ?>
                                <p class="benefits__card-description"><?php echo esc_html($description); ?></p>
                            <?php endif; ?>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>