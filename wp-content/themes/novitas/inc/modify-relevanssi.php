<?php

/**
* Add query variables
*/
add_filter( 'query_vars', 'relevanssi_qvs' );

function relevanssi_qvs( $qv ) {
  $qv[] = 'filter_type';
  $qv[] = 'categories';
  $qv[] = 'brand';

  return $qv;
}

/**
* Search only this categories and/or tags
*/
add_filter( 'relevanssi_modify_wp_query', 'relevanssi_modify_qv' );

function relevanssi_modify_qv( $query ) {
  $tax_query = array();
  $cats_and_tags = ! empty( get_query_var( 'categories' ) ) ? get_query_var( 'categories' ) : '';

  $tax_query[] = array(
    'taxonomy' => 'product_type',
    'field' => 'slug',
    'terms' => array( 'grouped' ),
    'operator' => 'NOT IN'
    );
  $tax_query['relation'] = 'AND';

  if ( ! empty( $cats_and_tags ) && $cats_and_tags != 'any' ) {
    $tax_query[] = array(
      'taxonomy' => 'product_cat',
      'field' => 'term_id',
      'terms' => $cats_and_tags
      );
    $tax_query[] = array(
      'taxonomy' => 'product_tag',
      'field' => 'term_id',
      'terms' => $cats_and_tags
      );
  }

  if ( ! empty( $tax_query ) ) {
    $tax_query['relation'] = 'OR';
    $query->set( 'tax_query', $tax_query );
  }

  return $query;
}

/**
* Search without a search term
*/
// add_filter( 'relevanssi_search_ok', 'relevanssi_search_trigger' );

// function relevanssi_search_trigger( $search_ok ) {
//   global $wp_query;

//   if ( ! empty( $wp_query->query_vars['categories'] ) ) {
//     $search_ok = true;
//   }

//   return $search_ok;
// }

// add_action( 'relevanssi_hits_filter', 'allow_null_search' );

// function allow_null_search( $hits ) {
//   global $wp_query;

//   if ( $hits[0] == null ) {
//     $filter_type = ! empty( get_query_var( 'filter_type' ) ) ? get_query_var( 'filter_type' ) : '';
//     $post_types = $filter_type == 'product' ? 'product' : array( 'post', 'news' );
//     $cats_and_tags = ! empty( get_query_var( 'categories' ) ) ? get_query_var( 'categories' ) : '';
//     // no search hits, so must create new
//     $args = array(
//       'post_type' => $post_types,
//       'posts_per_page' => 12,
//       'tax_query' => array(
//         'relation' => 'OR',
//         array(
//           'taxonomy' => 'product_cat',
//           'field' => 'term_id',
//           'terms' => $cats_and_tags
//           ),
//         array(
//           'taxonomy' => 'product_tag',
//           'field' => 'term_id',
//           'terms' => $cats_and_tags
//           )
//         )
//       );

//     $hits[0] = get_posts( $args );
//   }
//   else {
//     // posts available, take only those that match the conditions
//     $ok = array();

//     foreach ( $hits[0] as $hit ) {
//       if ( is_singular( $post_types ) && has_term( $cats_and_tags, 'product_cat' ) )
//         array_push( $ok, $hit );
//     }

//     $hits[0] = $ok;
//   }

//   return $hits;
// }

/**
* Relevanssi - Don't Remove Ampersand
*/
add_filter( 'relevanssi_remove_punctuation', 'saveampersands_1', 9 );

function saveampersands_1( $a ) {
  $a = str_replace( '&amp;', 'AMPERSAND', $a );
  $a = str_replace( '%26', 'AMPERSAND', $a );
  $a = str_replace( '&', 'AMPERSAND', $a );

  return $a;
}

add_filter( 'relevanssi_remove_punctuation', 'saveampersands_2', 11 );

function saveampersands_2( $a ) {
  $a = str_replace( 'AMPERSAND', '&', $a );

  return $a;
}

/**
* Relevanssi - Index Parent Categories
*/
add_filter( 'relevanssi_content_to_index', 'rlv_parent_categories', 10, 2 );

function rlv_parent_categories( $content, $post ) {
  $categories = get_the_terms( $post->ID, 'product_cat' ); // Taxonomy name

  if ( is_array( $categories ) ) {
    foreach ( $categories as $category ) {
      if ( ! empty( $category->parent ) ) {
        $parent = get_term( $category->parent, 'product_cat' ); // Taxonomy name
        $content .= $parent->name;
      }
    }
  }

  return $content;
}

/**
* Relevanssi - Search Form
*
* If you want to use this search form shortcode please use this syntax:
*   <?php echo do_shortcode( '[search_form]' ); ?>
*/
add_shortcode( 'search_form', 'rlv_search_form' );

$search_form_id_iterator = 1;

function rlv_search_form() {
  global $wp_query;
  global $search_form_id_iterator;

  // NOTE: Please, change ID of search page
  $search_page_id = apply_filters( 'wpml_object_id', 566, 'page', true, ICL_LANGUAGE_CODE );
  $url = esc_url( get_permalink( $search_page_id ) );
  $placeholder = __( 'Search', 'novitas' );

  $form = '<div class="ka-general-search-form">';
  $form .= '<form role="search" method="get" id="search-form-' . $search_form_id_iterator . '" action="' . $url . '" autocomplete="off">';
  $form .= '<input type="text" name="search" class="mrgvlovani-14 ka-search-text-field" value="' . $placeholder . '" data-placeholder="' . $placeholder . '" />';
  $form .= '<input type="submit" name="search-submit-' . $search_form_id_iterator . '" value="' . __( 'Search', 'novitas' ) . '" class="ka-search-submit" />';
  $form .= '</form>';
  $form .= '</div>';

  $search_form_id_iterator++;

  return $form;
}
