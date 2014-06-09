function slideAutoSwitch(images) {
    var active = $(".slide-img").css('background-image');
    pieces = active.split('/');
    active = '/'+pieces[3]+'/'+pieces[4]+'/'+pieces[5]+'/'+pieces[6].replace(')', '');
    var next = images[0];
    var currentIdx = 0;
    $.each(images, function(idx, url){
    	if (url == active) {
    		if(images[idx+1] !== undefined) { //.length >= (idx+1)
    			next = images[idx+1];
    			currentIdx = idx+1;
    		} else {
    			next = images[0];
    			currentIdx = 0;
    		}
    		return false;
    	}
    });
    $('.slide-caption').fadeOut('200');
    $(".slide-img").animate({opacity: 0.1}, 200, function() {
    	$(".slide-pag .widebullet").attr('src', '/modules/slideshow/scripts/images/wide_bullets.png');
    	$(".slide-pag .bullet_"+currentIdx).attr('src', '/modules/slideshow/scripts/images/wide_bullets_selected.png');
        $(this).css('background-image', 'url('+next+')')
	    	   .animate({opacity: 1.0}, 1000);
    	if($('.slide_'+currentIdx).length > 0)
    		$('.slide_'+currentIdx).fadeIn();	
    });
};
function slideSwitch(images, idx) {
	idx = parseInt(idx);
	$('.slide-caption').fadeOut('200');
    $(".slide-img").animate({opacity: 0.1}, 50, function() {
    	$(".slide-pag .widebullet").attr('src', '/modules/slideshow/scripts/images/wide_bullets.png');
    	$(".slide-pag .bullet_"+idx).attr('src', '/modules/slideshow/scripts/images/wide_bullets_selected.png');
    	if(images[idx+1] !== undefined)
			$('.widenext').attr('alt', (idx+1));
    	else
    		$('.widenext').attr('alt', '0');
    	if(idx > 0)
			$('.wideprev').attr('alt', idx-1);
    	else
    		$('.wideprev').attr('alt', (images.length-1));
        $(this).css('background-image', 'url('+images[idx]+')')
	    	   .animate({opacity: 1.0}, 200);
        if($('.slide_'+idx).length > 0)
    		$('.slide_'+idx).fadeIn();	
    });
}