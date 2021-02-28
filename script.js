(function($) {
    'use strict';

    $(document).on('click', '.youtube-preview', function() {
        var id = $(this).closest('.elementor-row').data('id');

        YTFrame.build(id, 0, $(this).parent());
    });

    $(document).on('click', 'figure.stamp', function() {
        console.log(this);
        var id = $(this).closest('.elementor-row').data('id'),
            time = $(this).find('.timestamp').text().split(':'),
            seconds = 60 * parseInt(time[0]) + parseInt(time[1]);
        console.log($(this).closest('.elementor-row').find('.frame-container')[0]);

        YTFrame.build(id, seconds, $(this).closest('.elementor-row').find('.frame-container')[0]);

    });

    var YTFrame = {
        build: function(id, seconds, container) {
            var iframe = document.createElement('iframe');

            iframe.src = 'https://www.youtube-nocookie.com/embed/' + id + '?autoplay=1&start=' + seconds;
            $(container).html(iframe);
        }
    }
})(jQuery);