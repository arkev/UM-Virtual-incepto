<?php global $post;
if (empty($post->post_content)) {
    echo Page_Contact_Manager::get_default_contact_page_content(true);
} else {
    the_content();
}
