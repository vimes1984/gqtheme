<?php 
	$postmeta = get_post_meta($post->ID);
?>
<header>
	<?php if(isset($postmeta["wpcf-video-id"][0])){ ?>
		<?php $videoid = $postmeta["wpcf-video-id"][0]; ?>
		<div class="flex-video">
			<iframe width="560" height="315" src="//www.youtube.com/embed/<?php echo $videoid; ?>?controls=0&fs=0&modestbranding=1&rel=0&showinfo=0&theme=light"  frameborder="0" allowfullscreen></iframe>
		</div>
	<?php } ?> 
	<?php if($postmeta["wpcf-h1-title"][0] == ""){ ?>
		<h1 class="bold entry-title"><?php the_title(); ?></h1>
	<?php }else{ ?>
		<h2 class="bold"><?php echo $postmeta["wpcf-h1-title"][0]; ?></h2>
		<h3 class="subheader"><?php echo $postmeta["wpcf-h2-title"][0];  ?></h3>
	<?php } ?>
</header>