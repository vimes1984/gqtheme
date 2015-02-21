<?php
/*
Template Name: Full width slider 
*/
get_header(); ?>
<?php get_template_part('parts/slider'); ?>
<?php get_template_part('parts/home-grid'); ?>

	<div class="row">
		<div class="small-12 large-12 columns" role="main">

		<?php do_action('foundationPress_before_content'); ?>

		<?php while (have_posts()) : the_post(); ?>
			<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
				<?php get_template_part('parts/header-titles'); ?>

				<?php do_action('foundationPress_page_before_entry_content'); ?>
				<div class="entry-content">
					<?php the_content(); ?>
				</div>
				<footer>
					<?php wp_link_pages(array('before' => '<nav id="page-nav"><p>' . __('Pages:', 'FoundationPress'), 'after' => '</p></nav>' )); ?>
					<p><?php the_tags(); ?></p>
				</footer>
				<?php do_action('foundationPress_page_before_comments'); ?>
				<?php comments_template(); ?>
				<?php do_action('foundationPress_page_after_comments'); ?>
			</article>
		<?php endwhile;?>

		<?php do_action('foundationPress_after_content'); ?>

		</div>
</div>
<?php get_template_part('parts/home-products'); ?>

<?php get_footer(); ?>
