<?php get_header();?>

<div id="mainDevelopers">
	<div class="container d-flex align-items-center justify-content-center">
		<h1>Developers list</h1>
	</div>

</div>



<div class="container">

<div class="content">
	<?php if(have_posts()) : while(have_posts()) : the_post();?>
		<?php if ($author_id = get_post_meta(get_the_ID(), 'wp_post_editor', true)) { ?>
      Developer: <?php echo get_the_author_meta('display_name', $author_id); ?>
<?php } ?>
	<?php endwhile; else: endif;?>

</div>






<?php get_footer();?>