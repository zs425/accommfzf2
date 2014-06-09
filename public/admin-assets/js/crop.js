var crop = {
    
    api: null,
    imageSource: null,
    thumbnailSource: null,
    button: null,
    thumbnailImage: null,
    
    
    construct: function()
    {
        
    },
    
    open: function(button, imageSource, thumbnailSource, width, height, thumbnailImage)
    {
        this.button = button;
        this.imageSource = imageSource;
        this.thumbnailSource = thumbnailSource;
        this.thumbnailImage = thumbnailImage ? thumbnailImage : null;
        
        $('#modal-crop .modal-body').html('<img id="crop-image" src=' + imageSource + '>');
        $('#modal-crop').modal('show');
        
        var boxWidth = width > 500 ? 500 : width;
        var boxHeight = height > 365 ? 365 : height;
        var that = this;
        $('#crop-image').Jcrop(
            {
                boxWidth: boxWidth,
                boxHeight: boxHeight,
                trueSize: [ width, height ]
            },
            function(){
                that.api = this;
            }
        );
    },
    
    crop: function()
    {
        var that = this;
        var selection = this.api.tellSelect();
        $('#crop-save').attr('disabled', 'disabled');
        this.api.disable();
        $.post(
            '/admin/utils/crop-image',
            {
                src: this.imageSource,
                thumbnail: this.thumbnailSource,
                x: selection.x,
                y: selection.y,
                width: selection.w,
                height: selection.h,
                format: 'json'
            },
            function(response)
            {
				console.log(response);

                var now = new Date();
                if (response.success) {
                    $('#modal-crop').modal('hide');
                    that.api.destroy();
                    var imageSource = that.imageSource + "?" + now.getTime();
                    var thumbnailSource = that.thumbnailSource + "?" + now.getTime();
                    that.button.attr('onclick', "crop.open($(this), '" + imageSource + "', '" + thumbnailSource + "', "
                        + selection.w + ", " + selection.h + (that.thumbnailImage ? (", '" + this.thumbnailImage + "'") : '') + "); return false;");
                    
                    if (that.thumbnailImage) {
                        $(that.thumbnailImage).attr('src', thumbnailSource);
                    } else {
                        var parent = that.button.parent().parent();
                        parent.find('a[rel=gallery]').attr('href', imageSource);
                        parent.find('a[rel=gallery] img').attr('src', thumbnailSource);
                    }
                    
                    $('#crop-save').removeAttr('disabled');
                }
            },
            'json'
        );
    }
    
};

$(function(){
    crop.construct();
});