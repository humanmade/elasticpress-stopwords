<?php
/**
 * @package         ElasticPress\StopWords
 */

namespace ElasticPress\StopWords;

use ElasticPress\Features as Features;

function bootstrap() : void {
	add_action( 'plugins_loaded', __NAMESPACE__ . '\\register_feature', 11 );
}

function register_feature() : void {
	if ( ! class_exists( 'ElasticPress\Features' ) ) {
		return;
	}

	require __DIR__ . '/class-stopwords.php';
	Features::factory()->register_feature( new StopWords );
}
