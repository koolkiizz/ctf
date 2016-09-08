$(document).ready(function(){
		// Menu settings
		$('#menuToggle, .menu-close').on('click', function(){
			$('#menuToggle').toggleClass('active');
			$('body').toggleClass('body-push-toleft');
			$('#theMenu').toggleClass('menu-open');
		});

		// var doc_h = $(document).height();
		// if($(".wrapper_body").height() < (doc_h - 135)) {
		// 	alert(""+$(".wrapper_body").height());
		// 	//$(".wrapper_body").height(doc_h - 105);
		// }
	}
)