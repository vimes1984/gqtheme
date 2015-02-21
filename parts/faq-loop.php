<?php 
/**
 * Faq's Loop
 */
	wp_reset_query(); 
	
	$faq_loop = new WP_Query( array(   'post_type' => 'question', 'posts_per_page' => '-1')); 
?>
<dl class="accordion" data-accordion>
	<?php 
		while ( $faq_loop->have_posts() ) : $faq_loop->the_post(); 
			$faq_meta = get_post_meta($post->ID);
			$faq_guid = $post->ID;
	?>
	<dd>
		<a href="#panel<?php echo $faq_guid; ?>"><?php the_title(); ?></a>
		<div id="panel<?php echo $faq_guid; ?>" class="content">
			<?php echo $faq_meta['wpcf-answer'][0]; ?>
		</div>
	</dd>
	<?php endwhile; ?>
</dl>