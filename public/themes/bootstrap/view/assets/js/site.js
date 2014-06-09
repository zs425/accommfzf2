imagePreview = function(){ 
    /* CONFIG */ 
    var posY;

    xOffset = 15;
    yOffset = 10; 
    // these 2 variable determine popup's distance from the cursor
    // you might want to adjust to get the right result 
    /* END CONFIG */ 
    $("a.preview").on('mouseenter', function(e){  
        this.t = this.title;
        this.title = "";	
        var c = (this.t != "") ? "<br/>" + this.t : "";
        $("body").append("<p id='preview'><img src='"+ this.href +"' alt='Image preview' />"+ c +"</p>");								 
        $("#preview")
        .css("position", "absolute")
        .css("top",(e.clientY - yOffset) + "px")
        .css("left",(e.clientX + xOffset) + "px")
        .css("z-index","1200")
        .fadeIn("fast");
    });
    $("a.preview").on('mouseout',function(){
        this.title = this.t; 
        $("#preview").remove();
    }); 
    $("a.preview").on('mousemove', function(e){
        var posY;
        if (e.pageY - $(window).scrollTop() + $('#preview').height() >= $(window).height() ) {
            posY = $(window).height() + $(window).scrollTop() - $('#preview').height() - ($('#preview').height()/2) ;
        } else {
            posY = e.pageY - 15;
        }

        $("#preview")
        .css("top",(posY) + "px")
        .css("left",(e.pageX + 15) + "px");
    }); 
};