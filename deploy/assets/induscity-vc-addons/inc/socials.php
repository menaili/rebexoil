<?php
/**
 * Hooks for share socials
 *
 * @package Induscity
 */

if ( ! function_exists( 'induscity_addons_share_link_socials' ) ) :
	function induscity_addons_share_link_socials( $title, $link, $media ) {
		$socials = array();
		if ( is_singular('post') ) {
			$socials = induscity_get_option( 'post_socials_share' );
		}

		$socials_html = '';
		if ( $socials ) {
			if ( in_array( 'facebook', $socials ) ) {
				$socials_html .= sprintf(
					'<li><a class="share-facebook induscity-facebook" title="%s" href="http://www.facebook.com/sharer.php?u=%s&t=%s" target="_blank"><i class="fa fa-facebook"></i></a></li>',
					esc_attr( $title ),
					urlencode( $link ),
					urlencode( $title )
				);
			}

			if ( in_array( 'twitter', $socials ) ) {
				$socials_html .= sprintf(
					'<li><a class="share-twitter induscity-twitter" href="http://twitter.com/share?text=%s&url=%s" title="%s" target="_blank"><i class="fa fa-twitter"></i></a></li>',
					esc_attr( $title ),
					urlencode( $link ),
					urlencode( $title )
				);
			}

			if ( in_array( 'pinterest', $socials ) ) {
				$socials_html .= sprintf(
					'<li><a class="share-pinterest induscity-pinterest" href="http://pinterest.com/pin/create/button?media=%s&url=%s&description=%s" title="%s" target="_blank"><i class="fa fa-pinterest"></i></a></li>',
					urlencode( $media ),
					urlencode( $link ),
					esc_attr( $title ),
					urlencode( $title )
				);
			}

			if ( in_array( 'google', $socials ) ) {
				$socials_html .= sprintf(
					'<li><a class="share-google-plus induscity-google-plus" href="https://plus.google.com/share?url=%s&text=%s" title="%s" target="_blank"><i class="fa fa-google-plus"></i></a></li>',
					urlencode( $link ),
					esc_attr( $title ),
					urlencode( $title )
				);
			}

			if ( in_array( 'linkedin', $socials ) ) {
				$socials_html .= sprintf(
					'<li><a class="share-linkedin induscity-linkedin" href="http://www.linkedin.com/shareArticle?url=%s&title=%s" title="%s" target="_blank"><i class="fa fa-linkedin"></i></a></li>',
					urlencode( $link ),
					esc_attr( $title ),
					urlencode( $title )
				);
			}

			if ( in_array( 'vkontakte', $socials ) ) {
				$socials_html .= sprintf(
					'<li><a class="share-vkontakte induscity-vkontakte" href="http://vk.com/share.php?url=%s&title=%s&image=%s" title="%s" target="_blank"><i class="fa fa-vk"></i></a></li>',
					urlencode( $link ),
					esc_attr( $title ),
					urlencode( $media ),
					urlencode( $title )
				);
			}
		}

		if ( $socials_html ) {
			printf( '<h4>%s<i class="fa fa-share-alt"></i></h4><ul class="social-share socials-inline">%s</ul>', esc_html__( 'Share', 'induscity' ), $socials_html );
		}
		?>
		<?php
	}

endif;

