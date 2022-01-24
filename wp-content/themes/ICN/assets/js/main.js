$(function () {


    //Countdown timing
    if( $('#countdown-panel').length ) {
        $('#countdown-panel').countdown('2017/05/12', function (event) {
            get_day = event.strftime('%n');

            $('#cd-m').html(event.strftime('%m'));
            $('#cd-d').html(event.strftime('%n'));
            $('#cd-h').html(event.strftime('%H'));

        });
    }
    // allow user to add up to 5 images
    $image_counter = 0;



        //check the upload file size
        $('.share_your_story_upload').bind('change', function () {

                var fileSize = this.files[0].size;
                var sizeInMB = (fileSize / (1024*1024)).toFixed(2);

                if(sizeInMB >=2 ) {
                    alert('Your uploaded File is greater than 2MB. Please re-upload your file with smaller size.');
                    $(this).val('');
                }


        });


    // focus on tab pane when list click
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        $('.goal_box a').removeClass('active');
        $(this).addClass('active');
        var panel = $(this).data('controls');
        $("html, body").animate({ scrollTop: $('#'+panel).offset().top }, 800);
    })

    // show search form
    $('#show_small_search_div').on('click', function () {

        $(this).find('#small_search_div').fadeIn();
    });

    //Navigation Menu Slider
    $('#nav-expander').on('click',function(e){
        e.preventDefault();
        $('body').toggleClass('nav-expanded');
    });

    $('#nav-close').on('click',function(e){
        e.preventDefault();
        $('body').removeClass('nav-expanded');
    });

    $('.sub-menu').hover(
        function() {
            $( this ).prev('a').addClass( "hovered" );
        }, function() {
            $( this ).prev('a').removeClass( "hovered" );
        }
    );


    $section0 = $('.home-section-0');
    $section1 = $('.home-section-1');
    $section2 = $('.home-section-2');
    $section3 = $('.home-section-3');
    $(window).on('scroll', function() {
        if($section0.length > 0) {
            if (isScrolledIntoView($section0)) {
                $section0.find('div[class*="floating-square-"]').addClass("animated fadeInUpCustom");
            }
            if (isScrolledIntoView($section1)) {
                $section1.find('div[class*="floating-square-"]').addClass("animated fadeInLeftCustom");
            }
            if (isScrolledIntoView($section2)) {
                $section2.find('div[class*="floating-square-"]').addClass("animated fadeInDownCustom");
            }
            if (isScrolledIntoView($section3)) {
                $section3.find('div[class*="floating-square-"]').addClass("animated fadeInRightCustom");
            }
        }
    });

    function isScrolledIntoView(elem) {
        var docViewTop = $(window).scrollTop();
        var docViewBottom = docViewTop + $(window).height();

        var elemTop = $(elem).offset().top;
        var elemBottom = elemTop + $(elem).height() - 300;

        return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop ));
    }


});

// limit the number of character
function limitText(limitField, limitCount, limitNum) {
    if (limitField.value.length > limitNum) {
        limitField.value = limitField.value.substring(0, limitNum);
    } else {
        limitCount.value = limitNum - limitField.value.length;
    }
}