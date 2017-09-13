(function() {
    /*
     | Work out whether a given element is in view.
     */
    function inview($ele, completely) {
        var viewportHeight = $(window).height(),
            elementTop = 0,
            elementBottom = 0;

        elementTop = $ele[0].getBoundingClientRect().top;
        elementBottom = $ele[0].getBoundingClientRect().bottom;

        if (completely) {
            elementTop += $ele.height();
            elementBottom -= $ele.height();
        }

        return elementTop < viewportHeight && elementBottom >= 0;
    };

    /*
     | 'Does what it says on the tin'
     */
    function throttle(fn, threshhold, scope) {
        var last;
        var deferTimer;

        if (! threshhold) {
            threshhold = 250;
        }

        return function () {
            var context = scope || this;
            var now = +new Date();
            var args = arguments;

            if (last && now < last + threshhold) {
                clearTimeout(deferTimer);
                deferTimer = setTimeout(function () {
                    last = now;
                    fn.apply(context, args);
                }, threshhold);
            } else {
                last = now;
                fn.apply(context, args);
            }
        };
    };

    /*
     | Create a jQuery plugin for our inview method
     */
    $.fn.inView = function() {
        return inview(this);
    };

    $.fn.whenInview = function(callback, completely) {
        return this.each(function(){
            var $self = $(this);

            function check() {
                if (inview($self, completely)) {
                    callback.call($self);
                }
            }

            $(window).on('scroll resize', throttle(check, 500));

            check();
        });
    };

    $.fn.whenNotInview = function(callback, completely) {
        return this.each(function(){
            var $self = $(this);

            function check() {
                if (! inview($self, completely)) {
                    callback.call($self);
                }
            }

            $(window).on('scroll resize', throttle(check, 500));

            check();
        });
    };

    // We lazy load the images so that we can determine their size when they load.
    $('.facebook-feed-container .owl-carousel .owl-item img').load(function() {
        $(this).parent().parent().parent().parent().parent().trigger('refresh.owl.carousel');
    }).each(function() {
        $(this).prop('src', $(this).data('src'));
     });

    // Setup the post videos.
    $('.facebook-feed-container .facebook-feed-post.video').each(function() {
        var $container = $(this).find('.video');

        // Player
        $container.ContainerPlayer({
            forceAspect: true,
            autoplay: false,
            loop: true,
            html5: {
                src: $container.data('src'),
                poster: $container.data('cover'),
            }
        });

        // Auto start / stop.
        $container.whenInview(function() {
            $container.data('player').play();
        }, true).whenNotInview(function() {
            $container.data('player').pause();
        }, true);

        // Volume control.
        $container.parent().find('.volume-control').click(function() {
            if (! $(this).hasClass('fa-volume-off')) {
                $(this).addClass('fa-volume-off').removeClass('fa-volume-up');
                $container.data('player').mute();
            } else {
                $(this).removeClass('fa-volume-off').addClass('fa-volume-up');
                $container.data('player').unMute();
            }
        });
    });
}());