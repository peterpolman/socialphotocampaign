$(document).ready(function(){

		var i = 0;
		
		$('#overview .wrapper').hover(function(){
			$(this).find('.front').fadeOut(200);	
			$(this).find('.back').fadeIn(200);	
		},function(){
			$(this).find('.front').fadeIn(200);	
			$(this).find('.back').fadeOut(200);	
		});

		$('.sort button').click(function(){
			$(this).toggleClass('toggle');
		});

	});