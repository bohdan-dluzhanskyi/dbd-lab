<?php

/**
 * Шаблон каталога и категорий товаров
 */

get_header(); ?>

<main class="catalog-page">
    <div class="container">

        <nav class="catalog-breadcrumbs">
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

        <section class="catalog-header">
            <h1 class="catalog-title"><?php woocommerce_page_title(); ?></h1>
            <?php if (is_product_category()) : ?>
                <div class="catalog-description">
                    <?php echo category_description(); ?>
                </div>
            <?php endif; ?>
        </section>

        <section class="catalog-bar">
            <div class="bar-search">
                <form role="search" method="get" action="">
                    <span class="search-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://w3.org">
                            <path d="M14.3333 14.3333L19 19M10.4444 15.8889C7.43756 15.8889 5 13.4513 5 10.4444C5 7.43756 7.43756 5 10.4444 5C13.4513 5 15.8889 7.43756 15.8889 10.4444C15.8889 13.4513 13.4513 15.8889 10.4444 15.8889Z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" stroke="#00C4C4" />
                        </svg>
                    </span>
                    <?php $current_search = isset($_GET['f_search']) ? sanitize_text_field(wp_unslash($_GET['f_search'])) : ''; ?>
                    <input type="search" class="search-input" placeholder="<?php echo esc_attr(pll__('Пошук')); ?>" value="<?php echo esc_attr($current_search); ?>" name="f_search" />
                </form>
            </div>


            <div class="bar-filter">
                <div class="filter-dropdown-toggle">
                    <span><?php pll_e('Категорії'); ?></span>
                </div>
                <div class="filter-dropdown-content">
                    <form method="get" action="">
                        <div class="checkbox-list">
                            <?php
                            $current_term = get_queried_object();
                            $parent_id = (is_product_category()) ? $current_term->term_id : 0;
                            $subcategories = get_terms(array(
                                'taxonomy'   => 'product_cat',
                                'parent'     => $parent_id,
                                'hide_empty' => false,
                            ));

                            if (! empty($subcategories) && ! is_wp_error($subcategories)) {
                                foreach ($subcategories as $subcat) {
                                    $is_checked = (isset($_GET['f_sub']) && in_array($subcat->slug, (array)$_GET['f_sub'])) ? 'checked' : '';

                                    echo '<label class="checkbox-item">';
                                    echo '<input type="checkbox" name="f_sub[]" value="' . esc_attr($subcat->slug) . '" ' . $is_checked . '>';
                                    echo '<span>' . esc_html($subcat->name) . '</span>';
                                    echo '</label>';
                                }
                            } else {
                                echo '<p class="no-subcats">' . pll__('Немає підкатегорій') . '</p>';
                            }
                            ?>
                        </div>
                        <button type="submit" class="c-btn c-btn--filled fixed" style="width: 100%; border-radius: 100px;"><?php pll_e('Застосувати'); ?></button>
                    </form>
                </div>



            </div>

            <div class="bar-sort">
                <?php
                $current_orderby = isset($_GET['orderby']) ? sanitize_text_field($_GET['orderby']) : 'title';

                $sort_options = array(
                    'price'      => pll__('За ціною: від нижчої'),
                    'price-desc' => pll__('За ціною: від вищої'),
                    'title'      => pll__('За алфавітом'),
                );

                $active_text = isset($sort_options[$current_orderby]) ? $sort_options[$current_orderby] : $sort_options['title'];
                ?>

                <div class="sort-dropdown-toggle">
                    <span class="c-btn__icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6 15.4286L8.57143 18L11.1429 15.4286M8.57143 18V6M18 8.57143L15.4286 6L12.8571 8.57143M15.4286 6V18" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" stroke="white" />
                        </svg>
                    </span>
                    <span><?php echo esc_html($active_text); ?></span>
                </div>

                <ul class="sort-dropdown-content">
                    <?php foreach ($sort_options as $id => $name) :
                        $sort_url = add_query_arg('orderby', $id);
                        $is_active = ($current_orderby === $id) ? 'is-active' : '';
                    ?>
                        <li class="<?php echo $is_active; ?>">
                            <a href="<?php echo esc_url($sort_url); ?>"><?php echo esc_html($name); ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

        </section>

        <section class="catalog-results" id="catalog-ajax-container">
            <?php if (have_posts()) : ?>

                <div class="products-grid">
                    <?php while (have_posts()) : the_post();
                        $price_usd   = get_field('price_usd', get_the_ID());
                        $usd_rate    = get_field('dollar_rate', 'option');
                        $final_price = (!empty($price_usd) && !empty($usd_rate)) ? ($price_usd * $usd_rate) : 0;
                    ?>
                        <article class="product-card">
                            <a href="<?php the_permalink(); ?>" class="product-card__link">

                                <div class="product-card__thumb">
                                    <?php
                                    if (has_post_thumbnail()) {
                                        the_post_thumbnail('medium', array('class' => 'product-card__img'));
                                    } else {
                                        echo '<img src="' . wc_placeholder_img_src() . '" alt="Placeholder" class="product-card__img">';
                                    }
                                    ?>
                                </div>

                                <span class="product-card__category">
                                    <?php
                                    $terms = get_the_terms(get_the_ID(), 'product_cat');
                                    if (! empty($terms) && ! is_wp_error($terms)) {
                                        echo esc_html($terms[0]->name);
                                    }
                                    ?>
                                </span>

                                <h3 class="product-card__title"><?php the_title(); ?></h3>

                                <div class="product-card__price-box">
                                    <div class="product-card__footer">
                                        <div>
                                            <?php
                                            $product = wc_get_product(get_the_ID());
                                            $usd_rate = floatval(get_field('dollar_rate', 'option'));
                                            $eur_rate = floatval(get_field('euro_rate', 'option'));

                                            if ($product instanceof WC_Product_Variable) {
                                                $price_usd      = floatval($product->get_variation_price('min', true));
                                                $woo_reg_price  = floatval($product->get_variation_regular_price('min', true));
                                                $woo_sale_price = floatval($product->get_variation_sale_price('min', true));
                                            } else {
                                                $woo_reg_price  = floatval($product->get_regular_price());
                                                $woo_sale_price = floatval($product->get_sale_price());
                                                $price_usd      = $woo_sale_price ? $woo_sale_price : $woo_reg_price;
                                            }
                                            ?>


                                            <div class="product-card__meta">
                                                <?php
                                                if ($price_usd > 0) {
                                                    $output = number_format($price_usd, 0, '.', '') . '$';

                                                    if ($usd_rate > 0 && $eur_rate > 0) {
                                                        $price_eur = ($price_usd * $usd_rate) / $eur_rate;
                                                        $output .= ' / ' . number_format($price_eur, 0, '.', '') . '€';
                                                    }

                                                    echo $output;
                                                }
                                                ?>
                                            </div>

                                            <div class="product-card__prices">
                                                <?php
                                                if ($price_usd > 0 && $usd_rate > 0) {
                                                    $final_price_uah = $price_usd * $usd_rate;

                                                    echo '<span class="product-card__price-actual">' . number_format($final_price_uah, 0, '.', ' ') . ' ₴</span>';

                                                    if ($woo_sale_price > 0 && $woo_reg_price > $woo_sale_price) {
                                                        $old_price_uah = $woo_reg_price * $usd_rate;
                                                        echo '<span class="product-card__price-old">' . number_format($old_price_uah, 0, '.', ' ') . ' ₴</span>';
                                                    }
                                                } else {
                                                    echo '<span class="product-card__price-actual">' . pll__('Ціна за запитом') . '</span>';
                                                }
                                                ?>
                                            </div>
                                        </div>

                                        <div class="c-btn c-btn--filled product-card__btn">
                                            <span class="c-btn__icon">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://w3.org">
                                                    <path d="M10 8L14 12L10 16" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" stroke="white" />
                                                </svg>
                                            </span>
                                        </div>
                                    </div>
                                </div>


                            </a>
                        </article>

                    <?php endwhile; ?>
                </div>

                <div class="catalog-pagination">
                    <?php echo paginate_links(array(
                        'prev_text' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
  <path d="M14 16L10 12L14 8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" stroke="white" />
</svg>',
                        'next_text' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
  <path d="M10 8L14 12L10 16" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" stroke="white" />
</svg>',
                        'type'      => 'list'
                    )); ?>
                </div>

            <?php else : ?>

                <div class="catalog-empty">
                    <h2 class="empty-title"><?php pll_e('Нічого не знайдено'); ?></h2>
                    <p class="empty-text"><?php pll_e('На жаль, за вашим запитом нічого не знайдено.'); ?></p>
                    <a href="<?php echo esc_url(strtok($_SERVER["REQUEST_URI"], '?')); ?>" class="c-btn c-btn--outlined">
                        <?php pll_e('Очистити пошук'); ?>
                    </a>
                </div>

            <?php endif; ?>
        </section>

        <section class="text-promo text-promo--bg-light-blue catalog-promo">
            <div class="text-promo__container">
                <div class="text-promo__content">
                    <h2 class="text-promo__title">
                        <?php pll_e('Не знаєте, яке обладнання підійде саме вам?'); ?>
                    </h2>
                    <p class="text-promo__text">
                        <?php pll_e('Розкажіть про ваш бізнес, послуги та задачі – ми допоможемо підібрати оптимальне рішення.'); ?>
                    </p>
                    <div class="text-promo__buttons-wrap">
                        <button class="c-btn c-btn--filled c-btn--icon-right open-callback-modal" data-modal="consultation">
                            <span><?php pll_e('Отримати консультацію'); ?></span>
                        </button>
                    </div>
                </div>
            </div>
        </section>

    </div>
</main>

<?php get_footer(); ?>