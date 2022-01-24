$(function(){
    // * Social share
    // Add right URL to share link
    let $ogURL = $('meta[property="og:url"]').attr('content');
    let $ogDesc = $('meta[property="og:description"]').attr('content');
    let defURL =  encodeURI($ogURL);


    $('.acw-social-share a.acw-social-share-fb').click(function(e){
        e.preventDefault();
        window.open("https://www.facebook.com/sharer/sharer.php?u=" + defURL + "&amp;src=sdkpreparse", '', 'width=625,height=435');
    });

    $('.acw-social-share a.acw-social-share-tw').click(function(e){
        e.preventDefault();
        window.open('https://twitter.com/share?url=' + defURL + '&amp;text=' + $ogDesc + '&amp;hashtags=ICN', '', 'width=625,height=435');
    });

    $('.acw-social-share a.acw-social-share-li').click(function(e){
        e.preventDefault();
        window.open('https://www.linkedin.com/shareArticle?mini=true&url=' + defURL, '', 'width=1200,height=700');
    });

});
