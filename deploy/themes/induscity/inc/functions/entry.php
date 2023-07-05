<?php
/**
 * Custom functions for entry.
 *
 * @package Induscity
 */

if ( ! function_exists( 'wp_body_open' ) ) {

	/**
	 * Shim for wp_body_open, ensuring backward compatibility with versions of WordPress older than 5.2.
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
}

/**
 * Prints HTML with meta information for the current post-date/time and author.
 *
 * @since 1.0.0
 */
function induscity_posted_on( $echo = true ) {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

	$time_string = sprintf(
		$time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);

	$posted_on = sprintf(
		_x( '%s', 'post date', 'induscity' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark"><i class="fa fa-clock-o" aria-hidden="true"></i>' . $time_string . '</a>'
	);

	$output = '<span class="meta posted-on">' . $posted_on . '</span>';

	if ( $echo != true ) {
		return $output;
	} else {

		echo wp_kses_post($output);
	}
}

/**
 * Prints HTML with meta information for the social share and tags.
 *
 * @since 1.0.0
 */
function induscity_entry_footer() {
	if ( ! has_tag() && ! intval( induscity_get_option( 'show_post_social_share' ) ) ) {
		return;
	}

	echo '<footer class="entry-footer clearfix">';

	if ( has_tag() ) :
		the_tags( '<div class="tag-list"><h4>' . esc_html__( 'Tags: ', 'induscity' ) . '</h4>', ' , ', '</div>' );
	endif;

	if ( intval( induscity_get_option( 'show_post_social_share' ) ) ) {
		echo '<div class="mf-single-post-socials-share">';
		if ( function_exists( 'induscity_addons_share_link_socials' ) ) {
			induscity_addons_share_link_socials( get_the_title(), get_the_permalink(), get_the_post_thumbnail() );
		}
		echo '</div>';
	};

	echo '</footer>';
}

/**
 * Get blog meta
 *
 * @since  1.0
 *
 * @return string
 */
if ( ! function_exists( 'induscity_get_post_meta' ) ) :
	function  induscity_get_post_meta( $meta ) {

		$post_id = get_the_ID();
		if ( is_home() && ! is_front_page() ) {
			$post_id = get_queried_object_id();
		} elseif ( function_exists( 'is_shop' ) && is_shop() ) {
			$post_id = intval( get_option( 'woocommerce_shop_page_id' ) );
		}
		//		elseif ( is_post_type_archive( 'portfolio_project' ) ) {
		//			$post_id = intval( get_option( 'drf_portfolio_page_id' ) );
		//		}

		return get_post_meta( $post_id, $meta, true );

	}
endif;


/**
 * Get or display limited words from given string.
 * Strips all tags and shortcodes from string.
 *
 * @since 1.0.0
 *
 * @param integer $num_words The maximum number of words
 * @param string  $more      More link.
 * @param bool    $echo      Echo or return output
 *
 * @return string|void Limited content.
 */
function induscity_content_limit( $num_words, $more = "&hellip;", $echo = true ) {
	$content = get_the_content();

	// Strip tags and shortcodes so the content truncation count is done correctly
	$content = strip_tags( strip_shortcodes( $content ), apply_filters( 'induscity_content_limit_allowed_tags', '<script>,<style>' ) );

	// Remove inline styles / scripts
	$content = trim( preg_replace( '#<(s(cript|tyle)).*?</\1>#si', '', $content ) );

	// Truncate $content to $max_char
	$content = wp_trim_words( $content, $num_words );

	if ( $more ) {
		$output = sprintf(
			'<p>%s <a href="%s" class="more-link" title="%s">%s</a></p>',
			$content,
			get_permalink(),
			sprintf( esc_html__( 'Continue reading &quot;%s&quot;', 'induscity' ), the_title_attribute( 'echo=0' ) ),
			esc_html( $more )
		);
	} else {
		$output = sprintf( '<p>%s</p>', $content );
	}

	if ( ! $echo ) {
		return $output;
	}

	echo wp_kses_post($output);
}


/**
 * Show entry thumbnail base on its format
 *
 * @since  1.0
 */
function induscity_entry_thumbnail( $size = 'thumbnail' ) {
	$html = '';

	$css_post = '';

	if ( $post_format = get_post_format() ) {
		$css_post = 'format-' . $post_format;
	}

	switch ( get_post_format() ) {
		case 'gallery':
			$images = get_post_meta( get_the_ID(), 'images' );
			$css_post .= ' owl-carousel';

			$gallery = array();
			if ( empty( $images ) ) {
				$thumb = get_the_post_thumbnail( get_the_ID(), $size );

				$html .= '<div class="single-image">' . $thumb . '</div>';
			} else {
				foreach ( $images as $image ) {
					$thumb = wp_get_attachment_image( $image, $size );
					if ( $thumb ) {
						$gallery[] = sprintf( '<div class="item-gallery">%s</div>', $thumb );
					}
				}

				$html .= implode( '', $gallery );
			}

			break;

		case 'video':
			$video = get_post_meta( get_the_ID(), 'video', true );
			if ( is_singular( 'post' ) ) {
				if ( ! $video ) {
					break;
				}

				// If URL: show oEmbed HTML
				if ( filter_var( $video, FILTER_VALIDATE_URL ) ) {
					if ( $oembed = @wp_oembed_get( $video, array( 'width' => 1170 ) ) ) {
						$html .= $oembed;
					} else {
						$atts = array(
							'src'   => $video,
							'width' => 1170,
						);

						if ( has_post_thumbnail() ) {
							$atts['poster'] = get_the_post_thumbnail_url( get_the_ID(), 'full' );
						}
						$html .= wp_video_shortcode( $atts );
					}
				} // If embed code: just display
				else {
					$html .= $video;
				}
			} else {
				$image_src = get_the_post_thumbnail( get_the_ID(), $size );
				if ( $video ) {
					$html = sprintf( '<a href="%s">%s</a>', esc_url( $video ), $image_src );
				} else {
					$html = $image_src;
				}
			}

			break;

		default:
			$html = get_the_post_thumbnail( get_the_ID(), $size );
			if ( ! is_singular( 'post' ) ) {
				$html = sprintf( '<a href="%s">%s</a>', esc_url( get_the_permalink() ), $html );
			}

			break;
	}

	if ( $html ) {
		$html = sprintf( '<div  class="entry-format %s">%s</div>', esc_attr( $css_post ), $html );
	}

	echo apply_filters( __FUNCTION__, $html, get_post_format() );
}

/**
 * Get author meta
 *
 * @since  1.0
 *
 */
function induscity_author_box() {
	if ( induscity_get_option( 'show_author_box' ) == 0 ) {
		return;
	}

	if ( ! get_the_author_meta( 'description' ) ) {
		return;
	}

	?>
	<div class="post-author">
		<h2 class="box-title"><?php esc_html_e( 'About Author', 'induscity' ) ?></h2>

		<div class="post-author-box clearfix">
			<div class="post-author-avatar">
				<?php echo get_avatar( get_the_author_meta( 'ID' ), 85 ); ?>
			</div>
			<div class="post-author-info">
				<h3 class="author-name"><?php the_author_meta( 'display_name' ); ?></h3>

				<p><?php the_author_meta( 'description' ); ?></p>
			</div>
		</div>
	</div>
	<?php
}

/**
 * Get single entry meta
 *
 * @since  1.0
 *
 */
function induscity_entry_meta( $single_post = false ) {
	$fields = (array) induscity_get_option( 'blog_entry_meta' );

	if ( $single_post ) {
		$fields = (array) induscity_get_option( 'post_entry_meta' );
	}

	if ( empty ( $fields ) ) {
		return;
	}

	foreach ( $fields as $field ) {
		switch ( $field ) {

			case 'author':
				echo '<span class="meta author vcard"><span>' . esc_html__( 'By ', 'induscity' ) . '</span><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) )
					. '">' . esc_html( get_the_author() ) . '</a></span>';
				break;

			case 'date':
				$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

				$time_string = sprintf(
					$time_string,
					esc_attr( get_the_date( 'c' ) ),
					esc_html( get_the_date() )
				);

				echo '<span class="meta date">' . $time_string . '</span>';

				break;

			case 'cat':
				$category = get_the_terms( get_the_ID(), 'category' );

				$cat_html = '';

				if ( ! is_wp_error( $category ) && $category ) {
					$cat_html = sprintf( '<a href="%s" class="cat-links">%s</a>', esc_url( get_term_link( $category[0], 'category' ) ), esc_html( $category[0]->name ) );
				}

				if ( $cat_html ) {
					echo '<span class="meta cat">' . $cat_html . '</span>';
				}

				break;
		}
	}
}

if ( ! function_exists( 'induscity_get_page_header_image' ) ) :

	/**
	 * Get page header image URL
	 *
	 * @return string
	 */
	function induscity_get_page_header_image() {
		if ( induscity_get_post_meta( 'hide_page_header' ) ) {
			return false;
		}

		if ( is_404() || is_page_template( 'template-coming-soon.php' ) ) {
			return false;
		}

		if ( is_page_template( array( 'template-homepage.php' ) ) ) {
			return false;
		}

		$page_header = array(
			'bg_image' => '',
			'parallax' => false,
			'elements' => array( 'title', 'breadcrumb' )
		);

		if ( induscity_is_portfolio() ) {
			if ( ! intval( induscity_get_option( 'portfolio_page_header' ) ) ) {
				return false;
			}

			$page_header['elements'] = induscity_get_option( 'portfolio_page_header_els' );
			$page_header['bg_image'] = induscity_get_option( 'portfolio_page_header_bg' );
			$page_header['parallax'] = intval( induscity_get_option( 'portfolio_page_header_parallax' ) );

		} elseif ( induscity_is_service() ) {
			if ( ! intval( induscity_get_option( 'service_page_header' ) ) ) {
				return false;
			}

			$page_header['elements'] = induscity_get_option( 'service_page_header_els' );
			$page_header['bg_image'] = induscity_get_option( 'service_page_header_bg' );
			$page_header['parallax'] = intval( induscity_get_option( 'service_page_header_parallax' ) );

		} elseif ( induscity_is_catalog() ) {
			if ( ! intval( induscity_get_option( 'page_header_shop' ) ) ) {
				return false;
			}

			$page_header['elements'] = induscity_get_option( 'page_header_shop_els' );
			$page_header['bg_image'] = induscity_get_option( 'page_header_shop_bg' );
			$page_header['parallax'] = intval( induscity_get_option( 'page_header_shop_parallax' ) );

		} elseif ( function_exists( 'is_product' ) && is_product() ) {
			if ( ! intval( induscity_get_option( 'single_product_page_header' ) ) ) {
				return false;
			}

			$page_header['elements'] = induscity_get_option( 'single_product_page_header_els' );
			$page_header['bg_image'] = induscity_get_option( 'single_product_page_header_bg' );
			$page_header['parallax'] = intval( induscity_get_option( 'single_product_page_header_parallax' ) );

		} elseif ( is_singular( 'post' )
			|| is_singular( 'portfolio' )
			|| is_singular( 'service' )
			|| is_page()
			|| is_page_template( 'template-fullwidth.php' )
		) {
			if ( is_singular( 'post' ) ) {
				if ( ! intval( induscity_get_option( 'single_page_header' ) ) ) {
					return false;
				}

				$elements = induscity_get_option( 'single_page_header_els' );
				$bg_image = induscity_get_option( 'single_page_header_bg' );
				$parallax = intval( induscity_get_option( 'single_page_header_parallax' ) );
			} elseif ( is_singular( 'portfolio' ) ) {
				if ( ! intval( induscity_get_option( 'single_portfolio_page_header' ) ) ) {
					return false;
				}

				$elements = induscity_get_option( 'single_portfolio_page_header_els' );
				$bg_image = induscity_get_option( 'single_portfolio_page_header_bg' );
				$parallax = intval( induscity_get_option( 'single_portfolio_page_header_parallax' ) );

			} elseif ( is_singular( 'service' ) ) {
				if ( ! intval( induscity_get_option( 'single_service_page_header' ) ) ) {
					return false;
				}

				$elements = induscity_get_option( 'single_service_page_header_els' );
				$bg_image = induscity_get_option( 'single_service_page_header_bg' );
				$parallax = intval( induscity_get_option( 'single_service_page_header_parallax' ) );

			} elseif ( is_page() || is_page_template( 'template-fullwidth.php' ) ) {
				if ( ! intval( induscity_get_option( 'page_page_header' ) ) ) {
					return false;
				}

				$elements = induscity_get_option( 'page_page_header_els' );
				$bg_image = induscity_get_option( 'page_page_header_bg' );
				$parallax = intval( induscity_get_option( 'page_page_header_parallax' ) );
			}

			if ( get_post_meta( get_the_ID(), 'custom_layout', true ) ) {

				if ( get_post_meta( get_the_ID(), 'hide_breadcrumb', true ) ) {

					$key = array_search( 'breadcrumb', $elements );
					if ( $key !== false ) {
						unset( $elements[$key] );
					}
				}


				if ( get_post_meta( get_the_ID(), 'hide_title', true ) ) {
					$key = array_search( 'title', $elements );
					if ( $key !== false ) {
						unset( $elements[$key] );
					}
				}

				if ( $custom_bg = get_post_meta( get_the_ID(), 'page_bg', true ) ) {

					$bg_image = wp_get_attachment_url( $custom_bg );
				}
			}

			$page_header['elements'] = $elements;
			$page_header['bg_image'] = $bg_image;
			$page_header['parallax'] = $parallax;
		} else {
			if ( ! intval( induscity_get_option( 'blog_page_header' ) ) ) {
				return false;
			}

			$page_header['elements'] = induscity_get_option( 'blog_page_header_els' );
			$page_header['bg_image'] = induscity_get_option( 'blog_page_header_bg' );
			$page_header['parallax'] = intval( induscity_get_option( 'blog_page_header_parallax' ) );
		}


		return $page_header;
	}
endif;

if ( ! function_exists( 'induscity_menu_icon' ) ) :
	/**
	 * Get menu icon
	 */
	function induscity_menu_icon() {
		printf(
			'<span id="mf-navbar-toggle" class="navbar-icon">
					<span class="navbars-line"></span>
				</span>'
		);
	}
endif;

/**
 * Get socials
 *
 * @since  1.0.0
 *
 *
 * @return string
 */
function induscity_get_socials() {
	$socials = array(
		'facebook'   => esc_html__( 'Facebook', 'induscity' ),
		'twitter'    => esc_html__( 'Twitter', 'induscity' ),
		'google'     => esc_html__( 'Google', 'induscity' ),
		'tumblr'     => esc_html__( 'Tumblr', 'induscity' ),
		'flickr'     => esc_html__( 'Flickr', 'induscity' ),
		'vimeo'      => esc_html__( 'Vimeo', 'induscity' ),
		'youtube'    => esc_html__( 'Youtube', 'induscity' ),
		'linkedin'   => esc_html__( 'LinkedIn', 'induscity' ),
		'pinterest'  => esc_html__( 'Pinterest', 'induscity' ),
		'dribbble'   => esc_html__( 'Dribbble', 'induscity' ),
		'spotify'    => esc_html__( 'Spotify', 'induscity' ),
		'instagram'  => esc_html__( 'Instagram', 'induscity' ),
		'tumbleupon' => esc_html__( 'Tumbleupon', 'induscity' ),
		'wordpress'  => esc_html__( 'WordPress', 'induscity' ),
		'rss'        => esc_html__( 'Rss', 'induscity' ),
		'deviantart' => esc_html__( 'Deviantart', 'induscity' ),
		'share'      => esc_html__( 'Share', 'induscity' ),
		'skype'      => esc_html__( 'Skype', 'induscity' ),
		'behance'    => esc_html__( 'Behance', 'induscity' ),
		'apple'      => esc_html__( 'Apple', 'induscity' ),
		'yelp'       => esc_html__( 'Yelp', 'induscity' ),
	);

	return apply_filters( 'induscity_header_socials', $socials );
}

// Rating reviews

function induscity_rating_stars( $score ) {
	$score     = min( 10, abs( $score ) );
	$full_star = $score / 2;
	$half_star = $score % 2;
	$stars     = array();

	for ( $i = 1; $i <= 5; $i ++ ) {
		if ( $i <= $full_star ) {
			$stars[] = '<i class="fa fa-star"></i>';
		} elseif ( $half_star ) {
			$stars[]   = '<i class="fa fa-star-half-o"></i>';
			$half_star = false;
		} else {
			$stars[] = '<i class="fa fa-star-o"></i>';
		}
	}

	echo join( "\n", $stars );
}

/**
 * Check is blog
 *
 * @since  1.0
 */

if ( ! function_exists( 'induscity_is_blog' ) ) :
	function induscity_is_blog() {
		if ( ( is_archive() || is_author() || is_category() || is_home() || is_tag() ) && 'post' == get_post_type() ) {
			return true;
		}

		return false;
	}

endif;

/**
 * Check is catalog
 *
 * @return bool
 */
if ( ! function_exists( 'induscity_is_catalog' ) ) :
	function induscity_is_catalog() {

		if ( function_exists( 'is_shop' ) && ( is_shop() || is_product_category() || is_product_tag() ) ) {
			return true;
		}

		return false;
	}
endif;

/**
 * Check is portfolio
 *
 * @since  1.0
 */

if ( ! function_exists( 'induscity_is_portfolio' ) ) :
	function induscity_is_portfolio() {
		if ( is_post_type_archive( 'portfolio' ) || is_tax( 'portfolio_category' ) ) {
			return true;
		}

		return false;
	}
endif;

/**
 * Check is services
 *
 * @since  1.0
 */

if ( ! function_exists( 'induscity_is_service' ) ) :
	function induscity_is_service() {
		if ( is_post_type_archive( 'service' ) || is_tax( 'service_category' ) ) {
			return true;
		}

		return false;
	}
endif;