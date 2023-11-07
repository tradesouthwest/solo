<?php
/**
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your ClassicPress site will use a different template.
 *
 * @package solo
 * @since solo 1.0
 */

get_header(); ?>
  
<main class="main-default solo-single">
    <section class="section-content">

        <?php while ( have_posts() ) : the_post(); ?>
        
        <div class="solo-loop">
            <h2 class="article-heading"><?php the_title(); ?></h2>
            
            <div class="solo-featured-excerpt">

                <?php do_action( 'solo_render_attachment' ); ?>

                <span class="solo-inlined-excerpt">
                    <?php 
                    if ( has_excerpt() ) {
                        the_excerpt();
                    } ?>
                </span>
            
            </div>

                <div class="inner_content">

                    <?php the_content( ); ?>

                </div>

            <aside class="after-content">
                <p class="after-cats"><span><small><?php esc_html_e('By: ', 'solo'); ?></span> 
                    <em><?php the_author(); ?></em></small>
                | <span><small><?php esc_html_e('Categorized as: ', 'solo'); ?></span> 
                    <em><?php the_category( ' &bull; ' ); ?></em></small>
                | <span><small><?php esc_html_e('Keys: ', 'solo'); ?></span> 
                    <em><?php the_tags( ' ' ); ?></em></small>
                | <span><small><?php esc_html_e('Added on: ', 'solo'); ?></span> 
                    <em><?php the_date(); ?></em></small></p>
            </aside>

            <?php 
            // If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			} ?>

        </div>
            
        <?php endwhile; ?>

    </section>
</main>

<?php get_footer(); ?>