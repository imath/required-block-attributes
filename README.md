# Required Block Attributes

WordPress plugin to check required block attributes are set before a post is published or updated.

This plugin includes an example of block using the "required attribute" feature. To play with it, simply define the `WP_DEBUG` constnat of your wp-config.php file to `true`.

To enjoy the feature for any other blocks simply use an the `requiredAttributes` property of your `registerBlockType()` function like the [example block is doing](https://github.com/imath/required-block-attributes/blob/master/src/block/index.js#L42,L46). 
