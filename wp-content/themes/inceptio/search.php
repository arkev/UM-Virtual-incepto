<?php get_header(); ?>

    <?php get_template_part('page-title'); ?>

    <!-- begin content -->
    <section id="content">
        <div class="container clearfix">

            <?php if ( have_posts() ) { ?>
                <p><?php global $wp_query; printf('%d ' . __('results found for', INCEPTIO_THEME_NAME) . ' &lsquo;%s&rsquo;.', $wp_query->found_posts, get_search_query()); ?></p>

                <!-- begin search results -->
                <ul id="search-results">
                    <?php while ( have_posts() ) { the_post(); ?>
                        <li>
                            <h2><a href="<?php the_permalink(); ?>"><?php echo inc_emphasize(get_the_title(), get_search_query());?></a></h2>
                            <p><?php echo inc_emphasize(inc_shrink_starting_from(get_the_excerpt(), get_search_query(), inc_get_search_results_excerpt_length(), inc_get_search_results_hellip()), get_search_query());?></p>
                            <p><a href="<?php the_permalink(); ?>"><?php the_permalink(); ?></a></p>
                        </li>
                    <?php } ?>
                </ul>
                <!-- end search results -->

                <!-- begin pagination -->
                <?php inc_pagination($wp_query->max_num_pages); ?>
                <!-- end pagination -->
            <?php } else { ?>
                <p><?php _e('Sorry, no posts matched your criteria. Please try and search again.', INCEPTIO_THEME_NAME); ?></p>
            <?php } ?>

        </div>
    </section>
    <!-- end content -->

<?php get_footer(); ?>