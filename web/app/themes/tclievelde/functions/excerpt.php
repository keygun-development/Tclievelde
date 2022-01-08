<?php

function tn_custom_excerpt_length( $length ) {
    return 35;
}
add_filter( 'excerpt_length', 'tn_custom_excerpt_length', 999 );

?>