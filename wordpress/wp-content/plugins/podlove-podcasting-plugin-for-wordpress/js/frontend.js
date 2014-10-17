jQuery(function($) {

	$(".episode_downloads").each(function() {
		var $select = $("select", this),
		    $that = this;

		$("button.secondary", this).on("click", function(e) {
			e.preventDefault();
			prompt("Feel free to copy and paste this URL", $("option", $select).filter(":selected").data("raw-url"));
			return false;
		});
	});
	
});