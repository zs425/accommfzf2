// scroll to top
(function($){
	$.fn.UItoTop = function(options) {
 		var defaults = {
			text: 'To Top',
			min: 200,
			inDelay:500,
			outDelay:400,
  			containerID: 'toTop',
			containerHoverID: 'toTopHover',
			scrollSpeed: 800,
			easingType: 'linear'
 		};

 		var settings = $.extend(defaults, options);
		var containerIDhash = '#' + settings.containerID;
		var containerHoverIDHash = '#'+settings.containerHoverID;
		
		$('body').append('<a href="#" id="'+settings.containerID+'">'+settings.text+'</a>');
		$(containerIDhash).hide().click(function(){
			$('html,body,document').animate({scrollTop:0}, settings.scrollSpeed, settings.easingType);
			$('#'+settings.containerHoverID, this).stop().animate({'opacity': 0 }, settings.inDelay, settings.easingType);
			return false;
		})
		.prepend('<span id="'+settings.containerHoverID+'"></span>')
		.hover(function() {
				$(containerHoverIDHash, this).stop().animate({
					'opacity': 1
				}, 600, 'linear');
			}, function() { 
				$(containerHoverIDHash, this).stop().animate({
					'opacity': 0
				}, 700, 'linear');
			});
					
		$(window).scroll(function() {
			var sd = $(window).scrollTop();
			if(typeof document.body.style.maxHeight === "undefined") {
				$(containerIDhash).css({
					'position': 'absolute',
					'top': $(window).scrollTop() + $(window).height() - 50
				});
			}
			if ( sd > settings.min ) 
				$(containerIDhash).fadeIn(settings.inDelay);
			else 
				$(containerIDhash).fadeOut(settings.Outdelay);
		});

};
})(jQuery);

// Pause autoscrolling on carousel hover.
function mycarousel_initCallback(carousel) {				    
	carousel.clip.hover(function() {
		carousel.stopAuto();
	}, function() {
		carousel.startAuto();
	});
};

jQuery(document).ready(function($) {
	
	// Top Search
	$("#searchForm").hoverIntent({
		sensitivity: 5,
		interval: 100, 
		over: function () {
			$(this).stop().animate({width: '250px'}, 700, 'easeOutCubic');
			$("#stext").stop().show().animate({width: '200px'}, 800, 'easeOutCubic');		
		}, 
		timeout: 2000, 
		out: function () {
			$('#stext').stop().animate({width: '0px'},600,'easeInCubic',function() {$(this).hide();});	
			$(this).stop().animate({width: '29px'}, 700, 'easeInCubic');
		}
	});
		
	
	// Top Slider Links
	var mainWidth = $(".header_slider .slides_container").width();
	var pageInner =  $(".header_slider .pagination_inner")
	var pageContent = $(".header_slider .pagination");
	var pageItem = $(".header_slider .pagination li");	
	var pageInnerWidth = pageInner.width();	
	var pageWidth = pageContent.width();	
	var pageCount = pageItem.size();	
	pageItem.css("width", pageWidth/pageCount - 48);
	pageInner.css("width", mainWidth);
	
	// Remove links outline in IE 7
	$("a").attr("hideFocus", "true").css("outline", "none");

	// style Select, Radio, Checkboxe
	if ($("select").hasClass("select_styled")) {
		cuSel({changedEl: ".select_styled", visRows: 15, scrollArrows: true});
	}
	$('.input_styled input').customInput();
	
	

	//$(".dropdown li ul.submenu-1").css({'position':'absolute','visibility':'visible','display':'none'});
	
	
			
	var screenRes = $(window).width();    
    if (screenRes < 900) {		
		$("li.mega-nav").removeClass("mega-nav");		
	} 
	if (screenRes > 700) {				
		mega_show();
		$().UItoTop({ easingType: 'easeOutQuart' });
    } 
	if (screenRes > 960) {
		mega_show();
		
	}
	
	// centering dropdown list
			$(".dropdown > li").hover(function(){
				var dropDown = $(this).children("ul");
				var dropDownLi = $(this).children().children("li").width();
				var posLeft = ((dropDownLi - $(this).width())/2);
				dropDown.css("left",-posLeft);		
			});
	// dropdown menu	
			$('.dropdown .mega-nav > ul.submenu-1').each(function(){  
				var liItems = $(this);
				var Sum = 0;
				var liHeight = 0;
				if (liItems.children('li').length > 1){
					$(this).children('li').each(function(i, e){
						Sum += $(e).outerWidth(true);
					});
					$(this).width(Sum);
					liHeight = $(this).innerHeight();			
					if ($.browser.mozilla) {
						$(this).children('li').css({"height":liHeight-60});		
					} else {
						$(this).children('li').css({"height":liHeight-40});		
					}
				} 
			});	
	
	function mega_show(){		
		$('.dropdown li').hoverIntent({
			sensitivity: 5,
			interval: 100, 
			over: subm_show, 
			timeout: 100, 
			out: subm_hide
		});
	}
	function subm_show(){		
		$(this).children("ul.submenu-1").fadeIn(400);
	}
	function subm_hide(){ 
		$(this).children("ul.submenu-1").fadeOut(150);
	}
	
		
	$(".dropdown ul").parent("li").addClass("parent");
	$(".dropdown li:first-child, .pricing_box li:first-child, .sidebar .widget-container:first-child").addClass("first");
	$(".dropdown li:last-child, .pricing_box li:last-child, .sidebar_inner > .widget-container:last-child, .widget_twitter .tweet_item:last-child").addClass("last");
	$(".dropdown li:only-child").removeClass("last").addClass("only");	
	$(".sidebar .current-menu-item, .sidebar .current-menu-ancestor").prev().addClass("current-prev");			
	
// tabs		
	if ($("ul").hasClass("tabs")) {		
		$("ul.tabs").tabs("> .tabcontent", {tabs: 'li', effect: 'fade'});	
	}
	if ($("ul").is(".tabs.linked")) {		
		$("ul.tabs").tabs("> .tabcontent");
	}
	
	/* if ($("ul").hasClass("linked")) {
		$("ul.tabs").tabs("> .tabcontent");
	} elseif ($("ul").hasClass("tabs")) {
		$("ul.tabs").tabs("> .tabcontent", {tabs: 'li', effect: 'fade'});	
	} */
	
// odd/even
	$("ul.recent_posts > li:odd, ul.popular_posts > li:odd, .styled_table table>tbody>tr:odd, .boxed_list > .boxed_item:odd").addClass("odd");
	$(".widget_recent_comments ul > li:even, .widget_recent_entries li:even, .widget_twitter .tweet_item:even, .widget_archive ul > li:even, .widget_categories ul > li:even, .widget_nav_menu ul > li:even, .widget_links ul > li:even, .widget_meta ul > li:even, .widget_pages ul > li:even").addClass("even");
	
// cols
	$(".row .col:first-child").addClass("alpha");
	$(".row .col:last-child").addClass("omega"); 	

// toggle content
	$(".toggle_content").hide(); 	
	$(".toggle").toggle(function(){
		$(this).addClass("active");
		}, function () {
		$(this).removeClass("active");
	});
	
	$(".toggle").click(function(){
		$(this).next(".toggle_content").slideToggle(300,'easeInQuad');
	});

// pricing
	$(".price_col_body ul").each(function () {
		$(this).find("li").removeClass("even").filter(":even").addClass("even");
	});
	$(".pricing_box li.price_col").css('width',$(".pricing_box ul").width() / $(".pricing_box li.price_col").size());

// buttons	
		$(".button_link, .button_styled, .btn-share, .btn, .contact-social img, .btn-submit, .social_content img, .social_content a, .post-share a").hover(function(){
			$(this).stop().animate({"opacity": 0.85});
		},function(){
			$(this).stop().animate({"opacity": 1});
		});	

// input labels
	if ($(".row").hasClass("infieldlabel")){
		$(".infieldlabel label").inFieldLabels({fadeOpacity: 0.3});
	}	
	
// preload images
	var cache = [];
	$.preLoadImages = function() {
		var args_len = arguments.length;
		for (var i = args_len; i--;) {
		  var cacheImage = document.createElement('img');
		  cacheImage.src = arguments[i];
		  cache.push(cacheImage);
		}
		// list of images to preload. Need the full path to the image
		$.preLoadImages("../images/dropdown_bg.png","../images/dropdown_sub_arrow.png");
	}	

// Topmenu <ul> replace to <select>
	$(function() {
	   if (screenRes < 470) {

		  /* Clone our navigation */
		  var mainNavigation = $('.topmenu').clone();

		  /* Replace unordered list with a "select" element to be populated with options, and create a variable to select our new empty option menu */
		  $('.topmenu').html('<select class="select_styled" id="topm-select"></select>');
		  var selectMenu = $('#topm-select');

		  /* Navigate our nav clone for information needed to populate options */
		  $(mainNavigation).children('ul').children('li').each(function() {

			 /* Get top-level link and text */
			 var href = $(this).children('a').attr('href');
			 var text = $(this).children('a').text();
			 
			 /* Append this option to our "select" */
			 
			 			 
			if ($(this).is(".current-menu-item")) {				 
				$(selectMenu).append('<option value="'+href+'" selected>'+text+'</option>');
			} else {
				$(selectMenu).append('<option value="'+href+'">'+text+'</option>');
			}

			 /* Check for "children" and navigate for more options if they exist */
			 if ($(this).children('ul').length > 0) {
				$(this).children('ul').children('li').each(function() {

				   /* Get child-level link and text */
				   var href2 = $(this).children('a').attr('href');
				   var text2 = $(this).children('a').text();

				   /* Append this option to our "select" */
				   if ($(this).is(".current-menu-item")) {				 
						$(selectMenu).append('<option value="'+href2+'" class="select-current" selected>'+text2+'</option>');
					} else {
						$(selectMenu).append('<option value="'+href2+'"> &nbsp;|-- '+text2+'</option>');
					}
					
					/* Check for "children" and navigate for more options if they exist */
					 if ($(this).children('ul').length > 0) {
						$(this).children('ul').children('li').each(function() {

						   /* Get child-level link and text */
						   var href3 = $(this).children('a').attr('href');
						   var text3 = $(this).children('a').text();

						   /* Append this option to our "select" */
						   if ($(this).is(".current-menu-item")) {				 
								$(selectMenu).append('<option value="'+href3+'" class="select-current" selected>'+text3+'</option>');
							} else {
								$(selectMenu).append('<option value="'+href3+'"> &nbsp;&nbsp;&nbsp;&nbsp;|-- '+text3+'</option>');
							}
											   
						});
					 }
									   
				});
			 }
			
		  });
	   }

	   /* When our select menu is changed, change the window location to match the value of the selected option. */
	   $(selectMenu).change(function() {
		  location = this.options[this.selectedIndex].value;
	   });
	});
	
});
