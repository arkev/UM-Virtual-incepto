<?php

class Inc_Recent_Comments_Widget extends WP_Widget_Recent_Comments
{
    function __construct() {
        parent::__construct();
    }

    function widget($args, $instance)
    {
        global $comments, $comment;

        $cache = wp_cache_get('widget_recent_comments', 'widget');

        if ( ! is_array( $cache ) )
            $cache = array();

        if ( ! isset( $args['widget_id'] ) )
            $args['widget_id'] = $this->id;

        if ( isset( $cache[ $args['widget_id'] ] ) ) {
            echo $cache[ $args['widget_id'] ];
            return;
        }

        extract($args, EXTR_SKIP);
        $output = '';
        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'Recent Comments', INCEPTIO_THEME_NAME ) : $instance['title'], $instance, $this->id_base );

        if ( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) )
            $number = 5;

        $comments = get_comments( apply_filters( 'widget_comments_args', array( 'number' => $number, 'status' => 'approve', 'post_status' => 'publish' ) ) );
        $output .= $before_widget;
        if ( $title )
            $output .= $before_title . $title . $after_title;

        $output .= '<ul id="recentcomments" class="menu">';
        if ( $comments ) {
            // Prime cache for associated posts. (Prime post term cache if we need it for permalinks.)
            $post_ids = array_unique( wp_list_pluck( $comments, 'comment_post_ID' ) );
            _prime_post_caches( $post_ids, strpos( get_option( 'permalink_structure' ), '%category%' ), false );

            foreach ( (array) $comments as $comment) {
                $output .=  '<li class="recentcomments">' . /* translators: comments widget: 1: comment author, 2: post link */ sprintf(__('%1$s on %2$s', INCEPTIO_THEME_NAME), get_comment_author_link(), '<a href="' . esc_url( get_comment_link($comment->comment_ID) ) . '">' . get_the_title($comment->comment_post_ID) . '</a>') . '</li>';
            }
        }
        $output .= '</ul>';
        $output .= $after_widget;

        echo $output;
        $cache[$args['widget_id']] = $output;
        wp_cache_set('widget_recent_comments', $cache, 'widget');
    }
}
