<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package DW Focus
 * @since DW Focus 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta content="width=device-width, initial-scale=1.0, user-scalable=no" name="viewport">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.png" />
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?> >
	<header id="masthead" class="site-header" role="banner">
	    <div class="container">
	    	<div id="header">
	    		<div class="row">
	           		<div id="branding" class="span3 visible-desktop">
		                <h1>
		                	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
		                		<?php bloginfo( 'name' ); ?>
		                	</a>
		                </h1>
		            </div>

<div id="menu2">
        <nav id="site-navigation" class="main-navigation navbar" role="navigation">
		<div class="nav-collapse collapse">
			<ul id="menu-menu-institucional" class="nav">
				<li id="menu-item-1258" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1258 0"><a href="/o-projeto/">O projeto</a></li>
				<li id="menu-item-1249" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-parent-item menu-parent-item menu-item-1249 color-none 0">
					<a href="#">Como participar</a>
					<i class="sub-menu-collapse icon-chevron-down hidden-desktop"></i>
					<ul class="sub-menu">
						<li id="menu-item-1250" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-1250 color-none 1"><a href="/categoria/instrucoes/">Instruções</a></li>
						<li id="menu-item-1251" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-1251 color-none 1"><a href="/categoria/pautas">Pautas</a></li>
						<li id="menu-item-1252" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-1252 active color-none 1"><a href="/sugestao-de-pauta/">Sugestão de Pauta</a></li>
					</ul>
				</li>
				<li id="menu-item-1253" class="menu-item menu-item-type-post_type menu-item-object-page menu-item menu-item-1253 0"><a href="/correspondentes/">Correspondentes</a></li>
				<li id="menu-item-1260" class="menu-item menu-item-type-post_type menu-item-object-page menu-parent-item menu-parent-item menu-item-1253 0"><a href="#">UBS</a><i class="sub-menu-collapse icon-chevron-down hidden-desktop"></i>
					<ul class="sub-menu">
						<li id="menu-item-1261" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1255 active 1"><a href="/tag/castro-alves/">Castro Alves</a></li>
						<li id="menu-item-1262" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1254 1"><a href="/tag/gaivotas/">Gaivotas</a></li>
						<li id="menu-item-1263" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1256 1"><a href="/tag/jardim-eliane/">Jardim Eliane</a></li>
						<li id="menu-item-1264" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1257 1"><a href="/tag/jardim-ipora/">Jardim Iporã</a></li>
						<li id="menu-item-1265" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1255 active 1"><a href="/tag/jardim-santa-fe/">Jardim Santa Fé</a></li>
						<li id="menu-item-1266" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1254 1"><a href="/tag/jardim-silveira/">Jardim Silveira</a></li>
						<li id="menu-item-1267" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1256 1"><a href="/tag/marsilac/">Marsilac</a></li>
						<li id="menu-item-1268" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1257 1"><a href="/tag/recanto-campo-belo/">Recanto Campo Belo</a></li>
						<li id="menu-item-1269" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1256 1"><a href="/tag/vila-marcelo/">Vila Marcelo</a></li>
						<li id="menu-item-1270" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1257 1"><a href="/tag/vila-roschel/">Vila Roschel</a></li>
					</ul>
				</li>
				<li id="menu-item-1271" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1263 0"><a href="/parceiros/">Parceiros</a></li>
				<li id="menu-item-1271" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1263 0"><a href="/fale-com-a-gente/">Fale com a gente</a></li>
			</ul>
		</div>	
        </nav>
</div> <!-- #menu2 -->

<p id="bt-geral-part"><a href="/?page_id=1172" class="btn btn-primary btn-large btn-primary">Seja um correspondente</a></p>

		            <?php // if( is_active_sidebar( 'dw_focus_header' ) ) { ?>
		            <!--div id="sidebar-header" class="span9">
	            		<?php // dynamic_sidebar('dw_focus_header'); ?>
		            </div-->
			    <?php // } ?>

		        </div>
	        </div>
	        <?php 
	        	if( !is_handheld() ) :
			        $max_number_posts = dw_get_option('dw_menu_number_posts');
			        if( ! $max_number_posts ) {
			            $max_number_posts = 15;
			        }
			        if( $max_number_posts > 0 ) {
	        ?>
		            <div class="btn-group top-news">
				    	<?php dw_top15(); ?>
				    </div>
			<?php  
					} 
				endif; 
			?>

		    <div class="wrap-navigation">
		        <nav id="site-navigation" class="main-navigation navbar" role="navigation">
		            <div class="navbar-inner">
						<button class="btn btn-navbar" data-target=".nav-collapse" data-toggle="collapse"  type="button">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>

						<button class="collapse-search hidden-desktop" data-target=".search-collapse" data-toggle="collapse" >
							<i class="icon-search"></i>
						</button>

						<a class="small-logo hidden-desktop" rel="home" title="Geral na Sa&uacute;de" href="<?php echo esc_url( home_url( '/' ) ); ?>">Geral na Sa&uacute;de</a>
					
						<?php  
							// Social links
							$facebook = dw_get_option('dw_facebook');
							$twitter = dw_get_option('dw_twitter');
							$gplus = dw_get_option('dw_gplus');
							$linkedin = dw_get_option('dw_linkedin');
							$feedlink = dw_get_option('dw_feedlink', true);
							$loginlink = dw_get_option('dw_loginlink', true);
						?>
						<ul class="social-links">
							<?php if( $facebook ) { ?>
							<li class="facebook"><a target="_blank" href="<?php echo $facebook; ?>" title="<?php _e('Facebook','dw-focus') ?>"><i class="icon-facebook"></i></a></li>
							<?php } ?>
							<?php if( $twitter ) { ?>
							<li class="twitter"><a target="_blank" href="<?php echo $twitter;  ?>" title="<?php _e('Twitter','dw-focus') ?>"><i class="icon-twitter"></i></a></li>
							<?php } ?>
							<?php if(  $gplus ) { ?>
							<li class="google-plus"><a target="_blank" href="<?php echo $gplus ?>" title="<?php _e('Google Plus','dw-focus') ?>"><i class="icon-google-plus"></i></a></li>
							<?php } ?>
							<?php if( $linkedin ) { ?>
							<li class="linkedin"><a target="_blank" href="<?php echo $linkedin ?>" title="<?php _e('Linked in','dw-focus') ?>"><i class="icon-linkedin"></i></a></li>
							<?php } ?>
							<?php if( $feedlink ) { ?>
							<li class="rss"><a href="<?php bloginfo('rss2_url'); ?>" title="<?php _e('Rss','dw-focus') ?>"><i class="icon-rss"></i></a></li>
							<?php } ?>
							<?php if( $loginlink ) { ?>
							<li class="login"><a href="<?php echo wp_login_url( get_permalink() ); ?>" title="<?php _e('Login','dw-focus') ?>"><i class="icon-user"></i></a>
							<?php } ?>
						</ul><!-- End social links -->

						<div class="search-collapse collapse">
							<?php get_search_form( $echo = true ); ?>
						</div>

						<div class="nav-collapse collapse">
							<?php if (!is_handheld()) {
							  $params = array(
							  	    'theme_location'  => 'primary',
									'container'       => '',
									'menu_class'      => 'nav',
									'fallback_cb'    => 'link_to_menu_editor'
							  	);
							  	$params['walker']  = new DW_Mega_Walker();

							  }
							else{	  $params = array(
							  	    'theme_location'  => 'secondary',
									'container'       => '',
									'menu_class'      => 'nav',
									'fallback_cb'    => 'link_to_menu_editor'
							  	);

							  	$params['walker']	=	new DW_Mega_Walker_Mobile();
							  }
								wp_nav_menu($params);
							?>
						</div>	
		            </div>
		        </nav>

		        <div id="under-navigation" class="clearfix under-navigation">
		        	<div class="row-fluid">
		        		<?php $offset = ''; ?>
		        		<?php if( is_active_sidebar( 'dw_focus_under_navigation' ) ) { ?>
		        		<!-- Under navigation positions ( breadcrum, twitter widgets) -->
			        	<div class="span9">
							<?php dynamic_sidebar('dw_focus_under_navigation'); ?>
						</div>
						<?php } else { $offset = 'offset9';  }?>

						<div class="span3 <?php echo $offset; ?>"><?php get_search_form(); ?></div>
					</div>
			    </div>
		    </div>
	    </div>
	</header> <!-- End header -->

	<div id="main">
         <div class="container">
             <div class="row">
