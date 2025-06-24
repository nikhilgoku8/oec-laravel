$(document).ready(function() {	

	/************************************Start Main Slider*************************************/

  	var owl = $('.main_banner');
  	owl.owlCarousel({
        nav: true,
        navText: [
    			'<span aria-label="' + 'Previous' + '" class="prev_arrow">&#x2039;</span>',
    			'<span aria-label="' + 'Next' + '" class="next_arrow">&#x203a;</span>'
    		],
        loop: true,
        autoplay: true,
        autoplayTimeout:3000,
        dots: true,
        responsive: {
          0: {
            items: 1
          },
          600: {
            items: 3
          },
          1000: {
            items: 1
          }
        }
  	});

	function setAnimation ( _elem, _InOut ) {
	    var animationEndEvent = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';

	    _elem.each ( function () {
	      var $elem = $(this);
	      var $animationType = 'animated ' + $elem.data( 'animation-' + _InOut );

	      $elem.addClass($animationType).one(animationEndEvent, function () {
	        $elem.removeClass($animationType); // remove animate.css Class at the end of the animations
	      });
	    });
		}

		// Fired before current slide change
	owl.on('change.owl.carousel', function(event) {
	  	var $currentItem = $('.owl-item', owl).eq(event.item.index);
	  	var $elemsToanim = $currentItem.find("[data-animation-out]");
	  	setAnimation ($elemsToanim, 'out');
	});

	// Fired after current slide has been changed
	var round = 0;
	owl.on('changed.owl.carousel', function(event) {

	  	var $currentItem = $('.owl-item', owl).eq(event.item.index);
	  	var $elemsToanim = $currentItem.find("[data-animation-in]");

	  	setAnimation ($elemsToanim, 'in');
	})

	owl.on('translated.owl.carousel', function(event) {
	console.log (event.item.index, event.page.count);

  	if (event.item.index == (event.page.count - 1))  {
        if (round < 1) {
          round++
          console.log (round);
        } else {
          owl.trigger('stop.owl.autoplay');
          var owlData = owl.data('owl.carousel');
          owlData.settings.autoplay = false; //don't know if both are necessary
          owlData.options.autoplay = false;
          owl.trigger('refresh.owl.carousel');
        }
  	}
	});

	/************************************End Main Slider*************************************/

    $('.home_clients_slider').owlCarousel({
        nav: false,
        loop: true,
        autoplay: true,
        autoplayTimeout:1000,
        dots: false,
        responsive: {
          0: {
            items: 1
          },
          600: {
            items: 3
          },
          1000: {
            items: 9
          }
        }
    });


})