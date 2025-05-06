<?php
$premium_options = array(
	'tags_page_title'              => 'Articles tagged with: %tag%"',
	'tags_slug'                    => 'tag',
	'voting_question'              => 'Was this helpful?',
	'show_votes_count'             => 1,
	'votes_icons'                  => 0,
	'voting_confirmation'          => 'Your vote has been submitted. Thank You!',
	'already_voted_notice'         => 'You have already voted this article!',
	'activate_feedback'            => 0,
	'show_feedback_form'           => 'always',
	'feedback_form_lable'          => 'Help us improve this article',
	'feedback_submit_text'         => 'Submit Feedback',
	'feedback_submit_success_text' => 'Thanks for your feedback',
	'feedback_submit_fail_text'    => 'There was a problem sending your feedback. Please try again!',
	'toc_title'                    => 'Table of Content',
	'show_toc_numbers'             => 1,
	'show_toc_totop'               => 1,
	'toc_totop_text'               => 'Back to Top',
	'show_notice_titles'          => 1,
	'show_notice_icons'           => 1,
	'notice_titles'               => array(
		'default' => '',
		'info'    => esc_html__( 'Info', 'basepress' ),
		'success' => esc_html__( 'Success', 'basepress' ),
		'warning' => esc_html__( 'Warning', 'basepress' ),
		'danger'  => esc_html__( 'Danger', 'basepress' )
	),
	'prev_article_text'            => 'Previous Article',
	'next_article_text'            => 'Next Article',
	'restriction_redirected_pages' => 'all',
	'restricted_page_notice'       => 'You have reached a restricted content!',
	'restricted_search_snippet_notice' => 'This content is restricted',
	'show_restricted_teaser'       => 1,
	'show_restricted_login'        => 1,
	'restricted_teaser_length'     => 500,
);

return $premium_options;
