/**
 * Main js file:
 */

$(document).ready(function() {

	$("#owl-sketchfab").owlCarousel({

		navigation : true, // Show next and prev buttons
		navigationText: ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"],
		slideSpeed : 600,
		paginationSpeed : 400,
		singleItem:true

		// "singleItem:true" is a shortcut for:
		// items : 1,
		// itemsDesktop : false,
		// itemsDesktopSmall : false,
		// itemsTablet: false,
		// itemsMobile : false

	});

	$("#owl-videos").owlCarousel({

		navigation : true, // Show next and prev buttons
		navigationText: ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"],
		slideSpeed : 600,
		paginationSpeed : 400,
		singleItem:true

		// "singleItem:true" is a shortcut for:
		// items : 1,
		// itemsDesktop : false,
		// itemsDesktopSmall : false,
		// itemsTablet: false,
		// itemsMobile : false

	});

	$("#owl-threesixty-photos").owlCarousel({

		navigation : true, // Show next and prev buttons
		navigationText: ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"],
		slideSpeed : 600,
		paginationSpeed : 400,
		singleItem:true

		// "singleItem:true" is a shortcut for:
		// items : 1,
		// itemsDesktop : false,
		// itemsDesktopSmall : false,
		// itemsTablet: false,
		// itemsMobile : false

	});

	$("#pictures-owl").owlCarousel({

		autoPlay: 6000, //Set AutoPlay to 3 seconds

		items : 4,
		itemsDesktop : [1199,3],
		itemsDesktopSmall : [979,3]

	});

	$('#bigtext').bigtext({maxfontsize: 90});

	$('.company-isotope').isotope({
		itemSelector: '.company-box',
		layoutMode: 'fitRows'
	});

});