$(document).ready(function(){

	/*
	 * Look for first_name and last_name
	 * to compile name for contacts
	 */
	 $('#contact-information-tab #first_name, #contact-information-tab #last_name').keyup(function(){

	 	// Update name
	 	$('#contact-information-tab #name').val($('#contact-information-tab #first_name').val() + ' ' + $('#contact-information-tab #last_name').val());
	 });

});