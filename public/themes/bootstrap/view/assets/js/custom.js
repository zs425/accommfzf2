$(document).ready(function () {
    $(function () {
        $(".hasDatepick").datepicker({
            numberOfMonths: 2,
            dateFormat: 'dd M yy',
            minDate: new Date((new Date).getTime() + (24 * 60 * 60 * 1000)) //tomorrow
        });
    });
    $(function () {
        $('.header_slider').slides({
            generatePagination: false,
            generateNextPrev: true,
            paginationClass: 'slider_pagination',
            play: 5000,
            pause: 3500,
            hoverPause: true,
            effect: 'fade',
            crossfade: true,
            preload: true,

            preloadImage: '/shared/viewpages/accommodation/enhanced/bootstrap1/images/loading.gif'
        });
    });
    $(function () {
        $('img.lazy-load').jail();
    });

    $(function () {
        /* CONFIG */
        var posY;

        xOffset = 15;
        yOffset = 10;
        // these 2 variable determine popup's distance from the cursor
        // you might want to adjust to get the right result
        /* END CONFIG */
        $(document).on('mouseover', "a.preview", function (e) {
            this.t = this.title;
            this.title = "";
            var c = (this.t != "") ? "<br/>" + this.t : "";
            $("body").append("<p id='preview'><img src='" + this.href + "' alt='Image preview' />" + c + "</p>");
            $("#preview")
                .css("position", "absolute")
                .css("top", (e.clientY - yOffset) + "px")
                .css("left", (e.clientX + xOffset) + "px")
                .css("z-index", "1200")
                .fadeIn("fast");
        });

        $(document).on('mouseout', "a.preview", function () {
            this.title = this.t;
            $("#preview").remove();
        });

        $(document).on('mousemove', "a.preview", function (e) {
            var posY;
            if (e.pageY - $(window).scrollTop() + $('#preview').height() >= $(window).height()) {
                posY = $(window).height() + $(window).scrollTop() - $('#preview').height() - ($('#preview').height() / 2);
            } else {
                posY = e.pageY - 15;
            }

            $("#preview")
                .css("top", (posY) + "px")
                .css("left", (e.pageX + 15) + "px");
        });
    });
});


