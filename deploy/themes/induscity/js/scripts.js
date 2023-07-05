(function ($) {
	'use strict';

	var induscity = induscity || {};
	induscity.init = function () {
		induscity.$body = $(document.body),
			induscity.$window = $(window),
			induscity.$header = $('#masthead');

		// Scroll Top
		this.scrollTop();

		// Header
		this.activeHeaderMenu();
		this.searchToggle();
		this.headerSticky();
		this.menuBlock();
		this.mobileMenu();

		// Page Header
		this.pageHeader();

		// Widget Office
		this.widgetOffice();

		// Single Portfolio
		this.singlePortfolioGallery();
		this.portfolioFilter();
		this.imagesPopUp();

		// Product Quantity
		this.productQuantity();

		// Single Post Gallery
		this.singleGallery();
	};

	// Menu Block Right
	induscity.scrollTop = function () {
		var $scrollTop = $('#scroll-top');
		induscity.$window.on('scroll', function () {
			if (induscity.$window.scrollTop() > induscity.$window.height()) {
				$scrollTop.addClass('show-scroll');
			} else {
				$scrollTop.removeClass('show-scroll');
			}
		});

		// Scroll effect button top
		$scrollTop.on('click', function (event) {
			event.preventDefault();
			$('html, body').stop().animate({
					scrollTop: 0
				},
				800
			);
		});
	};

	// Scroll Top
	induscity.menuBlock = function () {
		var $el = $('.menu-block-right'),
			$elL = $('.menu-block-left'),
			$wContainer = $('.container').width(),
			width = ( induscity.$window.width() - $wContainer ) / 2;

		induscity.$window.on('resize', function () {
			$el.css({
				'width': width,
				'right': width * -1
			});

			$elL.css({
				'width': width,
				'left' : width * -1
			});
		}).trigger('resize');
	};

	// Search toggle
	induscity.searchToggle = function () {
		$('a.toggle-search').on('click', function (e) {
			e.preventDefault();
			$(this).parent().toggleClass('show-search');
		});
	};

	// Mobile Menu
	induscity.mobileMenu = function () {
		var $mobileMenu = $('#primary-mobile-nav');
		induscity.$header.on('click', '#mf-navbar-toggle', function (e) {
			e.preventDefault();
			$mobileMenu.toggleClass('open');
			induscity.$body.toggleClass('open-canvas-panel');
		});

		$mobileMenu.find('.menu .menu-item-has-children > a').prepend('<span class="toggle-menu-children"></span>');

		$mobileMenu.on('click', '.menu-item-has-children > a, .menu-item-has-children > span', function (e) {
			e.preventDefault();
			openSubMenus($(this));
		});

		$mobileMenu.on('click', '.close-canvas-mobile-panel', function (e) {
			e.preventDefault();
			induscity.$body.removeClass('open-canvas-panel');
			$('#primary-mobile-nav').removeClass('open');
		});

		$('#off-canvas-layer').on('click', function (e) {
			e.preventDefault();
			induscity.$body.removeClass('open-canvas-panel');
			$('#primary-mobile-nav').removeClass('open');
		});

		induscity.$window.on('resize', function () {
			if (induscity.$window.width() > 1200) {
				if ($mobileMenu.hasClass('open')) {
					$mobileMenu.removeClass('open');
					induscity.$body.removeClass('open-canvas-panel');
				}
			}
		});

		function openSubMenus($menu) {
			$menu.closest('li').siblings().find('ul').slideUp();
			$menu.closest('li').siblings().removeClass('active');
			$menu.closest('li').siblings().find('li').removeClass('active');

			$menu.closest('li').children('ul').slideToggle();
			$menu.closest('li').toggleClass('active');
		}
	};

	// Header Sticky
	induscity.headerSticky = function () {
		if (!induscity.$body.hasClass('header-sticky')) {
			return;
		}

		var hHeader, hHeaderContact, hTopbar, outerHeight, scroll, top, hMenu;

		induscity.$window.on('resize', function () {
			hMenu = induscity.$header.find( '.site-menu' ).outerHeight(true);
			hHeader = induscity.$header.outerHeight(true);
			hHeaderContact = induscity.$header.find('.site-contact').outerHeight(true);

			if (induscity.$body.hasClass('header-v1') || induscity.$body.hasClass('header-v5')) {
				outerHeight = hHeaderContact;
			} else {
				outerHeight = hHeader;
			}

			$('#mf-header-minimized').height(outerHeight);

		}).trigger('resize');

		induscity.$window.on('scroll', function () {
			hTopbar = $('#topbar').outerHeight(true);
			hMenu = induscity.$header.find( '.site-menu' ).outerHeight(true);
			hHeaderContact = induscity.$header.find('.site-contact').outerHeight(true);
			top = hHeaderContact * -1;

			hTopbar = hTopbar == undefined ? 0 : hTopbar;

			if (induscity.$body.hasClass('admin-bar')) {
				top = top + 32;
			}

			if (( induscity.$body.hasClass('header-v1') ||
				induscity.$body.hasClass('header-v2') ) &&
				induscity.$window.width() > 1199) {
				scroll = hTopbar + hHeaderContact;
			} else if ( induscity.$body.hasClass('header-v5') && induscity.$window.width() > 1199 ) {
				scroll = hTopbar + hHeaderContact - hMenu * 0.5;
			} else {
				scroll = hTopbar;
			}

			if (induscity.$window.scrollTop() > scroll) {
				induscity.$header.addClass('minimized');
				$('#mf-header-minimized').addClass('minimized');

				if (( induscity.$body.hasClass('header-v1') ||
					induscity.$body.hasClass('header-v2') ||
					induscity.$body.hasClass('header-v5') ) &&
					induscity.$window.width() > 1199) {
					induscity.$header.css('top', top);
				}

			} else {
				induscity.$header.removeClass('minimized');
				$('#mf-header-minimized').removeClass('minimized');

				if (induscity.$body.hasClass('header-v1') ||
					induscity.$body.hasClass('header-v2') ||
					induscity.$body.hasClass('header-v5')) {
					induscity.$header.removeAttr('style');
				}
			}
		});
	};


	// Page header
	induscity.pageHeader = function () {
		$('.page-header.parallax').find('.featured-image').parallax('50%', 0.6);
		$('.mf-service-banner').parallax('50%', 0.6);
	};

	// Widget Office
	induscity.widgetOffice = function () {
		var $location = $('.office-location');
		$location.each(function() {
			var el = $(this),
				$tabs = el.find('.office-switcher ul li'),
				$first = $tabs.filter(':first'),
				$current = el.find('.office-switcher a'),
				$content = el.find('.topbar-office');
			$first.addClass('active');
			$content.filter(':first').addClass('active');

			$current.html($first.html());

			$current.on('click', function (e) {
				var $this = $(this);
				e.preventDefault();

				$this.parent().toggleClass('show-office');
			});

			$tabs.on('click', function () {
				var $this = $(this),
					tab_id = $this.attr('data-tab');

				if ($this.hasClass('active')) {
					return;
				}

				$current.html($this.html());
				$current.parent().toggleClass('show-office');

				$tabs.removeClass('active');
				$content.removeClass('active');

				$this.addClass('active');
				$('#' + tab_id).addClass('active');
			});
		});
	};

	induscity.activeHeaderMenu = function () {
		var $el, leftPos, childWidth, newWidth, $origWidth, itemWidth, newItemWidth,
			$mainNav = induscity.$header.find('ul.menu');

		$mainNav.find('li:last-child').addClass('last-child');
		$mainNav.append('<li id="mf-active-menu" class="mf-active-menu"></li>');
		var $magicLine = $('#mf-active-menu'),
			space;

		$origWidth = 0;

		if ($mainNav.children('li.current-menu-item, li.current-menu-ancestor, li.current-menu-parent').length > 0) {

			itemWidth = $mainNav.children('li.current-menu-item, li.current-menu-ancestor, li.current-menu-parent').outerWidth();

			childWidth = $mainNav.children('li.current-menu-item, li.current-menu-ancestor, li.current-menu-parent').children('a').outerWidth();

			space = ((itemWidth - childWidth / 2)) / 2;

			childWidth = childWidth / 2;

			$magicLine
				.width(childWidth)
				.css('left', $mainNav.children('li.current-menu-item, li.current-menu-ancestor, li.current-menu-parent').position().left + space)
				.data('origLeft', $magicLine.position().left)
				.data('origWidth', $magicLine.width());

			$origWidth = $magicLine.data('origWidth');
		}

		$mainNav.children('li').on('hover',function () {
			$el = $(this);

			newItemWidth = $el.outerWidth();

			newWidth = $el.children('a').outerWidth();

			space = ((newItemWidth - newWidth / 2)) / 2;

			newWidth = newWidth / 2;

			leftPos = $el.position().left + space;
			$magicLine.stop().animate({
				left : leftPos,
				width: newWidth
			});

		}, function () {
			$magicLine.stop().animate({
				left : $magicLine.data('origLeft'),
				width: $origWidth
			});
		});

	};

	induscity.singlePortfolioGallery = function () {
		$('.single-portfolio .entry-thumbnail.portfolio-gallery').owlCarousel({
			rtl            : true,
			items          : 1,
			loop           : false,
			nav            : false,
			autoplay       : false,
			autoplayTimeout: 0,
			autoplaySpeed  : 0,
			dots           : true,
			navSpeed       : 800,
			dotsSpeed      : 800
		});
	};

	induscity.singleGallery = function () {
		$('.format-gallery.owl-carousel').owlCarousel({
			rtl      : true,
			loop     : false,
			items    : 1,
			nav      : false,
			dots     : true
		});
	};

	/**
	 * Initialize isotope for portfolio items
	 */
	induscity.portfolioFilter = function () {
		var $items = $('.mf-list-portfolio');

		if (!$items.length) {
			return;
		}

		var options = {
			itemSelector      : '.project-wrapper',
			transitionDuration: '0.7s'
		};

		$items.imagesLoaded(function () {
			$(this.elements).isotope(options);
		});

		var $filter = $('.nav-filter');

		$filter.on('click', 'a', function (e) {
			e.preventDefault();

			var $this = $(this),
				selector = $this.attr('data-filter');

			$filter.find('a').removeClass('active');
			$(this).addClass('active');
			$this.closest('.nav-section').next('.mf-list-portfolio').isotope({
				filter: selector
			});
		});
	};

	/**
	 *  Gallery Light Box
	 */
	induscity.imagesPopUp = function () {
		var $images = $('.mf-gallery-popup');

		if (!$images.length) {
			return;
		}

		var $links = $images.find('a.photoswipe'),
			items = [];

		$links.each(function () {
			var $this = $(this),
				$w = $this.attr( 'data-large_image_width' ),
				$h = $this.attr( 'data-large_image_height' );

			items.push({
				src: $this.attr('href'),
				w  : $w,
				h  : $h
			});

		});

		$images.on('click', 'a.photoswipe', function (e) {
			e.preventDefault();

			var index = $links.index($(this)),
				options = {
					index              : index,
					bgOpacity          : 0.85,
					showHideOpacity    : true,
					mainClass          : 'pswp--minimal-dark',
					barsSize           : {top: 0, bottom: 0},
					captionEl          : false,
					fullscreenEl       : false,
					shareEl            : false,
					tapToClose         : true,
					tapToToggleControls: false
				};

			var lightBox = new PhotoSwipe(document.getElementById('pswp'), window.PhotoSwipeUI_Default, items, options);
			lightBox.init();
		});
	};

	/**
	 * Change product quantity
	 */
	induscity.productQuantity = function () {
		induscity.$body.on('click', '.quantity .increase, .quantity .decrease', function (e) {
			e.preventDefault();

			var $this = $(this),
				$qty = $this.siblings('.qty'),
				current = parseInt($qty.val(), 10),
				min = parseInt($qty.attr('min'), 10),
				max = parseInt($qty.attr('max'), 10);

			min = min ? min : 1;
			max = max ? max : current + 1;

			if ($this.hasClass('decrease') && current > min) {
				$qty.val(current - 1);
				$qty.trigger('change');
			}
			if ($this.hasClass('increase') && current < max) {
				$qty.val(current + 1);
				$qty.trigger('change');
			}
		});
	};

	/**
	 * Document ready
	 */
	$(function () {
		induscity.init();
	});

})(jQuery);
