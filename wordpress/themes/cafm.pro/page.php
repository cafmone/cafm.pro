<?php get_header(); ?>
<div class="canvas box">
	<div class="canvas wrap">
		<div id="canvas" style="">
			<div class="box" style="position: relative;">
				<div id="primary" class="content-area" style="">
				
				
												<a href="#" target="_blank">Link</a>
				
				<?php
					while ( have_posts() ) :
						the_post();
					?>
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<div class="entry-header">
								<?php 
									#the_title( '<h1 class="entry-title">', '</h1>' );
									#wp_list_pages(array('child_of'=>50));
									#wentyseventeen_edit_link( get_the_ID() );
								?>
							</div>
							<div class="entry-content">
								<?php
									the_content();
								?>
							</div>
						</article>

						<?php
						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;
						?>

					<?php endwhile; // End of the loop. ?>
					<span style="clear:both; line-height:0px;font-size:0px">&#160;</span>
				</div>
				<span class="canvas-customizer" style="position: absolute; right: 0; top: 0; font-size:0px; line-height:0px;">&#160;</span>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>
