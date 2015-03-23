(function($){

    $(document).ready(function() {

        var processing = false,
            interval   = null,
            delay      = 5000,
            url        = location.href+'/process',
            left       = Infinity,
            $start     = $('[data-processing-start]'),
            $stop      = $('[data-processing-stop]'),
            $state     = $('[data-processing-state]');

        function updateUI() {
            if (processing) {
                $start.addClass("uk-hidden");
                $stop.removeClass("uk-hidden");
                $state.removeClass("uk-hidden");

                $state.html('<i class="uk-icon-spinner uk-icon-spin"></i> '+left+' pending emails left');
            } else {
                $stop.addClass("uk-hidden");
                $start.removeClass("uk-hidden");
                $state.addClass("uk-hidden");
            }
        }

        function step() {
            // processing step
            $.getJSON(url, function(json) {
                left = parseInt(json.count, 10);
                updateUI();
            });
        }

        function start() {
            processing = true;
            interval = setInterval(function() {
                if (left <= 0) {
                    stop();
                    return;
                }

                step();
            }, delay);
            step();
            updateUI();
        }

        function stop() {
            processing = false;
            clearInterval(interval);

            location.reload();
        }

        $('[data-processing-start]').on('click', start);
        $('[data-processing-stop]').on('click', stop);

        updateUI();
    });

})(jQuery);