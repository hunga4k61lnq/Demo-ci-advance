
$(function() {
	
	jQuery('.mainmenu').meanmenu();	
	$(".mean-bar").headroom({
		offset : 100,
		tolerance : {
		   up : 100,
		   down : 50
		},           classes : { 
		   initial : "headroom",
		   pinned : "headroom--pinned",
		   unpinned : "headroom--unpinned",
		}
	});
});