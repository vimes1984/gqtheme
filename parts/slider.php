<?php

	$postmeta = get_post_meta($post->ID);
	$slidername = $postmeta["wpcf-slider-name"][0];
	$sliderbg = $postmeta["wpcf-slider-background"][0];

?>
<style type="text/css">
	#homepage-hero{
		background: url("<?php echo $sliderbg; ?>") repeat scroll 0 0 #074e68;
	}
</style>
<header id="homepage-hero" class="header-slider hide-for-small-only" role="banner">
	<div class="row">
		<ul class="example-orbit" data-orbit data-options=" animation:slide; bullets:false; slide_number: false; timer: false;">
			<?php

			 	$slider_loop = new WP_Query( array( 'slider-name' => $slidername,  'post_type' => 'slider'));
			 	while ( $slider_loop->have_posts() ) : $slider_loop->the_post();
			 		$slidermeta = get_post_meta($post->ID);
			?>
			  		<li>
			  			<div class="row">
				  			<div class="large-12 medium-12 columns">
				  				<a href="<?php echo $slidermeta["wpcf-slider-link"][0]; ?>">
										<img alt="<?php the_title(); ?>" src="<?php echo $slidermeta["wpcf-slider-image"][0]; ?>" />
									</a>

				  			</div>
			  			</div>
			  		</li>
				<?php endwhile; ?>
				<?php wp_reset_query(); ?>
		</ul>
	</div>
</header>
