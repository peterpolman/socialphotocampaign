(function ($) {

  Drupal.behaviors.opknappertje = {
    attach: function(context) {

			// init Isotope
			var $grid = $('.grid').isotope({
			  itemSelector: '.contribution',
			  layoutMode: 'fitRows',
			  getSortData: {
			    name: '.username',
			    votes: '.vote-count',
					created: '.created',
			    weight: function( itemElem ) {
			      var weight = $( itemElem ).find('.weight').text();
			      return parseFloat( weight.replace( /[\(\)]/g, '') );
			    }
			  }
			});

			$('.sort-by-name').on('click', function() {
			  var sortValue = $(this).attr('data-sort-value');
			  $grid.isotope({ sortBy: sortValue });
			});

			$('.sort-by-votes').on('click', function() {
			  var sortValue = $(this).attr('data-sort-value');
			  $grid.isotope({ sortBy: sortValue });
			});

			$('.sort-by-created').on('click', function() {
			  var sortValue = $(this).attr('data-sort-value');
			  $grid.isotope({ sortBy: sortValue });
			});

		}
	}

})(jQuery);
