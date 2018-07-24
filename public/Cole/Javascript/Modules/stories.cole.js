$(function() {
    Cole.DataActions = {
		Get: function(Data){
            $('body').addClass('NoSide');
            $.each(jQuery('textarea[data-autoresize]'), function() {
                var offset = this.offsetHeight - this.clientHeight;     
                var resizeTextarea = function(el) {
                    jQuery(el).css('height', 'auto').css('height', el.scrollHeight + offset);
                };
                $(this).on('keyup input', function() { resizeTextarea(this); }).removeAttr('data-autoresize');
            });
        }
	};
    
    
});