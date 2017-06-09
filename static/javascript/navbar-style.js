/** javascript file **/

// Initialize collapse button
$(".button-collapse").sideNav();

// Initialize collapsible (uncomment the line below if you use the dropdown variation)

//$('.collapsible').collapsible();
$('.button-collapse').sideNav({

	// Default is 300
		menuWidth: 300,

	// Choose the horizontal origin
	edge: 'right',

	// Closes side-nav on <a> clicks, useful for Angular/Meteor
	closeOnClick: true,

	// Choose whether you can drag to open on touch screens
	draggable: true
	}
);

// Show sideNav
$('.button-collapse').sideNav('show');
// Hide sideNav
$('.button-collapse').sideNav('hide');
// Destroy sideNav
$('.button-collapse').sideNav('destroy');