OpenGraphCake
=============

A CakePHP 2.x Plugin that helps to generate Open Graph Protocol compliant meta tags


# How to use

## Model Behavior
	class Product extends AppModel {

		public $actsAs = array(
			'OpenGraphCake.OpenGraphable' => array(
				'fields' => array(
					'url' => 'full_product_url',
					'type' => 'og_type',
				)
			)
		);


## Controller Component

## View Helper