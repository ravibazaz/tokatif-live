//JavaScript Document

//<![CDATA[
		jQuery(window).load(function() { // makes sure the whole site is loaded
			$('#preloader').fadeOut(); // will first fade out the loading animation
			$('.loader-holder').delay(50).fadeOut('slow'); // will fade out the white DIV that covers the website.
			$('body').delay(50).css({'overflow':'visible'});
		})
	//]]>
	

//endLoader Animation 
function openNav() {
	document.getElementById("mySearch_style").style.width = "100%";
}	
function closeNav() {
	document.getElementById("mySearch_style").style.width = "0";
}
//end Top Search Bar
//Check to see if the window is top if not then display button
	jQuery(window).scroll(function(){
		if ($(this).scrollTop() > 100) {
			$('.scrollToTop').fadeIn();
		} else {
			$('.scrollToTop').fadeOut();
		}
		});	
		$('.scrollToTop').click(function(){
			$('html, body').animate({scrollTop : 0},700);
		return false;
	});		
//endScrollToTop
jQuery(document).ready(function() {
    //Sticky Menu
    //$('#nav_bg').stickit({scope: StickScope.Document, zIndex: 101}); 
    //on hover Menu 
    $('ul.navbar_right li.dropdown').hover(function() {
        $(this).find('.dropdown-menu').stop(true, true).delay(0).fadeIn(0);
    },
    function() {
        $(this).find('.dropdown-menu').stop(true, true).delay(0).fadeOut(0);
		});
    }); 
	
 jQuery(document).ready(function($) {
		        $('#customers-testimonials').owlCarousel({
		            loop: true,
		            center: true,
					nav: false,
  					dots: false,
		            items: 3,
		            margin:15,
		            autoplay: false,
		            autoplayTimeout: 8500,
		            smartSpeed: 450,
		            responsive: {
		              0: {
		                items: 1
		              },
		              768: {
		                items: 2
		              },
		              1170: {
		                items: 3
		              }
		            }
		        });
        	});


 var $search = $(".c-search-bar");

// When search is clicked

$('.c-search-bar__toggle').on('click', function() {
  openSearchExpand()
});

// When something is typed

$('.c-search-bar__input').on('input', function() {
  handleText()
});

// When someone clicks out of search area

$(window).on("click", function(event){	
  if ( $search.has(event.target).length == 0 && !$search.is(event.target) ){
    if ($('.c-search-bar__input').hasClass('c-search-bar__input--active')) {
      closeSearchExpand()
    }
  }
});

// Functions

function openSearchExpand() {
  $('.c-search-bar__input').toggleClass('c-search-bar__input--active').focus();
  $('.c-search-bar__btn').find('svg').toggle();
}

function closeSearchExpand() {
  if ($('.c-search-bar__input').val()) {
    $('.c-search-bar__toggle').show();
    $('.c-search-bar__input').toggleClass('c-search-bar__input--active');
  } else {
    $('.js-search-bar__open').show();
    $('.js-search-bar__close').hide();
    $('.c-search-bar__input').removeClass('c-search-bar__input--active');
  }
}

function handleText() {
  if ($('.c-search-bar__input').val()) {
    $('.c-search-bar__toggle').hide();
    $('.js-search-bar__open').show();
    $('.js-search-bar__close').hide();
  } else {
    $('.c-search-bar__toggle').show();
    $('.js-search-bar__open').hide();
    $('.js-search-bar__close').show();
  }
}

function eraseCache(){
  window.location = window.location.href+'?eraseCache=true';
};

//const $box = document.querySelector('.carousel-caption')
//
//$box.animate([
//	{transform: 'translateX(0px)'}, 
//	{transform: 'translateX(50px)'}
//], {
//  duration: 1000,
//  iterations: Infinity,
//	direction: 'alternate'
//});	