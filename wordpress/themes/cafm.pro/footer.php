<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage cafmpro
 * @since 1.0
 * @version 1.2
 */
?>
<div style="">
	<div class="footer wrap">
		<footer id="footer" class="site-footer" role="contentinfo" style=" height:auto; vertical-align: bottom;">
			<div class="wrap">
				<div class="box" style="position: relative;">
					<div class="copyright" style="position: relative;float:left;display:inline-block;">
						<?php
							echo '&copy;'.date("Y").' ';
							if (get_theme_mod('copyright')) {
								echo get_theme_mod('copyright');
							} else {
								bloginfo( 'name' );
							}
						?>
						<span class="copyright-customizer" style="position: absolute; right: -35px; top: -4px; font-size:0px; line-height:0px;">&#160;</span>
					</div>
					<div class="" style="display:inline-block;float:right;"> 
						<nav class="footer-nav main-navigation" style="">
							<ul id="footer-nav-menu" class="menu" style="position:relative;">
							<?php
								if ( has_nav_menu( 'footer-nav-menu' ) ) {
									$nav_args = array( 
										'container' => 'ul', 
										'items_wrap' => '%3$s',
										'menu_id' => 'xxxxx',
										'theme_location' => 'footer-nav-menu',
										#'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
									);
									wp_nav_menu( $nav_args ); 
								}
							?>
							</ul>
						</nav>
					</div>
					<span class="footer-customizer" style="position: absolute; right: 0; top: 0; font-size:0px; line-height:0px;">&#160;</span>
					<span style="clear:both;">&#160;</span>
				</div>
			</div>
		</footer>
	</div>
</div>

</div>
<script type="text/javascript">
//---------------------------------------------
// Adjust Canvas
//---------------------------------------------
function canvasAdjust( fixed ) {
	// todo handle page max
	let body = document.getElementsByTagName('body')[0];
	let canvas = document.getElementById('canvas');
	let wrap = document.querySelector('.canvas.wrap');
	let content = document.querySelector('#canvas .box');
	const num = ( int ) => (typeof(int) !== 'undefined' ? parseInt(int) : 0);

	size = 0;
	data = [];
	data['header'] = document.querySelector('.header.wrap');
	data['topnav'] = document.querySelector('.topnav.wrap')
	data['footer'] = document.querySelector('.footer.wrap');
	for (i in data) {
		bt = num(getComputedStyle(data[i]).borderTopWidth);
		bb = num(getComputedStyle(data[i]).borderBottomWidth);
		mt = num(getComputedStyle(data[i]).marginTop);
		mb = num(getComputedStyle(data[i]).marginBottom);
		height = (bt + bb + mt + mb) + data[i].offsetHeight;
		size = size + height;
	}

	bt = num(getComputedStyle(canvas).borderTopWidth);
	bb = num(getComputedStyle(canvas).borderBottomWidth);
	mt = num(getComputedStyle(wrap).marginTop);
	mb = num(getComputedStyle(wrap).marginBottom);
	mm = (bt + bb + mt + mb);
	height = (body.clientHeight-(mm+size));

	if( fixed ) {
		body.style.position = 'fixed';
		body.style.width = '100%';
		canvas.style.minHeight = '100px';
		canvas.style.overflow = 'auto';
		canvas.style.height = height+'px';
	} else {
		if(content.offsetHeight < height) {
			padd = parseInt(getComputedStyle(body).paddingRight);
			padd = "-"+padd+"px";
		
			body.style.position = 'fixed';
			body.style.width = '100%';
			body.style.marginLeft = padd;
		}
		canvas.style.minHeight = height+'px';
	}
}
<?php
if (get_theme_mod('js-adjust-canvas')) {
	if (get_theme_mod('js-scroll-canvas')) {
	echo "window.addEventListener( 'resize',  function() { canvasAdjust( true ); } );";
		echo "canvasAdjust( true );";
	} else {
		echo "window.addEventListener( 'resize',  function() { canvasAdjust(); } );";
		echo "canvasAdjust();";
	}
}
?>
</script>
<?php wp_footer(); ?>
</body>
</html>
