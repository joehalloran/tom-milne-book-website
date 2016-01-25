$=jQuery.noConflict();

$( function () {
	var $books = $('.book-preview');	//Create a variable to hold all books
	//Button to select smaller book view size
	$('#listView').on('click', function() { 
		$(this).addClass('btn-red').siblings().removeClass('btn-red');
		$books.each( function() {
			$(this).removeClass('col-sm-3').addClass('col-sm-12').find('h3').show();
			$(this).find('p').show();
		});
	});
	//Button to select larger book view size
	$('#iconView').on('click', function() {
		$(this).addClass('btn-red').siblings().removeClass('btn-red');
		$books.each( function() {
			$(this).removeClass('col-sm-12').addClass('col-sm-3').find('h3').hide();
			$(this).find('p').hide();
		});
	});
});
