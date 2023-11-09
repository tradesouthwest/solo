<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package solo
 * @since 1.0
 */

get_header(); ?>

<main id="site-content" class="main-default solo-blog" aria-label="Start of content">
    <section aria-labelledby="articles found" class="section-content">
    
    <?php if ( have_posts() ) : ?>

        <div aria-labelledby="posts" class="solo-loop">

            <?php while ( have_posts() ) : the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> 
                itemscope itemtype="https://schema.org/Article">
        
                <h3 class="article-heading">

                <?php do_action( 'solo_heading_metadata' ); ?>

                </h3>
    
                <div class="inner_content">

                <?php if ( is_home() || ( is_category() || is_archive() ) ) { ?>
                    
                    <?php if ( has_post_thumbnail() ) { ?>
                    
                    <div class="maxheight-sm">

                        <?php do_action( 'solo_excerpt_attachment' ); ?>
                        <span class="solo-inlined-excerpt">
                    <?php 
                    if ( has_excerpt() ) {
                        the_excerpt();
                    } ?>
                </span>

                    </div>

                    <?php } // Ends if has thumbnail ?>

                <?php the_content( '', true );  ?>

                <?php 
                } else { 
                ?>

                    <div class="after-excrpt">
                        <p class="after-cats"><span><small><?php esc_html_e('Categorized as: ', 'solo'); ?>
                            </small></span> <small><em><?php the_category( ' &bull; ' ); ?></em></small>
                        </p>
                    </div>

                    <?php the_content( '', false ); ?>
                
                <?php 
                } // Ends is blog or archive ?>

                </div>
            </article>

            <?php 
            endwhile; // Ends looping thru posts, or print page ?>
        </div>

            <nav class="pagination-nav">
        
                <?php do_action( 'solo_check_pagination' ); ?>
                
                <div class="nav-previous alignleft">
                    <?php previous_posts_link( '<span class="prvpst-nav"> < </span>' ); ?>
                </div>
                <div class="nav-next alignright">
                    <?php next_posts_link( '<span class="nxtpst-nav"> > </span>' ); ?>
                </div>
                
            </nav>
    <?php 
    // if no content found
    else : ?>
            
            <div class="post-content">
		        
            <?php echo esc_url( home_url('/') ); ?>
            
            </div>

    <?php 
    endif; ?>
    
    </section>
</main>
<?php get_footer(); ?>
