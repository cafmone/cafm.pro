<?php get_header(); ?>
<div class="canvas box">
	<div class="canvas wrap">
		<div id="canvas" style="position: relative;">
			<div class="box" style="">
				<div id="primary" class="content-area" style="">

<?php get_template_part( 'template-parts/breadcrumbs' ); ?>
<div style="">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="entry-header">
			<?php the_title( '<h3 class="entry-title">', '</h3>' ); ?>
		</div>
		<div class="entry-content">
			<?php 
			the_content();
			#$time =  get_option( 'date_format' ).' '.get_option( 'time_format' );
			#if ( get_the_modified_time( 'U' ) > get_the_time( 'U' ) ) {
			#	echo '<small class="article-date">'.__('Last updated').': '.get_the_modified_time($time).'</small>';
			#} else {
			#	echo '<small class="article-date">'.__('Published').': '.get_the_time($time).'</small>';
			#}
			 ?>
		</div>
	</article>
</div>

					<span style="display:block;clear:both; line-height:0px;font-size:0px">&#160;</span>
				</div>
				<span class="canvas-customizer" style="position: absolute; right: 0; top: 0; font-size:0px; line-height:0px;">&#160;</span>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>
