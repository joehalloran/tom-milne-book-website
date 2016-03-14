jQuery(document).ready(function($) {
	var $books = $('.book-preview');	//Create a variable to hold all books
	//Button to select smaller book view size
	$('#listView').on('click', function() { 
		$(this).addClass('btn-red').siblings().removeClass('btn-red');
		$books.each( function() {
			$(this).removeClass('col-sm-3').addClass('col-sm-12').find('h3').show();
			$(this).find('p').show();
			$(this).find('.age-logo').show();
		});
	});
	//Button to select larger book view size
	$('#iconView').on('click', function() {
		$(this).addClass('btn-red').siblings().removeClass('btn-red');
		$books.each( function() {
			$(this).removeClass('col-sm-12').addClass('col-sm-3').find('h3').hide();
			$(this).find('p').hide();
			$(this).find('.age-logo').hide();
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

	// ########### TOP FIVE ############
	$('#editTopFive').on('click', function() {
		console.log("clicked");

		$( this ).siblings('button').show();

		$('.top-five-books').html('<form id="top-five-books-form" action="" method="POST">'+
			'<span>1. </span><input disabled name="bookOne" type="text" placeholder="drag your book here"><br />'+
			'<span>2. </span><input disabled name="bookTwo" type="text" placeholder="drag your book here"><br />'+
			'<span>3. </span><input disabled name="bookThree" type="text" placeholder="drag your book here"><br />'+
			'<span>4. </span><input name="bookFour" type="text" placeholder="drag your book here"><br />'+
			'<span>5. </span><input name="bookFive" type="text" placeholder="drag your book here">'+
			'<input type="submit" id="submitTopFive" value="save"></form>');
		// 
		$('#submitTopFive').click(function() {
			$('.top-five-books').children('form').children('input').each( function(){
				$( this ).prop('disabled', false);
			});
		});



		var $dropTargets = $('#top-five-books-form').children('input');
		//$dropTargets.hide();

		
		//var $inputTargets = $('.top-five-books').children('li').children('input');
		
		$dropTargets.each( function() {
			console.log($(this));
			var $current = $( this );
			//$current.html( '<input name="book" type="text" placeholder="drag your book here">' )
			$current.droppable( {
				activeClass: "drop-target",
				hoverClass: "drop-hover",
				drop: function( e, source ) {
					console.log(source);
					var $el = source.draggable;
					var bookId = $el.attr("data-id");
					var bookTitle = $el.attr("data-title");
					console.log(bookId);
					$( this ).addClass( "ui-state-highlight" ).val( bookTitle );
					$( this ).attr( "data-id", bookId );
				}
			});
		});
		$books.click(function(e) {
   			e.preventDefault();
   		});
		$books.each( function() {

			$(this).find('.book-thumbnail').draggable({
			  helper: "clone", //clone original
			  zIndex: 10000,  // top layer in z-index
		      start: function() {
		        console.log("start");
		      },
		      drag: function() {
		        console.log("drag");
		      }, 
		      stop: function() {
		        console.log("stop");
		      }
		    });
		});
		
		// TODO: Temporary function to demonstrate 'SAVE', must be updated for PHP solution
		// Note the scope, only active if "Edit top five is clicked".
		$('#saveTopFive').on('click', function() {
			$dropTargets.each ( function() {
				$( this ).html( $( this ).children('input').val() );
			});
			$( this ).hide();
			$( this ).siblings('#cancelTopFive').hide();
		});
		// TODO: Temporary function to demonstrate 'CANCEL', must be updated for PHP solution
		// Note the scope, only active if "Edit top five is clicked".
		$('#cancelTopFive').on('click', function() {
			$dropTargets.each ( function() {
				$( this ).html(" ");
			});
			$( this ).hide();
			$( this ).siblings('#saveTopFive').hide();
		});


	});
});
