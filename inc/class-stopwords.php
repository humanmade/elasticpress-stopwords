<?php
/**
 * Stop words feature
 *
 * @package ElasticPress\StopWords
 */

namespace ElasticPress\StopWords;

use \ElasticPress\Feature as Feature;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * StopWords feature class
 */
class Stopwords extends Feature {

	/**
	 * Initialize feature setting it's config
	 */
	public function __construct() {
		$this->slug                     = 'stopwords';
		$this->title                    = esc_html__( 'Stop Words', 'elasticpress-stopwords' );
		$this->requires_install_reindex = true;
		$this->default_settings         = [
			'stopwords' => [],
		];

		parent::__construct();
	}

	/**
	 * Output feature box summary
	 */
	public function output_feature_box_summary() {
		?>
		<p><?php esc_html_e( 'Use stop words WordPress to replace Elastic stop filter default words.', 'elasticpress-stopwords' ); ?></p>
		<?php
	}

	/**
	 * Output feature box long
	 */
	public function output_feature_box_long() {
		?>
		<p><?php esc_html_e( 'Note that this replaces the more robust default Elastic stopwords functionality, that can work with multiple languages.', 'elasticpress-stopwords' ); ?></p>
		<?php
	}

	/**
	 * Setup feature functionality
	 */
	public function setup() : void {
		add_filter( 'ep_post_mapping', [ $this, 'mapping' ] );
	}

	/**
	 * Return the list of stop words, based on WordPress defaults and after being filtered via wp_search_stopwords
	 *
	 * @return array
	 */
	public function get_wp_search_stopwords() : array {
		// This is the default WordPress list of stop words
		$default_list = explode( ',', 'about,an,are,as,at,be,by,com,for,from,how,in,is,it,of,on,or,that,the,this,to,was,what,when,where,who,will,with,www' );

		return apply_filters( 'wp_search_stopwords', $default_list );
	}

	/**
	 * Display settings on dashboard.
	 */
	public function output_feature_box_settings() : void {
		?>
		<div class="field" data-feature="<?php echo esc_attr( $this->slug ); ?>">
			<div class="field-name status"><label for="feature_stopwords"><?php esc_html_e( 'Stop words:', 'elasticpress-stopwords' ); ?></label></div>
			<div class="input-wrap">
				<textarea disabled class="setting-field" id="feature_stopwords"><?php echo implode( ', ', array_map( 'esc_html', $this->get_wp_search_stopwords() ) ); ?></textarea>
				<p class="field-description"><?php esc_html_e( 'These are the current stop words configured in WordPress, filter using `wp_search_stopwords` WordPress filter.', 'elasticpress-stopwords' ); ?></p>
			</div>
		</div>
		<?php
	}

	/**
	 * Add mapping for suggest fields
	 *
	 * @param  array $mapping ES mapping.
	 *
	 * @return array
	 */
	public function mapping( $mapping ) {
		// Remove the standard stop filter, and add a new custom_stopfilter one
		$mapping['settings']['analysis']['analyzer']['default']['filter'] = array_merge(
			array_diff(
				$mapping['settings']['analysis']['analyzer']['default']['filter'],
				[ 'stop' ]
			),
			[ 'custom_stopfilter' ]
		);

		// Define the new custom_stopfilter entry
		$mapping['settings']['analysis']['filter']['custom_stopfilter'] = [
			'type'        => 'stop',
			'ignore_case' => true,
			'stopwords'   => $this->get_wp_search_stopwords(),
		];

		return $mapping;
	}
}
