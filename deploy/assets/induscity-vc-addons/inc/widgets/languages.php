<?php

if( ! class_exists('Induscity_Language_Switcher_Widget')) {
	class Induscity_Language_Switcher_Widget extends WP_Widget {
		/**
		 * Holds widget default settings, populated in constructor.
		 *
		 * @var array
		 */
		protected $defaults;

		/**
		 * Constructor
		 *
		 * @return Induscity_Language_Switcher_Widget
		 */
		function __construct() {
			$this->defaults = array(
				'title'     => '',
				'show_flag' => false,
			);

			parent::__construct(
				'induscity-languages-widget',
				esc_html__( 'Induscity - Language Switcher', 'induscity' ),
				array(
					'classname'   => 'induscity-languages-widget',
					'description' => esc_html__( 'Display Language switcher', 'induscity' ),
				)
			);
		}

		/**
		 * Outputs the HTML for this widget.
		 *
		 * @param array $args An array of standard parameters for widgets in this theme
		 * @param array $instance An array of settings for this widget instance
		 */
		function widget( $args, $instance ) {
			$instance = wp_parse_args( $instance, $this->defaults );
			extract( $args );
			$languages = function_exists( 'icl_get_languages' ) ? icl_get_languages() : array();
			$languages = apply_filters( 'wpml_active_languages', $languages, 'skip_missing=0' );

			if ( empty( $languages ) ) {
				return;
			}
			echo wp_kses_post( $before_widget );

			if ( $title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) ) {
				echo wp_kses_post( $before_title ) . $title . wp_kses_post( $after_title );
			}

			$lang_list = array();
			$current   = '';

			foreach ( (array) $languages as $code => $language ) {
				$context = esc_html( $language['translated_name'] );

				if ( $instance['show_flag'] ) {
					$context = '<img src="' . esc_url( $language['country_flag_url'] ) . '" alt="' . esc_attr( $language['native_name'] ) . '">' . $context;
				}

				if ( ! $language['active'] ) {
					$lang_list[] = sprintf(
						'<li class="%s"><a href="%s">%s</a></li>',
						esc_attr( $code ),
						esc_url( $language['url'] ),
						$context
					);
				} else {
					$current = $context;
					array_unshift( $lang_list, sprintf(
						'<li class="%s"><a href="%s">%s</a></li>',
						esc_attr( $code ),
						esc_url( $language['url'] ),
						$context
					) );
				}
			}
			?>

            <div class="language list-dropdown">
                <span class="current"><?php echo esc_attr( $current ) ?><i class="fa fa-angle-down"></i></span>
                <ul>
					<?php echo implode( "\n\t", $lang_list ); ?>
                </ul>
            </div>

			<?php

			echo wp_kses_post( $after_widget );
		}

		/**
		 * Handles updating settings for the current Custom Menu widget instance.
		 *
		 * @param array $new_instance New settings for this instance as input by the user via WP_Widget::form().
		 * @param array $old_instance Old settings for this instance.
		 *
		 * @return array Updated settings to save.
		 */
		function update( $new_instance, $old_instance ) {
			$new_instance['title']     = sanitize_text_field( $new_instance['title'] );
			$new_instance['show_flag'] = isset( $new_instance['show_flag'] );

			return $new_instance;
		}

		/**
		 * Display widget settings
		 *
		 * @param array $instance Widget settings
		 *
		 * @return void
		 */
		function form( $instance ) {
			$instance = wp_parse_args( $instance, $this->defaults );
			?>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'induscity' ); ?></label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text"
                       value="<?php echo esc_attr( $instance['title'] ); ?>">
            </p>

            <p>
                <input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'show_flag' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'show_flag' ) ); ?>"
                       value="1" <?php checked( 1, $instance['show_flag'] ) ?>>
                <label for="<?php echo esc_attr( $this->get_field_id( 'show_flag' ) ); ?>"><?php esc_html_e( 'Show flag', 'induscity' ); ?></label>
            </p>

			<?php
		}
	}
}