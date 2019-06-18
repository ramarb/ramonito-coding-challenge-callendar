/**
 * Created by dgl on 6/18/19.
 */
var Route = {
    post:{
        [uri]:function(data, callback){
            //alert(uri)
            var post = data;
            post['_token'] = csrf_token;
            request('post','/' + uri, post, callback);
        }
    }
};

var request = function(method, uri, data, callback){
    $.ajax({
        'method': method,
        'url': uri,
        'data': data
    }).done(function(res){
        if(typeof res.error == 'undefined'){
            callback(res);
        }else{

            var html = '<ul>';
            $.each(res.error, function(index, value){
                html += '<li>' + value[0] + '</li>';
            });
            html += '</u>';

            alert.error(html, res.uniqid);
        }

    });
}

var post = function(form){
    var unindexed_array = form.serializeArray();

    console.log(unindexed_array);

    var indexed_array = {};

    $.map(unindexed_array, function(n, i){
        indexed_array[n['name']] = n['value'];
    });

    return indexed_array;
}

var alert = {
    success : function(message,uniqid){
        var html = '<div id="'+uniqid+'" style="z-index: 999999 !important" class="alert alert-success"><span>'+message+'</span></div>';

        this.append(html,uniqid);

    },
    error : function(message,uniqid){
        var html = '<div id="'+uniqid+'" style="z-index: 999999 !important" class="alert alert-danger">'+message+'<ul>';


        this.append(html,uniqid);

    },
    append : function(html,uniqid){

        $("#alert-section").append(html);

        setTimeout(function () {
            $("#" + uniqid).fadeTo( "slow" , 0.0, function() {
                $(this).remove();
            });
        },2000)
    }
};