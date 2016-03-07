jQuery(document).ready(function($) {

	$('[data-toggle="tooltip"]').tooltip()

	var $books = $('.book-preview');	//Create a variable to hold all books
	
	//Button to select smaller book view size
	$('#listView').on('click', function() { 
		$(this).addClass('btn-red').siblings().removeClass('btn-red');
		$books.each( function() {
			$(this).removeClass('col-sm-3 col-xs-6').addClass('col-sm-12').find('h3').show();
			$(this).find('.book-thumbnail').removeClass('book-thumbnail-icon').addClass('book-thumbnail-list');
			$(this).find('h2').show();
			$(this).find('p').show();
			$(this).find('hr').show();
			$(this).find('.age-logo').show();
		});
	});
	//Button to select larger book view size
	$('#iconView').on('click', function() {
		$(this).addClass('btn-red').siblings().removeClass('btn-red');
		$books.each( function() {
			$(this).removeClass('col-sm-12').addClass('col-sm-3 col-xs-6').find('h3').hide();
			$(this).find('.book-thumbnail').addClass('book-thumbnail-icon').removeClass('book-thumbnail-list');
			$(this).find('h2').hide();
			$(this).find('p').hide();
			$(this).find('hr').hide();
			$(this).find('.age-logo').hide();
		});
	});
	//Button to select bookshelf background
	$('#bookShelfOn').on('click', function() {
		$(this).addClass('btn-red').siblings().removeClass('btn-red');
		$books.each( function() {
			$(this).addClass('bookshelf-background');
		});
	});
	//Button to remove bookshelf background
	$('#bookShelfOff').on('click', function() {
		$(this).addClass('btn-red').siblings().removeClass('btn-red');
		$books.each( function() {
			$(this).removeClass('bookshelf-background');
		});
	});
	// ######### SORTING BOOKS ############
	var booksCache = $books.toArray();

	$('#titleSort').on('click', function(e) {
		e.preventDefault();
		$(this).parent('li').siblings('li').children('a').removeClass('ascending descending');
		if ($(this).is('.ascending') || $(this).is('.descending')) {
			$(this).toggleClass('ascending descending');;
			$('.bookshelf').append(booksCache.reverse());
		} else {
			$(this).addClass('ascending');
			booksCache.sort(function (a, b){
				console.log(a, b);		
				a = $(a).data('title').replace(/^the /i, '');
				b = $(b).data('title').replace(/^the /i, '');
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
		$(this).parent('li').siblings('li').children('a').removeClass('ascending descending');
		if ($(this).is('.ascending') || $(this).is('.descending')) {
			$(this).toggleClass('ascending descending');;
			$('.bookshelf').append(booksCache.reverse());
		} else {
			$(this).addClass('ascending');
			booksCache.sort(function (a, b){		
				a = $(a).data('author');
				b = $(b).data('author');
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

	// ########### TOP FIVE ###########
	$('#bookOne').keydown(function() {
	  //code to not allow any changes to be made to input field
	  return false;
	});
	$('#bookTwo').keydown(function() {
	  //code to not allow any changes to be made to input field
	  return false;
	});
	$('#bookThree').keydown(function() {
	  //code to not allow any changes to be made to input field
	  return false;
	});
	$('#bookFour').keydown(function() {
	  //code to not allow any changes to be made to input field
	  return false;
	});
	$('#bookFive').keydown(function() {
	  //code to not allow any changes to be made to input field
	  return false;
	});

	$('#editTopFive').on('click', function() {
		$( this ).hide();
		$('#saveTopFive').show();
		$('#cancelTopFive').show();
		var $dropTargets = $('.top-five-books').children('div').children('input');
		$dropTargets.each( function() {
			var $current = $( this );
			$current.parent('div').append('<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>');
			$current.prop('disabled', false);
			$current.droppable( {
				activeClass: "drop-target",
				hoverClass: "drop-hover",
				tolerance: "pointer",
				create:  function( e, source ) {
					$( this ).parent().addClass( "drop-target-div" );
				},
				over: function( e, source ) {
					$( this ).parent().addClass( "drop-target-div-hover" );
				},
				out: function( e, source ) {
					$( this ).parent().removeClass( "drop-target-div-hover" );
				},
				drop: function( e, source ) {
					console.log(source);
					var $el = source.draggable;
					var bookId = $el.attr("data-id");
					var bookTitle = $el.attr("data-title");
					console.log(bookId);
					$( this ).addClass( "ui-state-highlight" ).val( bookTitle );
					$( this ).parent().removeClass( "drop-target-div-hover" );
				}
			});
		});

		$('#bookOne').tooltip('show');
		$books.click(function(e) {
   			e.preventDefault();
   		});
		$books.each( function() {
			var $thumbnail = $(this).find('.book-thumbnail');
			$thumbnail.effect( "shake" );
			$thumbnail.draggable({
			  helper: "clone", //clone original
			  zIndex: 10000,  // top layer in z-index
		      start: function() {
		      	$('#bookOne').tooltip('hide');
		      },
		      drag: function() {
		      }, 
		      stop: function() {
		      }
		    });
		});

		$('.glyphicon-remove').click(function(e) {
   			$(this).siblings('input').val( "" )
   		});
		 
		// Note the scope, only active if "Edit top five is clicked".
		$('#cancelTopFive').on('click', function() {
			$dropTargets.each ( function() {
				$( this ).droppable( 'destroy' );
			});
			$( this ).hide();
			$('.top-five-books').children('div').each ( function() {
				$( this ).removeClass( "drop-target-div" );
				$( this ).prop('disabled', true);
			});
			$('#editTopFive').show();
			$( this ).siblings('#saveTopFive').hide();
		});


	});
});
