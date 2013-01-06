<?php

function zm_event_by_region(  $region=null, $type=null ){

    if ( empty( $type ) ){
        $term_obj = get_term_by( 'slug', $region, 'region' );
        return $term_obj->count;
    }

    // Get all venues IDs for a "region"
    $args = array(
        'post_type' => 'venues',
        'posts_per_page' => -1,
        'tax_query' => array(
            array(
                'taxonomy' => 'region',
                'field' => 'slug',
                'terms' => $region
                )
            )
        );


    $venues_by_region = New WP_Query( $args );
    $tmp_venues_ids = array();
    foreach( $venues_by_region->posts as $venues ){
        $tmp_venues_ids[] = $venues->ID;
    }

    // All events IDs for our "region"
    $term_obj = get_term_by( 'slug', $type, 'type' );
    $term_id = $term_obj->term_id;

    $tmp_events_ids = array();
    $events_ids = array();
    $events_obj = New Events;
    foreach( $tmp_venues_ids as $tmp => $venues_id ){
        $tmp_events_ids = get_post_meta( $venues_id, 'events_id', true );

        if ( ! empty( $tmp_events_ids ) ){
            foreach( $tmp_events_ids as $events_id ){

                $tmp_type = $events_obj->getType( $events_id );
                $tmp_term_id = get_term_by( 'slug', $tmp_type, 'type' );
                $tmp_events_start_date = get_post_meta( $events_id, 'events_start-date', true );

                if ( ! empty( $tmp_term_id->term_id )
                    && $tmp_term_id->term_id == $term_id
                    && $tmp_events_start_date >= date('Y-m-d' ) ){

                    $ht = has_term( $tmp_term_id->term_id, 'type', $events_id );

                    if ( $ht ){
                        $tmp_final_events['title'] = get_the_title( $events_id );
                        $final_events[] = $tmp_final_events;
                    }
                }
            }
        }
    }

    $final_events['count'] = count( $final_events );
    return $final_events;
}