var modalHtml = "";
const DEBUG_ENABLED = true;




$(window).on('pageshow', function(){
    $(".group-manage").fadeOut(0);
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
    $(".group-item-box").on("click", function(){
        var teachingGroupId = $(this).attr("data-teachingGroup-id");
        var thisIdString = "#teachingGroupModal[data-teachingGroup-id='"+teachingGroupId+"'] ";
        let teachingGroupModal = $(thisIdString);
        teachingGroupModal.modal("show");

        $(thisIdString+".btn-manageGroups").off("click").on("click", function(){
            //--When group manage button is pressed--
            //Display add student by email field
            //Display cross icon next to entries
            $(thisIdString+".group-manage").fadeToggle(200);

            //Handle adding and removal of students
            studentsToAdd = [];
            studentsToRemove = [];

            //Handle adding students
            $(".btn-addStudentToGroup").off("click").on("click",function(){
                studentEmail = $(thisIdString+".group-studentBox").val();
                //Verify email
                if(studentEmail.length<4 || !studentEmail.includes("@")){
                    return;
                }

                //Make sure student is not already in studentsToAdd
                if(!studentsToAdd.includes(studentEmail)){
                    //If in studentsToRemove, just delete it from there
                    if(studentsToRemove.splice(studentEmail).length<1){
                        studentsToAdd.push(studentEmail);
                        $(".manage-group-list").append($("#group-list-item").html());
                        let newItem = null;
                        let groupItems = $(".manage-group-list").children();
                        groupItems.each(function( index ) {


                            let item = $(this).find(".group-item-student-name");
                            console.log(item.html());
                            if(item.html()==="Name"){
                                newIndex = index;
                                $(this).attr("data-temp-index", index);

                                newItem = item;
                            }
                        });
        
                        
                        $(newItem).html(studentEmail);
                        $(".btn-removeStudentFromGroup").off("click").on("click",function(){
                            item = $(this).parent();
                            studentEmail = item.find(".group-item-student-name").html();
                            studentId = item.attr("data-student-id");
                                //If in studentsToAdd, just delete it from there
                                if(studentsToAdd.splice(studentEmail).length<1){
                                    studentsToRemove.push(studentId);
                                }
                                item.remove();
                                
                            
                        });
                    }
                
                }
            });

            $(".btn-removeStudentFromGroup").off("click").on("click",function(){
                item = $(this).parent();
                studentEmail = item.find(".group-item-student-name").html();
                    //If in studentsToAdd, just delete it from there
                    if(studentsToAdd.splice(studentEmail).length<1){
                        studentsToRemove.push(studentEmail);
                    }
                    item.remove();
                    
                
            });


            $(thisIdString+".btn-sendForm").off("click").on("click",function(){
                //Handle AJAX request on finalize
                $.post("ajaxManageGroups.php", {"id": teachingGroupId, "studentsToAdd": studentsToAdd, "studentsToRemove": studentsToRemove})
                teachingGroupModal.modal("hide");
            })




           

        })

    });

    
    $("#btn-newGroupSave").on("click", function(){
        $.post("ajaxManageGroups.php", {"newGroup" : $("#newGroupName").val()});
        //redirectPage("dashboard.php")
    });



});


