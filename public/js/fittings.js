/*配件管理页面点击新增按钮开始*/
$("#add_fitting").click(function(){
	var url = SCOPE.ajax_add_fittings;
	window.location.href = url;
})
/*配件管理页面点击新增按钮结束*/

/*新增配件页面点击确定开始*/
$("#do_add_fitting").click(function(){
	var url = SCOPE.ajax_add_fittings;
	var data = $("#fittingsAdd").serializeArray();
	var postData = {};
	$(data).each(function(i){
		postData[this.name] = this.value;
	});
	$.post(url,postData,function(result){
		 if(result.status == 1)
		 {
		 	return dialog.success(result.msg,result.url);
		 }
		 if(result.status == 2)
		 {
		 	return dialog.error(result.msg);
		 }
	},"JSON");
})
/*新增配件页面点击确定结束*/

/*ajax删除配件开始*/
$(".del_fitting").click(function(){
	var url = SCOPE.ajax_del_fittings;
	var id = $(this).attr('del_id');
	var postData = {'id':id};
	$.post(url,postData,function(result){
		 if(result.status == 1)
		 {
		 	return dialog.success(result.msg,result.url);
		 }
		 if(result.status == 2)
		 {
		 	return dialog.error(result.msg);
		 }
	},'json');
})
/*ajax删除配件结束*/

/*配管管理页面点击编辑开始*/
$(".edit_fitting").click(function(){
	var id = $(this).attr('edit_id');
	var url = SCOPE.ajax_edit_fittings+'/id/'+id;
	window.location.href = url;
	
})
/*配管管理页面点击编辑结束*/

/*确认配件编辑操作开始*/
$(".do_edit_fitting").on('click',function(){
	var url = SCOPE.ajax_edit_fittings;
	var data = $("#fittingsEdit").serializeArray();
	var postData = {};
	$(data).each(function(i){
		postData[this.name] = this.value;
	})
	$.post(url,postData,function(result){
		 if(result.status == 1)
		 {
		 	return dialog.success(result.msg,result.url);
		 }
		 if(result.status == 2)
		 {
		 	return dialog.error(result.msg);
		 }
	},'JSON');
})

/*确认配件编辑操作结束*/