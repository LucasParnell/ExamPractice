$(window).on('pageshow', function(){

    console.log("A");
    $(".allContent").fadeOut(0,function(){
        $(this).fadeIn(400);
    });



    //Page redirect function
    //If a button is clicked and has the data attribute 'redir-loc:', use JQuery to fade out the page
    $('[data-redir-loc]').on('click', function(){
        var targetUrl = $(this).attr("data-redir-loc");

        $(".allContent").fadeOut(400,function(){
            window.location.href = targetUrl;
        });



    });

});