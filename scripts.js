$(document).ready(function(){

    // like and unlike click
    $(".like, .unlike").click(function(){
        var id = this.id;   // Getting Button id
        var split_id = id.split("_");

        var text = split_id[0];
        var thread_id = split_id[1];  // thread_id

        // Finding click type
        var type = 0;
        if(text == "like"){
            type = 1;
        }else{
            type = 0;
        }

        // AJAX Request
        $.ajax({
            url: 'vote.php',
            type: 'post',
            data: {thread_id:thread_id,type:type},
            dataType: 'json',
            success: function(data){
                var likes = data['likes'];
                var unlikes = data['unlikes'];

                $("#likes_"+thread_id).text(likes);        // setting likes
                $("#unlikes_"+thread_id).text(unlikes);    // setting unlikes

                if(type == 1){
                    $("#like_"+thread_id).css("color","#ffa449");
                    $("#unlike_"+thread_id).css("color","lightseagreen");
                }

                if(type == 0){
                    $("#unlike_"+thread_id).css("color","#ffa449");
                    $("#like_"+thread_id).css("color","lightseagreen");
                }

            }
        });

    });

});