(function ($) {

  Drupal.behaviors.opknappertje = {
    attach: function(context) {

			// init Isotope
			var $grid = $('.grid').isotope({
			  itemSelector: '.contribution',
			  layoutMode: 'fitRows',
			  getSortData: {
			    name: '[data-name]',
			    votes: '[data-votecount]',
					created: '[data-created]',
			    weight: function( itemElem ) {
			      var weight = $( itemElem ).find('.weight').text();
			      return parseFloat( weight.replace( /[\(\)]/g, '') );
			    }
			  }
			});

			$('.sort-by-name').on('click', function() {
			  var sortValue = $(this).attr('data-sort-value');
			  $grid.isotope({ sortBy: sortValue });
        $('.view-filters .btn').removeClass('active');
        $(this).toggleClass('active');
			});

			$('.sort-by-votes').on('click', function() {
			  var sortValue = $(this).attr('data-sort-value');
			  $grid.isotope({ sortBy: sortValue });
        $('.view-filters .btn').removeClass('active');
        $(this).toggleClass('active');
			});

			$('.sort-by-created').on('click', function() {
			  var sortValue = $(this).attr('data-sort-value');
			  $grid.isotope({ sortBy: sortValue });
        $('.view-filters .btn').removeClass('active');
        $(this).toggleClass('active');
			});

		}
	}


  Drupal.behaviors.countdown = {
    attach: function(context) {

      var clock;

      $(document).ready(function() {
  			var clock;

  			clock = $('.clock[data-timestamp]').FlipClock({
  		        clockFace: 'DailyCounter',
  		        autoStart: false,
  		        callbacks: {
  		        	stop: function() {
  		        		$('.message').html('The clock has stopped!')
  		        	}
  		        }
  		    });
          var timestamp = new Date($('.clock[data-timestamp]').data('timestamp'));
          var now = new Date().getTime();
          now = Math.round(now/1000);
          var future = new Date(timestamp).getTime();
          var diff = future - now;

  		    clock.setTime(diff);
  		    clock.setCountdown(true);
  		    clock.start();

  		});

    }
  }

})(jQuery);
