<?php if ('open' == $GLOBALS['post']->comment_status) { ?>
<!-- begin comments -->
<?php if ( post_password_required() ) { ?>
<section id="comments">
    <p><?php _e('This post is password protected. Enter the password to view any comments.', INCEPTIO_THEME_NAME); ?></p>
</section>
<!-- end comments -->
<?php return; } ?>

<?php if ( have_comments() ) { ?>
<section id="comments">
        <h3><?php printf(_n('1 Comment', '%1$s Comments', get_comments_number(), INCEPTIO_THEME_NAME), number_format_i18n(get_comments_number())); ?></h3>

    <!-- begin comment list -->
    <ol class="comment-list">
        <?php $GLOBALS['comment_index'] = 1; wp_list_comments(array('callback' => 'inc_comment')); ?>
    </ol>

    <?php if ( get_comment_pages_count() > 1 && get_option('page_comments') ) { // are there comments to navigate through ?>
        <nav id="comment-nav-below" class="navigation page-nav" role="navigation">
            <ul>
                <li class="nav-next"><?php next_comments_link(__('&laquo; Newer Comments', INCEPTIO_THEME_NAME) ); ?></li>
                <li class="nav-previous"><?php previous_comments_link(__('Older Comments &raquo;', INCEPTIO_THEME_NAME) ); ?></li>
            </ul>
        </nav>
    <?php } // check for comment navigation ?>
    <!-- end comment list -->
</section>
<!-- end comments -->
<?php } ?>

<!-- begin leave comment -->
<?php if (comments_open()) { comment_form(array(), get_the_ID()); } ?>
<!-- end leave comment -->
<?php } ?>