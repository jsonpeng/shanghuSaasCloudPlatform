$(function(){
	$("#praise").click(function(){
		var praise_img = $("#praise-img");
		var text_box = $("#add-num");
		var praise_txt = $("#praise-txt");
		var num=parseInt(praise_txt.text());
		if(praise_img.hasClass('select')){
			$(this).html("<i  id='praise-img' class='animation icon ion-thumbsup'></i>");
			praise_txt.removeClass("hover");
			text_box.show().html("<em class='add-animation'>-1</em>");
			$(".add-animation").removeClass("hover");
			num -=1;
			praise_txt.text(num);
		}else{
			$(this).html("<i  id='praise-img' class='animation icon ion-thumbsup select'></i>");
			praise_txt.addClass("hover");
			text_box.show().html("<em class='add-animation'>+1</em>");
			$(".add-animation").addClass("hover");
			num +=1;
			praise_txt.text(num);
		}
	});
})