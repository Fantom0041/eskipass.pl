//------------------------------
//Animations
//------------------------------
$('.dashboard-right').css({'margin-right':-100+'px'});
$('.dashboard-right').animate({'margin-right':0+'px'}, 1500);

$('.dashboard-left').css({'top':-100+'px'});
$('.dashboard-left').animate({'top':0+'px'}, 1500);



function updateDropsize(){
	$(document).ready(function() {
		$dashleft = $('.dashboard-left').innerWidth();
		$('.lftwidth').css({'width':$dashleft +'px','margin-top':-65+'px'});
	});
}


updateDropsize();


//------------------------------
//ON RESIZE
//------------------------------
$(window).resize(function() {
	
	updateDropsize();
});

setTimeout(function (){
	jQuery(document).ready(function() {
		jQuery(".stats2container").niceScroll({horizrailenabled:true,cursorwidth:"3px",cursorcolor:"#ccc",});
		jQuery(".fixedtopic").niceScroll({horizrailenabled:false,cursorwidth:"3px",cursorcolor:"#ccc",});
		jQuery(".dashboard-left").niceScroll({horizrailenabled:false,cursorwidth:"3px",cursorcolor:"#ccc",});
	});
}, 1500);	

//------------------------------
//POPOVER
//------------------------------
$(function (){
	$("#messages").popover({placement:'bottom', trigger:'click',html : true});
	//$("#messages").popover('show');
	$("#notifications").popover({placement:'bottom', trigger:'click',html : true});
	$("#tasks").popover({placement:'bottom', trigger:'click',html : true});
});



