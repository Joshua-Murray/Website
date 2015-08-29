


var script = document.createElement('script');
script.src = 'http://code.jquery.com/jquery-1.11.0.min.js';
script.type = 'text/javascript';
document.getElementsByTagName('head')[0].appendChild(script);


<!-- Calculator -->
		
		
		$(document).ready(function()
    {
        $("#calculate").click( function()
        {

		var Q1 = $('#NoLines').val();
		var Q2 = $('#PricePerPint').val();
		var Q3 = $('#NoPintsPerLine').val();
		var Q4 = $('#HoursCleaningPerWeek').val();
		var Q5 = $('#HourlyRate').val();

            			if(jQuery.isNumeric(Q1) && jQuery.isNumeric(Q2) && jQuery.isNumeric(Q3) && jQuery.isNumeric(Q4) && jQuery.isNumeric(Q5)) 
					{
					var SellOffBeer = parseInt($('#NoLines').val()) * parseInt($('#NoPintsPerLine').val()) *  52;
            				var SellOffSavings = parseInt($('#NoLines').val()) * parseInt($('#PricePerPint').val()) * parseInt($('#NoPintsPerLine').val()) *  52 * .9;
            						$('#result').html(SellOffBeer.toFixed());
							$('#result2').html(SellOffSavings.toFixed());

	    				var CleanTimes = parseInt($('#HoursCleaningPerWeek').val()) *  52;
            				var CleanSavings = parseInt($('#HourlyRate').val()) * parseInt($('#HoursCleaningPerWeek').val()) *  52 * .5;
            						$('#result3').html(CleanSavings.toFixed());
							$('#result4').html(CleanTimes.toFixed());
					$('#myModal').foundation('reveal', 'open');
					$('input').css("border", "1px solid #CCC");
					}
            				else {
						if (jQuery.isNumeric(Q1)) {
								
						}
						else {
							$('#NoLines').css("border", "1px solid red");
						}

						if (jQuery.isNumeric(Q2)) {
							
						}
						else {
							$('#PricePerPint').css("border", "1px solid red");
						}
						if (jQuery.isNumeric(Q3)) {
							
						}
						else {
							$('#NoPintsPerLine').css("border", "1px solid red");
						}
						if (jQuery.isNumeric(Q4)) {
							
						}
						else {
							$('#HoursCleaningPerWeek').css("border", "1px solid red");
						}
						if (jQuery.isNumeric(Q5)) {
							
						}
						else {
							$('#HourlyRate').css("border", "1px solid red");
						}
					}
     
		
           
            
        });
    });
		

<!-- End Savings Calculator -->
