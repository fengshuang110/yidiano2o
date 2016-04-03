var getValue = function(obj){
	  	 var type = obj[0].type;
	       if (type === "radio") {              //单选框
	           return $.trim(obj.find("[checked]").val());
	       } else if (type === "select-one") {  //select框
	           return $.trim(obj.find("option:selected").val());
	       } else if (type === "checkbox") {     //复选框
	           var val = [];
	           obj.each(function(){
	               if ($(this).is(":checked")){
	                   val.push($(this).val());
	               }
	           });
	           return val.join(",");
	       } else {
	           return $.trim(obj.val());
	       }
	  };
	  //
	  var RegEventBlur = function(form){
				form.find("[required]").each(function(){
					$(this).blur(function(){
						var name = $(this).attr("name");
			            var value = getValue($(this));
		                if (value === "" || typeof(value) === "undefined") {
		                }else{
		                	isLegal = false;
		                    var errorName = $(this).attr("data-error") ? $(this).attr("data-error") : name;
		                     form.find("span[data-name=" + errorName+"]").text("").show();
		               }
					})
				});
				
				form.find("[data-regular]").each(function(){
					$(this).blur(function(){
						var name = $(this).attr("name");
		                var errorName = $(this).attr("data-error") ? $(this).attr("data-error") : name;
		                var pattern = eval($(this).attr("data-regular"));
		                var value = getValue($(this));
		                if (!pattern.test(value)) {
		                    isLegal = false;
		                    var msg = $(this).attr("data-msg");
		                    form.find("span[data-name=" + errorName+"]").text(msg).show();
		                }else{
		                	 form.find("span[data-name=" + errorName+"]").text("").show();
		                }
					});
	           });
		  }; 
var YWORK = {
	  interval:"",
	  timeClock : function(){//倒计时时间
			$("button[vcode='clock-vcode']").html(wait + "秒后重新发送");
			wait--;
			if(wait == 0){
				wait = 60;
			clearInterval();
			$("button[vcode='clock-vcode']").css("color","#ff6700");
			$("button[vcode='clock-vcode']").html("重新发送");
		}
	},
	err_alert:function(msg){
   	$(".error-alert").find(".errorMsg").text(msg);
   	$(".error-alert").show();
   	$('.error-alert').delay(3000).hide(0);
   },
   Validator:{
   isEmail: function (text) {
       return /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9_])+\.)+([a-zA-Z0-9]{2,4})+$/i.test(text);
   },

   isLnglat: function (lnglat) {
       return /^[1-9]\d+\.\d+$/.test(lnglat);
   },
   
   validateForm: function (form) {
   	$("span[name=error]").hide();
   	RegEventBlur(form);
       var isLegal = true;
       form.find("[required]").each(function(){
       
           var name = $(this).attr("name");
           var value = getValue($(this));
           if (value === "" || typeof(value) === "undefined") {
           	isLegal = false;
               var errorName = $(this).attr("data-error") ? $(this).attr("data-error") : name;
               var msg = $(this).attr("required-msg");
               form.find("span[data-name=" + errorName+"]").text(msg).show();
           }
       });
       
       form.find("[data-regular]").each(function(){
           var name = $(this).attr("name");
           var errorName = $(this).attr("data-error") ? $(this).attr("data-error") : name;
           var pattern = eval($(this).attr("data-regular"));
           var value = getValue($(this));
           if (!pattern.test(value)) {
               isLegal = false;
               var msg = $(this).attr("data-msg");
               form.find("span[data-name=" + errorName+"]").text(msg).show();
           }
       });
       return isLegal;
   }
 }
}
	