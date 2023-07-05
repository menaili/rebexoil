<?php

if( ! class_exists('Induscity_Button_Widget')) {
	class Induscity_Button_Widget extends WP_Widget {
		/**
		 * Holds widget settings defaults, populated in constructor.
		 *
		 * @var array
		 */
		protected $defaults;

		/**
		 * Constructor
		 *
		 * @return Induscity_Button_Widget
		 */
		function __construct() {
			$this->defaults = array(
				'title'      => '',
				'label'      => '',
				'url'        => '',
				'full_width' => 1,
			);

			parent::__construct(
				'mf-button-widget',
				esc_html__( 'Induscity - Button Widget', 'induscity' ),
				array(
					'classname'   => 'mf-button-widget',
					'description' => esc_html__( 'Advanced button widget.', 'induscity' )
				)
			);
		}

		/**
		 * Display widget
		 *
		 * @param array $args Sidebar configuration
		 * @param array $instance Widget settings
		 *
		 * @return void
		 */
		function widget( $args, $instance ) {
			$instance = wp_parse_args( $instance, $this->defaults );
			extract( $args );

			echo wp_kses_post( $before_widget );

			if ( $title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) ) {
				echo wp_kses_post( $before_title ) . $title . wp_kses_post( $after_title );
			}

			$label = $instance['label'];
			$url   = $instance['url'];
			$full  = '';

			if ( $instance['full_width'] == 1 ) {
				$full = 'mf-btn-fullwidth';
			}

			?>
            <a href="<?php echo esc_url( $url ) ?>"
               class="mf-btn mf-btn-widget <?php echo esc_attr( $full ) ?>"><?php echo esc_html( $label ) ?></a>
			<?php

			echo wp_kses_post( $after_widget );

		}

		/**
		 * Update widget
		 *
		 * @param array $new_instance New widget settings
		 * @param array $old_instance Old widget settings
		 *
		 * @return array
		 */
		function update( $new_instance, $old_instance ) {
			$new_instance['title']      = strip_tags( $new_instance['title'] );
			$new_instance['label']      = strip_tags( $new_instance['label'] );
			$new_instance['url']        = strip_tags( $new_instance['url'] );
			$new_instance['full_width'] = ! empty( $new_instance['full_width'] );

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
                <label for="<?php echo esc_attr( $this->get_field_id( 'label' ) ); ?>"><?php esc_html_e( 'Label', 'induscity' ); ?></label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'label' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'label' ) ); ?>" type="text"
                       value="<?php echo esc_attr( $instance['label'] ); ?>">
            </p>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'url' ) ); ?>"><?php esc_html_e( 'Button URL', 'induscity' ); ?></label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'url' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'url' ) ); ?>" type="text"
                       value="<?php echo esc_attr( $instance['url'] ); ?>">
            </p>
            <p>
                <input id="<?php echo esc_attr( $this->get_field_id( 'full_width' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'full_width' ) ); ?>" type="checkbox"
                       value="1" <?php checked( $instance['full_width'] ); ?>>
                <label for="<?php echo esc_attr( $this->get_field_id( 'full_width' ) ); ?>"><?php esc_html_e( 'Full Width Button', 'induscity' ); ?></label>
            </p>
			<?php
		}
	}
}