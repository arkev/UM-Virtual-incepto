<?php

add_filter('comment_form_defaults', 'inc_comment_form_defaults');
if (!function_exists('inc_comment_form_defaults')) {
    function inc_comment_form_defaults($arg)
    {
        $arg['title_reply'] = __('Leave a Comment', INCEPTIO_THEME_NAME);
        $arg['comment_notes_before'] = '<p>' . __('We would be glad to get your feedback. Take a moment to comment and tell us what you think.', INCEPTIO_THEME_NAME) . '</p>';
        $arg['id_form'] = 'comment-form';
        $arg['comment_field'] = '<p><label for="comment">' . __('Message', INCEPTIO_THEME_NAME) . ':<span class="asterisk note">*</span></label><textarea id="comment" cols="45" rows="8" name="comment" class="required"></textarea></p>';
        return $arg;
    }
}

add_filter('comment_form_default_fields', 'inc_comment_form_default_fields');
if (!function_exists('inc_comment_form_default_fields')) {
    function inc_comment_form_default_fields($arg)
    {
        $commenter = wp_get_current_commenter();
        $req = get_option('require_name_email');
        $req_sign = ($req ? '<span class="asterisk note">*</span>' : '');
        $req_class = ($req ? 'class="required"' : '');
        $arg['author'] = '<p><label for="author">' . __('Name', INCEPTIO_THEME_NAME) . ':' . $req_sign . '</label><input id="author" type="text" name="author" value="' . esc_attr($commenter['comment_author']) . '" ' . $req_class . '></p>';
        $arg['email'] = '<p><label for="email">' . __('Email', INCEPTIO_THEME_NAME) . ':' . $req_sign . '</label><input id="email" type="email" name="email" value="' . esc_attr($commenter['comment_author_email']) . '" ' . $req_class . '></p>';
        $arg['url'] = '<p><label for="url">' . __('Website', INCEPTIO_THEME_NAME) . ':</label><input id="url" type="text" name="url" value="' . esc_attr($commenter['comment_author_url']) . '"></p>';
        return $arg;
    }
}

if (!function_exists('inc_comment')) {
    function inc_comment($comment, $args, $depth)
    {
        $comment_index = $GLOBALS['comment_index'];
        $article_author_id = get_the_author_meta('ID');
        $comment_id = $comment->comment_ID;
        $GLOBALS['comment'] = $comment;
        $author_name = htmlspecialchars($comment->comment_author);

        $author_url = get_comment_author_link($comment_id);
        if ($article_author_id == $comment->user_id) {
            $author_url = str_replace($author_name, $author_name . '<span> (' . __('Author', INCEPTIO_THEME_NAME) . ')</span>', $author_url);
        }
        $comment_text = get_comment_text($comment_id);
        $comment_date = sprintf(__('%1$s at %2$s', INCEPTIO_THEME_NAME), get_comment_date(), get_comment_time() );

        echo "<li class=\"comment\">\n";
        echo "<div id=\"comment-$comment_index\" class=\"comment-wrap\">\n";
        echo "<div class=\"avatar-wrap\">\n";
        echo "<div class=\"avatar\">\n";
        echo get_avatar($comment, 50);
        echo "</div>\n";
        if ($comment->comment_approved != '0') {
            edit_comment_link(__('Edit', INCEPTIO_THEME_NAME), ' ');
        }
        echo "</div>\n";
        echo "<div class=\"comment-details\">\n";
        echo "<div class=\"comment-author\">$author_url</div>\n";
        echo "<div class=\"comment-meta\">$comment_date</div>\n";
        echo "<div class=\"comment-content\">\n";
        echo "<p>$comment_text</p>\n";
        if ($comment->comment_approved == '0') {
            echo "<em class=\"moderation\">" . __('(Your comment is awaiting moderation.)', INCEPTIO_THEME_NAME) . "</em>\n";
        } else {
            comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth'], 'reply_text' => __('Reply', INCEPTIO_THEME_NAME) . ' &raquo;')));
        }
        echo "</div>\n";
        echo "</div>\n";
        echo "</div>\n";
        $GLOBALS['comment_index'] = $comment_index + 1;
    }
}
