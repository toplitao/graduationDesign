/**
 * Created by ssl on 2017/3/22.
 */
function ajaxSendData(FormId,url){
    var data = $("#"+FormId).serializeArray();
    var postData = {};
    $(data).each(function(i){
        postData[this.name] = this.value;
    })
    $.post(url,postData,function(result){
        if(result.status == 200){
            return dialog.success(result.msg,result.data.url);
        }
        if(result.status == 300){
            return dialog.error(result.msg);
        }
    },'json');
}