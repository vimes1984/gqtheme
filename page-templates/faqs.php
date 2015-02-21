<?php
/*
Template Name: Faq page
*/
get_header(); ?>
<?php get_template_part('parts/page-banner'); ?>
    <div class="row">
        <div class="small-12 large-8 columns" role="main">

        <?php do_action('foundationPress_before_content'); ?>

        <?php while (have_posts()) : the_post(); ?>
            <article <?php post_class() ?> id="post-<?php the_ID(); ?>">
                <?php get_template_part('parts/header-titles'); ?>

                <?php do_action('foundationPress_page_before_entry_content'); ?>
                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
                <?php do_action('foundationPress_page_before_comments'); ?>
                <?php comments_template(); ?>
                <?php do_action('foundationPress_page_after_comments'); ?>
            </article>
        <?php endwhile;?>
        <?php get_template_part('parts/faq-loop'); ?>

        <?php do_action('foundationPress_after_content'); ?>

        </div>

    <?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
