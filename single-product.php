<?php

/**
 * Шаблон страницы кастомного товара
 */

get_header(); ?>

<main class="product-page">
    <div class="container">

        <?php if (have_posts()) : while (have_posts()) : the_post();
                $product = wc_get_product(get_the_ID());

                // Базовый расчет цены по курсу
                $price_usd = floatval($product->get_regular_price());
                $woo_sale_price = floatval($product->get_sale_price());
                $active_price_usd = $woo_sale_price ? $woo_sale_price : $price_usd;

                $usd_rate = floatval(get_field('dollar_rate', 'option'));
                $eur_rate = floatval(get_field('euro_rate', 'option'));

                $final_price_uah = ($active_price_usd > 0 && $usd_rate > 0) ? ($active_price_usd * $usd_rate) : 0;
                $final_price_eur = ($final_price_uah > 0 && $eur_rate > 0) ? ($final_price_uah / $eur_rate) : 0;


        ?>

                <nav class="product-breadcrumbs">
                    <?php woocommerce_breadcrumb(array(
                        'delimiter'   => ' <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
  <path d="M10 8L14 12L10 16" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" stroke="#626262" />
</svg> ',
                        'wrap_before' => '<ul class="breadcrumbs-list">',
                        'wrap_after'  => '</ul>',
                        'before'      => '<li>',
                        'after'       => '</li>',
                    )); ?>
                </nav>

                <div class="product-main">

                    <div class="product-media">
                        <div class="product-gallery">
                            <?php
                            $attachment_ids = $product->get_gallery_image_ids();

                            $youtube_url = get_field('product_youtube_url');
                            $youtube_id = '';
                            if (!empty($youtube_url)) {
                                preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/|youtube\.com/shorts/)([^"&?/ ]{11})%i', $youtube_url, $match);
                                $youtube_id = !empty($match[1]) ? $match[1] : '';
                            }

                            if (!empty($attachment_ids) || !empty($youtube_id)) : ?>
                                <div class="product-gallery__thumbs">
                                    <div class="thumb-item is-active" data-type="image" data-full="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'large')); ?>">
                                        <?php the_post_thumbnail('thumbnail'); ?>
                                    </div>

                                    <?php if (!empty($attachment_ids)) : ?>
                                        <?php foreach ($attachment_ids as $attachment_id) : ?>
                                            <div class="thumb-item" data-type="image" data-full="<?php echo esc_url(wp_get_attachment_image_url($attachment_id, 'large')); ?>">
                                                <?php echo wp_get_attachment_image($attachment_id, 'thumbnail'); ?>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>

                                    <?php if (!empty($youtube_id)) : ?>
                                        <div class="thumb-item thumb-item--video" data-type="video" data-youtube-id="<?php echo esc_attr($youtube_id); ?>">
                                            <div class="thumb-video-stub">
                                                <span class="thumb-video-icon" aria-hidden="true">
                                                    <svg width="14" height="16" viewBox="0 0 28 32" fill="none" xmlns="http://w3.org">
                                                        <path d="M26.5 13.4019C28.5 14.5566 28.5 17.4434 26.5 18.5981L4.75 31.1554C2.75 32.3101 0.25 30.8668 0.25 28.5574L0.25 3.44263C0.25 1.13323 2.75 -0.310142 4.75 0.844558L26.5 13.4019Z" fill="white" />
                                                    </svg>
                                                </span>
                                            </div>
                                        </div>
                                    <?php endif; ?>



                                </div>
                            <?php endif; ?>

                            <div class="product-gallery__main">
                                <div class="main-image-wrap">
                                    <button class="gallery-nav-btn gallery-nav-btn--prev" id="gallery-prev" aria-label="Previous image">
                                        <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://w3.org">
                                            <path d="M4.75 8.75L0.75 4.75L4.75 0.75" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" stroke="white" />
                                        </svg>
                                    </button>

                                    <?php
                                    $main_img_url = has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'full') : wc_placeholder_img_src();
                                    ?>

                                    <a href="<?php echo esc_url($main_img_url); ?>" data-fancybox="gallery" id="main-product-lightbox-link" class="main-image-link">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <?php the_post_thumbnail('large', array('id' => 'main-product-img', 'loading' => 'eager', 'fetchpriority' => 'high')); ?>
                                        <?php else : ?>
                                            <img src="<?php echo wc_placeholder_img_src(); ?>" id="main-product-img" alt="Placeholder">
                                        <?php endif; ?>
                                    </a>

                                    <div id="main-product-video-wrap" class="main-video-wrap" style="display: none;"></div>

                                    <button class="gallery-nav-btn gallery-nav-btn--next" id="gallery-next" aria-label="Next image">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://w3.org">
                                            <path d="M10 8L14 12L10 16" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" stroke="white" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="product-info">

                        <div class="product-info__category-wraper">
                            <span class="product-info__category">
                                <?php
                                $terms = get_the_terms(get_the_ID(), 'product_cat');
                                if (! empty($terms) && ! is_wp_error($terms)) {
                                    echo esc_html($terms[0]->name);
                                }
                                ?>
                            </span>

                            <?php
                            $custom_sku = get_field('custom_sku');

                            if (! empty($custom_sku)) : ?>
                                <span class="product-info__sku">
                                    <strong><?php echo esc_html($custom_sku); ?></strong>
                                </span>
                            <?php endif; ?>
                        </div>
                        <div class="product-info__content-wraper">

                            <h1 class="product-info__title"><?php the_title(); ?></h1>

                            <div class="product-info__desc">
                                <?php the_excerpt(); ?>
                            </div>
                        </div>

                        <?php if ($product->is_type('variable')) :
                            $variable_product = new WC_Product_Variable($product->get_id());
                            $variations = $variable_product->get_available_variations();
                            $usd_rate = floatval(get_field('dollar_rate', 'option'));
                            $eur_rate = floatval(get_field('euro_rate', 'option'));

                            $js_variations = array();
                            foreach ($variations as $variation) {
                                $reg_price_usd = floatval($variation['display_regular_price']);
                                $price_uah = $reg_price_usd * $usd_rate;

                                $meta_html = number_format($reg_price_usd, 0, '.', '') . '$';
                                if ($eur_rate > 0) {
                                    $price_eur = $price_uah / $eur_rate;
                                    $meta_html .= ' / ' . number_format($price_eur, 0, '.', '') . '€';
                                }

                                $js_variations[] = array(
                                    'attributes' => $variation['attributes'],
                                    'price_html' => number_format($price_uah, 0, '.', ' ') . ' ₴',
                                    'meta_html'  => $meta_html
                                );
                            }

                        ?>
                            <div class="product-info__variants" id="woo-dynamic-variations" data-variations="<?php echo esc_attr(json_encode($js_variations)); ?>">
                                <span class="variant-label"><?php pll_e('Потужність:'); ?></span>
                                <div class="variant-list">
                                    <?php
                                    $attributes = $variable_product->get_variation_attributes();
                                    if (isset($attributes['pa_potuzhnist']) || isset($attributes['Потужність'])) {
                                        $power_options = isset($attributes['pa_potuzhnist']) ? $attributes['pa_potuzhnist'] : $attributes['Потужність'];
                                        $loop_index = 0;
                                        foreach ($power_options as $option) {
                                            $active_class = ($loop_index === 0) ? 'is-active' : '';
                                            echo '<button class="variant-btn ' . $active_class . '" data-variant-slug="' . esc_attr($option) . '">' . esc_html($option) . '</button>';
                                            $loop_index++;
                                        }
                                    }
                                    ?>
                                </div>
                            </div>

                            <div class="product-info__price-box">
                                <p class="price"><?php pll_e('Ціна:'); ?></p>
                                <div class="price-meta">
                                    <span id="meta-currency-price"></span>
                                </div>
                                <div class="price-actual-wrap ">
                                    <div class="price-actual">
                                        <span id="actual-uah-price"></span>
                                    </div>
                                    <p class="price-notice"><?php pll_e('Ціни вказані без урахування доставки'); ?></p>
                                </div>
                            </div>

                        <?php else : ?>
                            <div class="product-info__price-box">
                                <p class="price"><?php pll_e('Ціна:'); ?></p>
                                <div class="price-meta">
                                    <span>
                                        <?php
                                        echo number_format($active_price_usd, 0, '.', '') . '$';
                                        if ($final_price_eur > 0) {
                                            echo ' / ' . number_format($final_price_eur, 0, '.', '') . '€';
                                        }
                                        ?>
                                    </span>
                                </div>

                                <div class="price-actual-wrap ">
                                    <div class="price-actual">
                                        <span><?php echo $final_price_uah ? number_format($final_price_uah, 0, '.', ' ') . ' ₴' : pll__('Ціна за запитом'); ?></span>
                                    </div>
                                    <p class="price-notice"><?php pll_e('Ціни вказані без урахування доставки'); ?></p>
                                </div>
                            </div>
                        <?php endif; ?>



                        <div class="product-info__actions">
                            <button class="c-btn c-btn--filled open-callback-modal" data-modal="order-proposal">
                                <?php pll_e('Отримати комерційну пропозицію'); ?>
                            </button>
                        </div>
                    </div>

                </div>

                <section class="product-details">
                    <h2 class="details-section-title"><?php pll_e('Технічні характеристики'); ?></h2>
                    <div class="details-grid">
                        <?php
                        $raw_specs = get_field('tech_specs_fast');

                        if (! empty($raw_specs)) :
                            $lines = explode("\n", str_replace("\r", "", $raw_specs));

                            echo '<ul>';
                            foreach ($lines as $line) {
                                $line = trim($line);
                                if (empty($line)) continue;

                                if (strpos($line, ':') !== false) {
                                    list($spec_name, $spec_value) = explode(':', $line, 2);

                                    $spec_name  = trim($spec_name);
                                    $spec_value = trim($spec_value);

                                    if (! empty($spec_name) && ! empty($spec_value)) {
                        ?>
                                        <li>
                                            <span><?php echo esc_html($spec_name); ?></span>
                                            <strong><?php echo esc_html($spec_value); ?></strong>
                                        </li>
                        <?php
                                    }
                                }
                            }
                            echo '</ul>';
                        endif;
                        ?>
                    </div>
                </section>


                <?php
                $raw_features = get_field('prod_features_fast');

                if (!empty($raw_features)) :
                    $lines = explode("\n", str_replace("\r", "", $raw_features));

                    $features_data = array();
                    $current_section = '';

                    foreach ($lines as $line) {
                        $line = trim($line);
                        if (empty($line)) continue;

                        if (substr($line, -1) === ':') {
                            $current_section = rtrim($line, ':');
                            $features_data[$current_section] = array();
                        } else if (!empty($current_section)) {
                            $cleaned_item = ltrim($line, '-*+ ');
                            if (!empty($cleaned_item)) {
                                $features_data[$current_section][] = $cleaned_item;
                            }
                        }
                    }

                    if (!empty($features_data)) : ?>
                        <section class="product-features">
                            <?php foreach ($features_data as $section_title => $items) : ?>
                                <div class="feature-col">
                                    <h3><?php echo esc_html($section_title); ?></h3>
                                    <?php if (!empty($items)) : ?>
                                        <ul class="feature-list">
                                            <?php foreach ($items as $item) : ?>
                                                <li>
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M6 12L10.2426 16.2426L18.727 7.75732" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" stroke="#00C4C4" />
                                                    </svg>
                                                    <?php echo esc_html($item); ?>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </section>
                    <?php endif; ?>
                <?php endif; ?>



                <?php
                $current_lang = function_exists('pll_current_language') ? pll_current_language() : 'uk';
                if ($current_lang === 'uk') :
                ?>
                    <section class="product-finance">
                        <h2 class="finance-main-title">Оплата частинами та фінансування</h2>
                        <div class="finance-grid">
                            <div class="finance-card">
                                <h4>Оплата частинами та кредит</h4>
                                <p>Доступні через Sense Bank, monobank, Ощадбанк і Unex Банк. Умови оформлення визначає банк.</p>
                            </div>
                            <div class="finance-card">
                                <h4>Лізинг</h4>
                                <p>Співпрацюємо з лізинговими компаніями Світ Фінанс.</p>
                            </div>
                            <div class="finance-card">
                                <h4>Грантове фінансування</h4>
                                <p>Для придбання обладнання можна скористатися грантовими програмами на суму від 250 000 грн до 2 500 000 грн.</p>
                            </div>
                        </div>
                    </section>
                <?php endif; ?>

                <section class="text-promo text-promo--bg-light-blue text-promo--has-padding">
                    <div class="text-promo__container">
                        <div class="text-promo__content">
                            <h2 class="text-promo__title"><?php pll_e('Знайдемо рішення для вашого бізнесу'); ?></h2>
                            <p class="text-promo__text"><?php pll_e('Допоможемо підібрати обладнання, відповімо на запитання та надамо детальну інформацію щодо придбання.'); ?></p>
                            <div class="text-promo__buttons-wrap">
                                <button class="c-btn c-btn--filled" data-modal="consultation"><?php pll_e('Отримати консультацію'); ?></button>
                            </div>
                        </div>
                    </div>
                </section>

        <?php endwhile;
        endif; ?>

    </div>
</main>

<?php get_footer(); ?>