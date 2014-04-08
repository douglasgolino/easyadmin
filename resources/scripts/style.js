$(document).ready(function(){
	$('#data').focus(function(){
		$(this).calendario({ 
			target:'#data',
			top:0,
			left:250,
			closeClick:true
		});
	});

	$(function(){
		// mask
		$(".numeric").numeric(",");
		// format
		$(".numeric").floatnumber(",",2);
	});

});

