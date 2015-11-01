$(function() {
	var $books = $('.book-preview');	//Create a variable to hold all books
	//Button to select smaller book view size
	$('#smallBookSize').on('click', function() { 
		$(this).addClass('btn-red').siblings('#largeBookSize').removeClass('btn-red');
		$books.each( function() {
			$(this).removeClass('col-sm-4').addClass('col-sm-3').find('h4').hide();
		});
	});
	//Button to select larger book view size
	$('#largeBookSize').on('click', function() {
		$(this).addClass('btn-red').siblings().removeClass('btn-red');
		$books.each( function() {
			$(this).removeClass('col-sm-3').addClass('col-sm-4').find('h4').show();
		});
	});
	//Button to toggle bookshelf background
	$('#shelfBackgroundOn').on('click', function() {
		//console.log("Shelf On");
		$(this).addClass('btn-red').siblings().removeClass('btn-red');
		$('.bookshelf').addClass('bookshelf-show');
	});
	//Button to toggle bookshelf background
	$('#shelfBackgroundOff').on('click', function() {
		// console.log("Shelf Off");
		$(this).addClass('btn-red').siblings().removeClass('btn-red');
		$('.bookshelf').removeClass('bookshelf-show');
	});

	var booksCache = $books.toArray();
	//console.log(booksCache);
	$('#titleSort').on('click', function(e) {
		e.preventDefault();
		if ($(this).is('.ascending') || $(this).is('.decending')) {
			console.log('ASCEND OR DESCEND')
			$(this).removeClass('ascending');
		} else {
			$(this).addClass('ascending');
			console.log("ADD CLASS")
			console.log($(this))
		}
		booksCache.sort(function (a, b){		
			a = $(a).data('title').replace(/^the /i, '');
			b = $(b).data('title').replace(/^the /i, '');
			//console.log(a, b);
			if (a < b){
				return -1;
			} else {
				return a > b ? 1 : 0;
			}
		});
		$('.bookshelf').append(booksCache);
	});
	$('#authorSort').on('click', function(e) {
		e.preventDefault();
		booksCache.sort(function (a, b){		
			a = $(a).data('author');
			b = $(b).data('author');
			//console.log(a, b);
			if (a < b){
				return -1;
			} else {
				return a > b ? 1 : 0;
			}
		});
		$('.bookshelf').append(booksCache);
	});
});
