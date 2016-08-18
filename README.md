# BEA Template Vars
Easily pass vars through a template and reuse them.

For exemple you have instantiate a model for the current post and you wanna display the post's toolbox (like, share, etc) and its comments without reinstantiate it in theses templates. When doing your get_template_part() you will have the possibility to pass to the called template the wanted PHP vars, like in this exemple, the model, or whatever.

It is quite well working with ACF values when working with mulitple flexible on your templates.

# How to add var(s)
You can pass a single value or an array of multiple ones.

## Add single value

Usage :  bea_add_template_var( {template_slug}, {key}, {value} );

```
// Post comments
bea_add_template_var( 'blocks/post/comments', 'post_m', $post_m );
get_template_part( 'blocks/post/comments' );
```

## Add multiple values

Usage : bea_add_template_vars( {template_slug}, array( {key1} => {value1}, {key2} => {value2}, {etc} ) );

```
// Post tools
bea_add_template_vars( 'blocks/post/tools', 'tools', array (
  'post_m'        => $post_m,
  'block_title'   => get_sub_field( 'title' ),
  'number_items'  => count( $collection ),
) );
get_template_part( 'blocks/post/tools' );
```

# How to get var(s)
Aswell, you can get a single value or multiple ones.

## Get a single value

Usage : bea_get_template_var( {template_slug}, {key}, {value} );

```
$post_m = bea_get_template_var( 'blocks/post/comments', 'post_m' );
if ( empty ( $post_m ) ) {
  // Leave as empty value
  return;
}
```

## Get multiple values

Usage : bea_get_template_vars( {template_slug}, array( {key1} => {value1}, {key2} => {value2}, {etc} ) );

```
$tools  = bea_get_template_vars( 'blocks/post/comments', array( 'block_title', 'post_m', 'number_items' ) );
$title  = $tools['block_title'];
$post_m = $tools['post_m'];
$max_items = $tools['number_items'];
```
