<div class="seperator"></div>
<div class="row">
	<div class="large-12 columns">
		<h2>Featured Products</h2>
	</div>
</div>
<div class="row">
	<div class="large-4 columns">
		<div class="panel">
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda facilis libero dolorum, debitis? Eaque repellendus, nisi deserunt dignissimos placeat aut laborum commodi cumque amet maiores odit, ipsa iusto voluptate quis.</p>
		</div>
	</div>
	<div class="large-4 columns">
		<div class="panel">
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda facilis libero dolorum, debitis? Eaque repellendus, nisi deserunt dignissimos placeat aut laborum commodi cumque amet maiores odit, ipsa iusto voluptate quis.</p>
		</div>
	</div>
	<div class="large-4 columns">
		<div class="panel">
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda facilis libero dolorum, debitis? Eaque repellendus, nisi deserunt dignissimos placeat aut laborum commodi cumque amet maiores odit, ipsa iusto voluptate quis.</p>
		</div>
	</div>
	<div class="owl-carousel">
	  <div> Your Content </div>
	  <div> Your Content </div>
	  <div> Your Content </div>
	  <div> Your Content </div>
	  <div> Your Content </div>
	  <div> Your Content </div>
	  <div> Your Content </div>
	</div>
<?php 
		$args = array(
			'post_type' => 'product',
			'tax_query' => array(
				array(
					'taxonomy' => 'product_tag',
					'field'    => 'slug',
					'terms'    => 'homepage',
				),
			),
		);
	// the query
	$the_query = new WP_Query( $args ); ?>
	<!-- pagination here -->

	<!-- the loop -->
	<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
		<h2><?php the_title(); ?></h2>
	<?php endwhile; ?>
	<!-- end of the loop -->

	<!-- pagination here -->

	<?php wp_reset_postdata(); ?>
</div>