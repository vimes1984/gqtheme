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
				  			<div class="large-8 medium-8 columns">
				  				<h2><?php the_title(); ?></h2>
				  				<?php the_content(); ?>
				  				<p>&nbsp;</p>
				  			</div>
				  			<div class="large-4 medium-4 columns">
				  				<?php the_post_thumbnail(); ?>
				  			</div>
			  			</div>
			  		</li> 
				<?php endwhile; ?>
				<?php wp_reset_query(); ?>
		</ul>
	</div>
</header>