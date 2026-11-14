<?php

/**
 * Макет: Цитата / О нас (_about_quote)
 */

// Получаем значения полей (используем get_sub_field, так как это layout в гибком содержании)
$title    = get_sub_field('title');
$repeater = get_sub_field('repiter'); // Имя поля из вашего запроса
?>

<section class="about-quote-section">
    <div class="about-quote-container">

        <div class="about-quote-wrapper">
            <?php if ($title) : ?>
                <h2 class="about-quote-title">
                    <?php echo esc_html($title); ?>
                </h2>
            <?php endif; ?>

            <?php if (! empty($repeater) && is_array($repeater)) : ?>
                <div class="about-quote-tags">
                    <?php foreach ($repeater as $index => $row) :
                        $tag_text = $row['text'];
                        if (! $tag_text) continue;

                        // Добавляем индекс для уникального позиционирования каждого бейджа
                        $item_index = $index + 1;
                    ?>
                        <span class="quote-tag tag-id-<?php echo $item_index; ?>">
                            <?php echo esc_html($tag_text); ?>
                        </span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

    </div>
</section>