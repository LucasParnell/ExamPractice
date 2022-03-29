var modalHtml = "";
const DEBUG_ENABLED = true;




$(window).on('pageshow', function(){
    $(".allContent").fadeOut(0,function(){
        $(this).fadeIn(400);
    });

    $("#page-load").fadeOut(0);

    //Page redirect function
    //If a button is clicked and has the data attribute 'redir-loc:', use JQuery to fade out the page
    $('[data-redir-loc]').on('click', function(){
        redirectPage($(this).attr("data-redir-loc"));
    });
});


function redirectPage(url){
    var targetUrl = url;

    $(".allContent").fadeOut(400,function(){
        window.location.href = targetUrl;
    });
}


//Async stuff
$(function(){
    $(".item-box").on("click", function(){

        var taskId = $(this).attr("data-task-id");
        let taskInfoModal = $("#taskInfoModal[data-task-id='"+taskId+"']");
        let taskInfoStartButton = taskInfoModal.children().find("#taskInfoStartTaskButton");

        var taskItemBox = this;

        taskInfoModal.modal("show");

        taskInfoStartButton.off("click").on("click",function(){
            taskInfoModal.modal("hide");
        
            $("#page-load").fadeIn(100);
            $.ajax(
                {
                    type: "POST",
                    url: "ajaxBuildTask.php",
                    data: {"taskId": $(taskItemBox).attr("data-task-id")},

                    success: function(result){ 
                        $("#page-load").fadeOut(100);
                        modalHtml = result;
                    },

                    failure: function(){
                        $("#page-load").fadeOut(100);
                        return;
                    }
                })
                
                .then(function(){
                    $("#modal-space").html(modalHtml);
                    taskModal = $("#taskModal");
                    taskModal.modal("show");

                    //Set up event for modal submit
                    $("#taskFinishButton").off("click").on("click", function(){
                        //Validate
                        //AJAX submit form
                        let form = taskModal.children().find("form");

                        //Make sure all questions have data
                        let error = false;
                        for(let i=0; i<form.serializeArray().length; i++){
                            let current =$("[name='q_"+i+"']");
                            if(current.val().length < 1){
                                error = true;
                                current.addClass("is-invalid");

                            }
                            else{
                                current.removeClass("is-invalid");
                            }
                        }

                        if(!error){
                            //Close and update dashboard
                            taskModal.modal("hide");
                            $("#page-load").fadeIn(100);
                            $.ajax(
                                {
                                    type: "POST",
                                    url: "ajaxSubmitTask.php",
                                    data: {"taskId": $(this).attr("data-task-id"), "form": JSON.stringify(form.serializeArray())},
                    
                                    success: function(result){ 
                                        $("#page-load").fadeOut(100);
                                        console.log("Server Returned: \n" + result);

                                        //Debug toast
                                        if(DEBUG_ENABLED){
                                            let toast = $("#status-toast");
                                            $("#status-toast-content").html(result);
                                            toast.toast({ autohide: false });
                                            toast.toast("show");
                                        }
                                        if(result==="done"){
                                            $(taskItemBox).slideUp(400, function(){
                                                redirectPage("dashboard.php");
                                            });
                                        }

                                    },
                    
                                    failure: function(){
                                        $("#page-load").fadeOut(100);
                                        return;
                                    }
                                });
                            }


                    })

                });

    
            });
    });


});


