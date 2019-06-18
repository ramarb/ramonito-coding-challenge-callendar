/**
 * Created by dgl on 6/18/19.
 */

var csrf_token = $("#csrf_token").val();

$(document).ready(function(){
    //Route.get.calendar({'name':'ramonito'});


    $('#event-form').on('submit',function(e){
        e.preventDefault();

        Route.post.calendar(post($(this)), function(arg){


            $(".event-tr").removeClass('table-success');
            $('td.event').html("");

            $.each(arg.events,function(index, value){

                $("#"+value).addClass('table-success');
                $("#"+value).children('td.event').html(arg.event);
            })

            alert.success('Event Successfull Saved',arg.uniqid);

        });

    });

});

