function showTipsIfBlank(o, text) {
    if (o.val() == '') {
        o.val(text);
        o.css('color', '#808080');
    }
}

function clearTipsIfHas(o, text) {
    if (o.val() == text) {
        o.val('');
        o.css('color', 'black');
    }
}

(function($) {

    // jQuery plugin definition
    $.fn.tips = function(params) {

        // merge default and user parameters
        //params = $.extend({ defaultTime: 0, mouseoverClass: 'jquery-timepicker-mouseover' }, params);
        var t = $(this);
        var id = t.attr('id');

        showTipsIfBlank(t, params.text);

        t.focus(function() {
            clearTipsIfHas($(this), params.text);
        });

        t.blur(function() {
            showTipsIfBlank($(this), params.text);
        });

        if (theForm) {
            // asp.net will create a variable named theForm, and use it's onsubmit event
            theForm.onsubmit = function() {
                clearTipsIfHas($('#' + id), params.text);
            };
        }
        else {
            // otherwise, handle the form submit event
            $('form').submit(function() {
                clearTipsIfHas($('#' + id), params.text);
            });
        }

        return this;
    };

})(jQuery);