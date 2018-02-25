<?php
/**
 * Changelog
 */

$mastery = wp_get_theme( 'mastery' );

?>
<div class="featured-section changelog">
	

	<?php
	WP_Filesystem();
	global $wp_filesystem;
	$mastery_changelog       = $wp_filesystem->get_contents( get_template_directory() . '/changelog.txt' );
	$mastery_changelog_lines = explode( PHP_EOL, $mastery_changelog );
	foreach ( $mastery_changelog_lines as $mastery_changelog_line ) {
		if ( substr( $mastery_changelog_line, 0, 3 ) === '###' ) {
			echo '<h4>' . substr( $mastery_changelog_line, 3 ) . '</h4>';
		} else {
			echo $mastery_changelog_line, '<br/>';
		}
	}

	echo '<hr />';


	?>

</div>
