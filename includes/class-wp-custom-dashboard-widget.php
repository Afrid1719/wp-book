<?php


class WP_Custom_Dashboard_Widget extends WP_Widget {
	public function __construct( $id, $name, $widget_options = array(), $control_options = array() ) {
		parent::__construct(
			'wp_book_dashboard_widget',
			esc_html__('WP Book Dashboard Widget', 'wp_book'),
			array(
				'classname'=>esc_attr__('wp_book_dashboard_widget', 'wp_book'),
				'description'=>esc_html__('This widget in the dashboard shows top5 book categories', 'wp_book')
			),
			$control_options
		);
	}

	public function widget($args, $instance) {
		echo 'Hello';
	}
}