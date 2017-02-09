var uv_popup;
var uv_poploader;
var uv_popvisor;
var pop_error = true;
var uv_weekdaysres = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
var uv_yearmonths = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
var uv_resopendays = Array();
var uv_loadmoreitems = Array();

jQuery(document).ready(function(){
	uvLoadFade();
	
	jQuery("body").append("<div id='uv-pop-up' class='uv-pop-cont'><div class='uv-pop-box'><a class='uv-closepop uvjs-closepop' href='javascript:;'></a><div class='uv-pop-charge'></div></div></div>");
	jQuery("body").append("<div id='uv-pop-visor' class='uv-pop-cont'><div class='uv-pop-box'><a class='uv-closepop uvjs-closepop' href='javascript:;'></a><div class='uv-pop-visorbox'><div class='uv-pop-charge'></div></div></div></div>");
	jQuery("body").append("<div id='uv-pop-loader' class='uv-global-loader uv-pop-cont'></div>");
	uv_popup = jQuery("#uv-pop-up");
	uv_popvisor = jQuery("#uv-pop-visor");
	uv_poploader = jQuery("#uv-pop-loader");
	
	jQuery(".uvjs-validate").each(function(){
		uvValidateInit(jQuery(this));
	});
	
	jQuery(".uvjs-resdatepicker").each(function(){
		uvInitResdatepicker(jQuery(this));
	});
});


jQuery(document).on("click", "body", function(){
	if((jQuery(".uv-pkcalendar:hover").length < 1) && (jQuery(".uv-show-pkcalendar:hover").length < 1) && (jQuery(".uv-pkcalendar").hasClass("visible")))
		jQuery(".uv-pkcalendar").removeClass("visible");
});
jQuery(document).on("click", ".uv-show-pkcalendar", function(){
	if(jQuery(this).siblings(".uv-pkcalendar").hasClass("visible"))
		jQuery(this).siblings(".uv-pkcalendar").removeClass("visible");
	else
		jQuery(this).siblings(".uv-pkcalendar").addClass("visible");
});
jQuery(document).on("click", ".uvjs-showdropdown", function(e){
	e.preventDefault();
	if(jQuery(this).siblings(".uv-dropdown-menu").hasClass("visible"))
		jQuery(this).siblings(".uv-dropdown-menu").removeClass("visible");
	else
		jQuery(this).siblings(".uv-dropdown-menu").addClass("visible");
});
jQuery(document).on("click", ".uv-calendar-menu > li button", function(e){
	e.preventDefault();

	jQuery(this).closest("li").addClass("active").siblings().each(function(){
		jQuery(this).removeClass("active");
		
		if(jQuery(this).find("a").hasClass("uvjs-triggervisible"))
			jQuery(jQuery(this).find("a").data("target")).removeClass("visible");
	});
});
jQuery(document).on("click", ".uv-calendar-menu > li a", function(){
	jQuery(".uv-calendar-charge").attr("class", "").addClass("uv-calendar-charge").addClass(jQuery(this).data("calvisibleclass"));
});
jQuery(document).on("click", ".uvjs-calendar-loadmonth", function(e){
	e.preventDefault();
	
	var uvloadmonthurl = jQuery(".uv-calendar-controls").data("loadmonthurl").replace("{uvsdate}", jQuery(this).data("sdate"));
	jQuery(".uv-calendar-month").html(jQuery(this).data("ddate"));
	
	jQuery(this).closest(".uv-dropdown-menu").find("li").removeClass("current");
	jQuery(this).closest("li").addClass("current");
	
	jQuery(".uv-calendar-charge").addClass("uv-loading").load(uvloadmonthurl, function(){
		uvLoadFade();
		jQuery(this).removeClass("uv-loading");
	});
});
jQuery(document).on("click", ".uv-dropdown-menu a", function(){
	if(!jQuery(this).hasClass("noclose"))
		jQuery(this).closest(".uv-dropdown-menu").removeClass("visible");
});
jQuery(document).on('click', '.uv-panel .uv-panelheader button', function(){
	var uvpaneltarget = jQuery(this).data('target');

	jQuery('.uv-panel .uv-panelheader button').each(function(){
		var uvotherpaneltarget = jQuery(this).data('target');
	
		if(uvotherpaneltarget != uvpaneltarget){
			if(!jQuery(uvotherpaneltarget).hasClass('closed'))
				jQuery(uvotherpaneltarget).find('.uv-panelbody').slideUp(function(){jQuery(uvotherpaneltarget).addClass('closed');});
		}
	});

	if(jQuery(uvpaneltarget).hasClass('closed'))
		jQuery(uvpaneltarget).find('.uv-panelbody').slideDown(function(){jQuery(uvpaneltarget).removeClass('closed');});
	else
		jQuery(uvpaneltarget).find('.uv-panelbody').slideUp(function(){jQuery(uvpaneltarget).addClass('closed');});
});
jQuery(document).on("click", ".uvjs-hideandshow", function(){
	jQuery(jQuery(this).data("targethide")).hide();
	jQuery(jQuery(this).data("targetshow")).show();
});
jQuery(document).on("click", ".uvjs-pk-book", function(){
	var uvpkid = jQuery(this).data("pkid");
	var uvpkuv = jQuery(this).data("pkuv");
	var uvpkrm = jQuery(this).data("pkrm");
	var uvpkpopurl = jQuery(this).data("pkpopurl");
	var uvpkqty = jQuery("select[name='nguests-" + uvpkid + "']").val();
	
	uvFadePopup(uv_poploader);
	uv_popup.addClass("uv-pkpopup");
	uvExpandPopup(uv_popup, 370);
	uvLoadPopup(uv_popup, uvpkpopurl + "&uvpkid=" + uvpkid + "&uvpkqty=" + uvpkqty + "&uvpkuv=" + uvpkuv + "&uvpkrm=" + uvpkrm, function(){uvFadePopup(uv_popup);})
});
jQuery(document).on("click", ".uv-pk-gocheck", function(){
	if((jQuery(".uv-pkddate").val() != undefined) && (jQuery(".uv-pkddate").val().length > 1)){
		var uvpkcheckouturl = jQuery(".uv-pkform").attr("action") + "/";
		jQuery(".uv-pkform").find(".uv-pkckeckshort").each(function(){
			uvpkcheckouturl = uvpkcheckouturl + jQuery(this).attr("name") + jQuery(this).val();
		});
		uvpkcheckouturl = uvpkcheckouturl + "/";
		
		uvFadePopup(uv_poploader);
		jQuery(".uv-pkform").attr('action', uvpkcheckouturl);
		jQuery(".uv-pkform").submit();
	}
	else
		alert("Please Select a Date");
});
jQuery(document).on("click", ".uvjs-loadalbumpop", function(e){
	e.preventDefault();
	
	var uvalbumcode = jQuery(this).data("albumcode");
	var uvloadpopurl = jQuery(this).data("loadpopurl");
	
	uvFadePopup(uv_poploader);
	uv_popvisor.addClass("uv-visor-default");
	uv_popvisor.addClass("clearonclose");
	uvLoadPopup(uv_popvisor, uvloadpopurl + "&ac=" + uvalbumcode, function(){uvFadePopup(uv_popvisor);});
});
jQuery(document).on("click", ".uvjs-setpic", function(e){
	e.preventDefault();
	
	jQuery(this).siblings().removeClass("active");
	jQuery(this).addClass("active");
	
	var uvbigpic = jQuery(this).data("bigpic");
	jQuery(".uv-pa-picvisor .uv-pa-picharge").html("<img class='uv-loadfade' src='" + uvbigpic + "' onload='jQuery(this).fadeIn();'>");
});
jQuery(document).on("click", ".uvjs-pa-nextpic", function(e){
	uvPaNext();
});
jQuery(document).on("click", ".uvjs-pa-prevpic", function(e){
	uvPaPrev();
});
jQuery(document).on("keydown", function(e){
	if(jQuery(".uv-pa-list").length > 0){
	    if(e.which == 37)
	        uvPaPrev();
	    else if(e.which == 39)
	        uvPaNext();
	}
}); 



function uvValidateInit(uvformtarget){
	uvformtarget.validate({
		submitHandler : function(form){
			if(jQuery(form).data("sendmethod") == "ajax"){
				uvDisplayMsg("Sending...", "", "hidden");
			
				jQuery.ajax({
					type: "post",
					url: jQuery(form).attr("action"),
					data: jQuery(form).serialize(),
					success: function(result){
						if(result == "uv1"){
							uvDisplayMsg(jQuery(form).data("successmsg"), "Success", "OK", 450);
							jQuery(form).find("input[type='text'], input[type='number'], textarea").val('');
						}
						else
							uvDisplayMsg("Something went wrong, try again");
					}
				});
			}
		}
	});
}
function uvInitResdatepicker(uvformfieldtarget){
	if(uvformfieldtarget.data("maxdate") != undefined){
		var uvmaxresdate = uvformfieldtarget.data("maxdate").replace(/-/g, '/');
		uvmaxresdate = new Date(uvmaxresdate);
	}
	else
		var uvmaxresdate = "";

	uvformfieldtarget.datepicker({
		dateFormat: 'yy-mm-dd', 
		minDate: new Date(),
		maxDate: uvmaxresdate,
		onSelect: function(seldate){
			uvformfieldtarget.closest("form").find("input[name='resdate']").val(seldate);
		
			seldate = seldate.replace(/-/g, '/');
		    seldate = new Date(seldate);
		    seldate = uv_weekdaysres[seldate.getDay()] + ', ' + uv_yearmonths[seldate.getMonth()] + ' ' + (seldate.getDate()) + ', ' + seldate.getFullYear();
		
		    uvformfieldtarget.val(seldate);
		},
		beforeShowDay: function(obdate){
			var uvformresdate = uvFoDate(obdate);
			var uvformrestypeid = uvformfieldtarget.closest("form").find("input[name='restypeid']").val();
			
			var uvshowdate = ((typeof(uv_resopendays["r" + uvformrestypeid]) == "undefined") || typeof(uv_resopendays["r" + uvformrestypeid][uvformresdate]) != "undefined") ? true : false;
			
			return [uvshowdate, "", ""];
		},
		beforeShow: function(){jQuery('#ui-datepicker-div').addClass("uv-resdatepicker");}
	});
}
function uvPaNext(){
	var uvcurpicob = jQuery(".uv-pa-list .active");
	jQuery(".uv-pa-list .active").removeClass("active");

	if(uvcurpicob.is(":last-child"))
		var uvnextpicob = jQuery(".uv-pa-list").children().eq(0);
	else
		var uvnextpicob = jQuery(".uv-pa-list").children().eq(uvcurpicob.index() + 1);
		
	uvnextpicob.addClass("active");
	var uvbigpic = uvnextpicob.data("bigpic");
	jQuery(".uv-pa-picvisor .uv-pa-picharge").html("<img class='uv-loadfade' src='" + uvbigpic + "' onload='jQuery(this).fadeIn();'>");
}
function uvPaPrev(){
	var uvcurpicob = jQuery(".uv-pa-list .active");
	jQuery(".uv-pa-list .active").removeClass("active");

	if(uvcurpicob.is(":first-child"))
		var uvnextpicob = jQuery(".uv-pa-list").children().last();
	else
		var uvnextpicob = jQuery(".uv-pa-list").children().eq(uvcurpicob.index() - 1);
		
	uvnextpicob.addClass("active");
	var uvbigpic = uvnextpicob.data("bigpic");
	jQuery(".uv-pa-picvisor .uv-pa-picharge").html("<img class='uv-loadfade' src='" + uvbigpic + "' onload='jQuery(this).fadeIn();'>");
}


/*POPUPS ACTIONS*/
jQuery(document).on("click", ".uv-pop-cont", function(){
	uvHidePopup(jQuery(this));
});
jQuery(document).on("click", ".uvjs-closepop", function(){
	uvHidePopup(jQuery(this).closest(".uv-pop-cont"), true);
});
jQuery(document).on("click", ".uvjs-popimg", function(e){
	e.preventDefault();
	
	var uvimageurl = jQuery(this).attr('href');
	var uvimgpoptitle = (jQuery(this).data('poptitle') != undefined) ? jQuery(this).data('poptitle') : "";
	uvFadePopup(uv_poploader);
	uvExpandPopup(uv_popup, 800);
	uvClearPopup(uv_popup, '<div class="uv-popheader"><h3>' + uvimgpoptitle + '</h3></div><div class="uv-popbody uv-popimage"><img src="' + uvimageurl + '" onload="uvHidePopup(uv_poploader, true); uvFadePopup(uv_popup);"></div>');
});
/***************/

/*POPUPS FUNCTIONS*/
function uvLoadPopup(uvpoptarget, uvpopload, uvpopcallback){
	uvpoptarget.find(".uv-pop-charge").load(uvpopload, function(){
		if(uvpopcallback && typeof(uvpopcallback) === "function")  
        	uvpopcallback();
	});
}
function uvClearPopup(uvpoptarget, uvpopcontent){
	uvpopcontent = (uvpopcontent != undefined) ? uvpopcontent : "";
	uvpoptarget.find(".uv-pop-charge").html(uvpopcontent);
}
function uvExpandPopup(uvpoptarget, uvpopexpand){
	uvpoptarget.find(".uv-pop-box").css("max-width", uvpopexpand);
}
function uvFadePopup(uvpoptarget){
	uv_poploader.removeClass("visible");

	jQuery("html").addClass("uv-pop-open");
	uvpoptarget.addClass("visible");
}
function uvHidePopup(uvpoptarget, uvpopforceclose){
	uvpopforceclose = (uvpopforceclose != undefined) ? uvpopforceclose : false;

	if((uvpopforceclose) || ((uvpoptarget != undefined) && (uvpoptarget.find(".uv-pop-box").length > 0) && (uvpoptarget.find(".uv-pop-box:hover").length < 1))){
		if(uvpoptarget.hasClass("clearonclose"))
			uvClearPopup(uvpoptarget);
	
		uvpoptarget.attr("class", "uv-pop-cont");
		jQuery("html").removeClass("uv-pop-open");
		
		setTimeout(function(){
			uvpoptarget.find(".uv-pop-box").css("max-width", "");
		}, 300);
	}
}
/***************/

/**/
function uvDisplayMsg(uvmsg, uvmsgtitle, uvmsgbutton, uvmsgpopexpand){
	if(uvmsgtitle == undefined)
		uvmsgtitle = "Message";
	if(uvmsgbutton == undefined)
		uvmsgbutton = "OK";
	if(uvmsgpopexpand == undefined)
		uvmsgpopexpand = 400;
	
	if(uvmsgbutton != "hidden")
		var uvmsgbutton = "<button class='uvjs-closepop uv-btn uv-btn-100 uv-btn-s'>" + uvmsgbutton + "</button>";
	else
		var uvmsgbutton = "";
		
	uvExpandPopup(uv_popup, uvmsgpopexpand);
	uvClearPopup(uv_popup, "<div class='uv-popheader'><h3>" + uvmsgtitle + "</h3></div><div class='uv-popbody'>" + uvmsg + uvmsgbutton + "</div>");
	uvFadePopup(uv_popup);
}
/******/

function uvLoadFade(){
	jQuery('.uv-loadfade').load(function(){
		if(jQuery(this).data("target") == undefined)
			jQuery(this).fadeIn();
		else if(jQuery(this).data("target") == "parent")
			jQuery(this).parent().fadeIn();
	}).each(function(){
	  if(this.complete)
	  	jQuery(this).load();
	});
}
function uvFoDate(date){
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [year, month, day].join('-');
}