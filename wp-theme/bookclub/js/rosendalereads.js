jQuery(document).ready(function($) {
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
	// ######### SORTING BOOKS ############
	var booksCache = $books.toArray();
	//console.log(booksCache);
	$('#titleSort').on('click', function(e) {
		e.preventDefault();
		//console.log($(this))
		$(this).parent('li').siblings('li').children('a').removeClass('ascending decending');
		if ($(this).is('.ascending') || $(this).is('.descending')) {
			//console.log('ASCEND OR DESCEND')
			$(this).toggleClass('ascending descending');;
			$('.bookshelf').append(booksCache.reverse());
		} else {
			$(this).addClass('ascending');
			//console.log("ADD CLASS")
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
		}
	});
	$('#authorSort').on('click', function(e) {
		e.preventDefault();
		$(this).parent('li').siblings('li').children('a').removeClass('ascending decending');
		if ($(this).is('.ascending') || $(this).is('.descending')) {
			//console.log('ASCEND OR DESCEND')
			$(this).toggleClass('ascending descending');;
			$('.bookshelf').append(booksCache.reverse());
		} else {
			$(this).addClass('ascending');
			//console.log("ADD CLASS")
			//console.log($(this))
			booksCache.sort(function (a, b){		
				a = $(a).data('author');
				b = $(b).data('author');
				//console.log(a, b);
				if (a < b) {
					return -1;
				} else {
					return a > b ? 1 : 0;
				}
			});
			$('.bookshelf').append(booksCache);
		}
	});
	// ######### END SORTING #########
});
