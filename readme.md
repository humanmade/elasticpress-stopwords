<table width="100%">
	<tr>
		<td align="left" width="70">
			<strong>ElasticPress Stopwords</strong><br />
			Integrates WordPress stopwords and filters with ElasticPress mapping.
		</td>
		<td rowspan="2" width="20%">
			<img src="https://hmn.md/content/themes/hmnmd/assets/images/hm-logo.svg" width="100" />
		</td>
	</tr>
	<tr>
		<td>
			 A Human Made project
		</td>
	</tr>
</table>

ElasticPress stopwords allows developers to customize stopwords functionality of Elastic through linking ElasticPress mapping with WordPress default stopwords list and using related filter `wp_search_stopwords`.

## Requirements

- PHP >= 7.1
- WordPress >= 5.3
- ElasticPress >= 3.4.3 (not tested with older versions)

## Getting Set Up

### Install Using Composer

```
composer require humanmade/elasticpress-stopwords
```

Load the plugin

```php
require_once __DIR__ . '/vendor/humanmmade/elastic-stopwords/plugin.php';
```

---

Once you've installed the plugin, use the following code to manage stopwords:

```PHP
add_filter( 'wp_search_stopwords', function( array $stopwords ) : array {
    $words_to_remove = [ 'foo' ];
    $words_to_add    = [ 'bar' ];
    return array_merge( array_diff( $stopwords, $words_to_remove ), $words_to_add );
} );
```

## Credits

Created by Human Made with :heart:

Written and maintained by [Shady Sharaf](https://github.com/shadyvb).

Interested in joining in on the fun? [Join us, and become human!](https://hmn.md/is/hiring/)
