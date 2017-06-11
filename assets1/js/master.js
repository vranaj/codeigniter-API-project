$(document).ready(function(){

	$(".validateform").validationEngine('attach', {promptPosition : "topLeft", autoHidePrompt : true, autoPositionUpdate : true, autoHideDelay : 8000});

	//Check if there's a notification message
	if( $('#notification_text').text().length > 5 ) 
	{
		// the timeout is there to make things work properly in <acronym title="Internet Explorer">IE</acronym>
		// If we have no timeout <acronym title="Internet Explorer">IE</acronym> will trigger mousemove instantly
		setTimeout("$('.notification').center().fadeIn('slow')", 200);
		setTimeout(removeMessage, 500);
	}

	//Get screen center
	jQuery.fn.center = function () 
	{
		this.css("position","absolute");
		this.css("top", ( $(window).height() - this.height() ) / 2+$(window).scrollTop() + "px");
		this.css("left", ( $(window).width() - 30 - this.width() ) / 2+$(window).scrollLeft() + "px");
		return this;
	}

	var keep_alive = setInterval(function() {
		$.post('index.php', function(data, status){
	    	console.log('Keep Alive Executed');
	    });
	}, 60 * 1000);

	// datepicker

	$('.datepicker').datepicker({
		format:'yyyy-mm-dd'
	});


});

//Remove notification message
function removeMessage()
{
	$(document).one('click mousemove keypress', function(e) 
	{
		// Fade the message away after 500 ms
		$('.notification').animate({ opacity: 1.0 }, 1000).fadeOut();
	});
}