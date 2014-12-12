<?php
/**
 * The template for displaying category pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package DW Focus
 * @since DW Focus 1.0
 */

get_header(); ?>
    <div id="primary" class="site-content span9">
        <div class="entry-author">
            <?php if ( get_the_author_meta( 'description' ) ) : ?>
                <div class="author-info">
                    <div class="author-avatar">
                        <?php echo get_avatar( get_the_author_meta( 'user_email' ), 90 ); ?>
                    </div><!-- .author-avatar -->
                    <div class="author-description">
                        <h2><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author"><?php echo get_the_author(); ?></a></h2>

                        <p class="description"><?php the_author_meta( 'description' ); ?></p>

                        <?php if ( get_the_author_meta( 'user_url' ) ) : ?>
                        <p class="user-url">
                            <span><?php _e('Website URL:','dw_focus') ?></span> 
                            <a href="<?php the_author_meta( 'user_url' ); ?>" title="<?php the_author_meta( 'user_url' ); ?>">
                                <?php the_author_meta( 'user_url' ); ?>
                            </a> 
                        </p>
                        <?php endif; ?>

                        <?php if ( get_the_author_meta( 'aim' ) ) : ?>
                        <p class="aim">
                            <span><?php _e('AIM:','dw_focus') ?></span> 
                            <a href="aim:goaim?screenname=<?php the_author_meta( 'aim' ); ?>" title="<?php the_author_meta( 'aim' ); ?>"><?php the_author_meta( 'aim' ); ?></a>   
                        </p>
                        <?php endif; ?>

                        <?php if ( get_the_author_meta( 'yim' ) ) : ?>
                        <p class="yahoo">
                            <span><?php _e('Yahoo:','dw_focus') ?></span> 
                            <a href="ymsgr:sendim?<?php the_author_meta( 'yim' ); ?>" title="<?php the_author_meta( 'yim' ); ?>"><?php the_author_meta( 'yim' ); ?></a>   
                        </p>
                        <?php endif; ?>
                    </div><!-- .author-description -->
                </div><!-- .author-info -->
            <?php endif; ?>
        </div><!-- .entry-author -->

    	<div class="content-bar row-fluid">
           <h1 class="page-title author">Correspondente <?php 

	//	printf( __( 'Author Archives: %s', 'dw_focus' ), '<span class="vcard">'.get_the_author() ); 

	 $gns_id = get_the_author_meta("ID");
// user id 398 com problema, aparece 4892

if ($gns_id == 4892 ) {
	$all_meta_for_user = get_user_meta(398);
} else {

 $all_meta_for_user = get_user_meta($gns_id);

}

 $gns_nome = $all_meta_for_user['nome'][0];

if ( $gns_nome != "" ) {
	print_r( $gns_nome );			

//	echo $gns_id;	
} else {
 echo get_the_author();
//	print_r( $all_meta_for_user );		

//echo $gns_id;	
}	

	?></h1>

            <div class="post-layout">
                <a class="layout-list active" href="#"><i class="icon-th-list"></i></a>
                <a class="layout-grid" href="#"><i class="icon-th"></i></a>
            </div>
        </div>

        <?php 
            $no_results = '';
            if( ! have_posts() ) {
                $no_results = 'no-results';
            }

        ?>
        <div class="content-inner <?php echo $no_results ?>">
		<?php if ( have_posts() ) : ?>
            <?php global $archive_i; $archive_i = 1; ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part('content', 'archive'); ?>
                <?php $archive_i++; ?>
			<?php endwhile; ?>
		<?php else : ?>

			<?php get_template_part( 'no-results', 'archive' ); ?>

		<?php endif; ?>
        </div>
        <?php 
            dw_focus_pagenavi();
            wp_reset_query();
        ?>
	</div>
<?php get_sidebar( ); ?>
<?php get_footer(); ?>
