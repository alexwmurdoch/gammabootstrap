<?php
/**
 * @package alphabootstrap
 */
if ( ! function_exists('alphabootstrap_option') ) {
    function alphabootstrap_option($id, $fallback = false, $param = false ) {
        global $redux_demos;
        if ( $fallback == false ) $fallback = '';
        $output = ( isset($redux_demos[$id]) && $redux_demos[$id] !== '' ) ? $redux_demos[$id] : $fallback;
        if ( !empty($redux_demos[$id]) && $param ) {
            $output = $redux_demos[$id][$param];
        }
        return $output;
    }
}

