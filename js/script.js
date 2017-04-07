jQuery(document).ready(function($) {

	//match title generation
	// date - opponent - type
	
	$('#publish').on('hover', function(e){
		if ($("#title").val() == "") {
			set_title();
		}
		
		//set ages
		var bday = new Date( $("#acf-field_5522d7e7a710b").val().substr(0,4), $("#acf-field_5522d7e7a710b").val().substr(4,2) - 1, $("#acf-field_5522d7e7a710b").val().substr(6,2) );
		var oday = new Date( $("#acf-field_5522d87ca7111").val().substr(0,4), $("#acf-field_5522d87ca7111").val().substr(4,2) - 1, $("#acf-field_5522d87ca7111").val().substr(6,2) );
		var pday = new Date( $("#acf-field_5523e64e47c59").val().substr(0,4), $("#acf-field_5523e64e47c59").val().substr(4,2) - 1, $("#acf-field_5523e64e47c59").val().substr(6,2) );
		var dday = new Date( $("#acf-field_5522d899a7112").val().substr(0,4), $("#acf-field_5522d899a7112").val().substr(4,2) - 1, $("#acf-field_5522d899a7112").val().substr(6,2) );
		var tday = new Date();
		// console.log( oday, bday );
		//ordained at
		$('#acf-field_5523ea87accc8').val( age_from_dates( oday, bday ) );
		//prophet at
		if ( $("#acf-field_5523e64e47c59").val() ) {
			$('#acf-field_5523ea96accc9').val( age_from_dates( pday, bday ) );
		}
		//died at/currently
		if ( $("#acf-field_5522d899a7112").val() ) {
			$('#acf-field_5523ea9faccca').val( age_from_dates( dday, bday ) );
		}
		else {
			$('#acf-field_5523ea9faccca').val( age_from_dates( tday, bday ) );
		}
		
	});
	
	function set_title(){
		
		var first_name = $('#acf-field_5522d813a710c').val();
		var middle_name = $('#acf-field_5522d819a710d').val();
		var last_name = $('#acf-field_5522d81fa710e').val();
		var initial = $('#acf-field_5522d82ba710f').val();

		if (initial == 'middle_name' ){
			var middle_name = middle_name.charAt(0) + '.';
		}
		else if ( initial == 'first_name' ) {
			var first_name = first_name.charAt(0) + '.';
		}
		$('#title').val( first_name + ' ' + middle_name + ' ' + last_name );
	}

		
	function age_from_dates(d1, d2){
		return Math.floor( Math.abs( d1 - d2 ) / 1000 / 60 / 60 / 24 / 365);
	}
	
});
