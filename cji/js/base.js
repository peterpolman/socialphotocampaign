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

		showObjects();
		
		function showObjects() {
			
			tid = setTimeout(showObjects, 300);
			
			var objectsLeft = new Array("#blob0","#blob1","#blob2");
			var objectsRight = new Array("#blob3","#blob4","#blob5");
			
		  	$(objectsLeft[i]).animate({
				left: '-50px',
				opacity: 1			
			}, {
				duration: 100,
				easing: 'easeOutBounce'
			});

			$(objectsRight[i]).animate({
				right: '-50px',
				opacity: 1	
			}, {
				duration: 100,
				easing: 'easeOutBounce'
			});

			i = i + 1;

			if(i == 10){ 
				clearTimeout(tid);
			}
		}

	});