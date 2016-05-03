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

})(jQuery);
