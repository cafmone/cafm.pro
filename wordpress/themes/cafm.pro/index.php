<?php get_header(); ?>
<div class="canvas box">
	<div class="canvas wrap">
		<div id="canvas" style="">
			<div class="box" style="position: relative;">
				<div id="primary" class="content-area" style="">
					<?php
					while ( have_posts() ) :
						the_post();
						get_template_part( 'template-parts/post', get_post_format() );
					endwhile;
					?>
					<span style="clear:both; line-height:0px;font-size:0px">&#160;</span>
				</div>
				<span class="canvas-customizer" style="position: absolute; right: 0; top: 0; font-size:0px; line-height:0px;">&#160;</span>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>
