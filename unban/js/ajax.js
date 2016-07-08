function send(){
$("#result").empty();
var nick = $('#nick').val();
var date = $('#date').val();
var dok = $('#dok').val();
var ip = $('#ip').val();
var prichina = $('#prichina').val();
var contacts = $('#contacts').val();
var captcha = $('#captcha').val();

       $.ajax({
                type: "POST",
                url: "action.php",
                data: "nick="+nick+"&prichina="+prichina+"&ip="+ip+"&dok="+dok+"&contacts="+contacts+"&date="+date+"&captcha="+captcha,

                success: function(html) {
				var min = 10000, max = 99999;
				var rand = min - 0.5 + Math.random()*(max-min+1)
				rand = Math.round(rand);
                        $("#result").empty();
                        $("#result").append(html);
						generate();
                }
        });
}
function generate(){
$("#cpt").attr("src","captcha.php");
$('#captcha').val('');
}