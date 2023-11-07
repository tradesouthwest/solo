<?php 
/**
 * Page options settings and helpers
 * @since 1.0
 * @package solo
 */
add_action( 'wp_head', 'solo_theme_customizer_css');

/**
 * Text sanitizer for numeric values
 * @since 1.0
 * @see https://themefoundation.com/wordpress-theme-customizer/
 * @return string $input
 */
function solo_sanitize_integer( $input ) {
    if( is_numeric( $input ) ) {
        return intval( $input );
    }
} 

/**
 * Text sanitizer for outputs
 * @since 1.0
 * 
 * @return string $input
 */
function solo_sanitize_text( $input ) {
    return wp_kses_post( force_balance_tags( $input ) );
}

/**
 * Send custum CSS to wp_head
 * @since 1.0
 * 
 */
function solo_theme_customizer_css() {
    echo '<style id="solo-theme-mods">';
    if ( get_theme_mods() ) : 
        $background_color = get_background_color();
        $cpaddg    = get_theme_mod( 'solo_padding_content', '20' );
        $pcolor    = get_theme_mod( 'solo-font-color', '#444444' );
        $linkcolor = get_theme_mod( 'solo-link-color', '#19299f' );
        $b2color   = get_theme_mod( 'solo_second-background', '#fefefe' ); 
        $calign    = get_theme_mod( 'solo_content_align', 'left' ); 
        $cposit    = get_theme_mod( 'solo_hero_callposition', '12' ); 
        $hheight   = get_theme_mod( 'solo_hero_bkgheight', '520' ); 
    
    echo normalize_whitespace(
    'body{ background-color: #' . esc_attr( $background_color ) . ';}.entry-content, .excerpt-content, li, h2, h3, h4 {color: ' . esc_attr( $pcolor ) . ';}
    #nav_button{background: linear-gradient(to bottom,  ' . esc_attr( $linkcolor ) . ' 0%,  ' . esc_attr( $linkcolor ) . ' 100%);}a, .solo-blog .article-heading .post-title a{color: ' . esc_attr( $linkcolor ) . ';}.page-nav a,button,input[type="submit"]{color: ' . esc_attr( $linkcolor ) . ';background: ' . esc_attr( $b2color ) . ';}
    @media screen and (min-width: 900px){.solo-blog .section-content, .inner_content{ padding-left: ' . esc_attr( $cpaddg ) . 'px;padding-right: ' . esc_attr( $cpaddg ) . 'px;text-align:' . esc_attr( $calign ) .'; }
    .page-header{padding: calc(.5 * ' . esc_attr( $cpaddg ) . 'px);padding-bottom: 0;}}
    ');
    
    endif;
    echo '</style>';
}
