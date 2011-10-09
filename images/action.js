//标签插入
function funcInsertTag(topen,tclose,id){
    var themess = document.getElementById(id);//编辑对象:修改textarea:ID
    themess.focus();
    if (document.selection) {//如果是否ie浏览器
       var theSelection = document.selection.createRange().text;//获取选区文字
       //alert(theSelection);
       if(theSelection){
    		document.selection.createRange().text = theSelection = topen+theSelection+tclose;//替换
       }else{
    		document.selection.createRange().text = topen+tclose;
       }
       theSelection='';
    
    }else{//其他浏览器
    
       var scrollPos = themess.scrollTop;
       var selLength = themess.textLength;
       var selStart = themess.selectionStart;//选区起始点索引，未选择为0
       var selEnd = themess.selectionEnd;//选区终点点索引
       if (selEnd <= 2)
       selEnd = selLength;
    
       var s1 = (themess.value).substring(0,selStart);//截取起始点前部分字符
       var s2 = (themess.value).substring(selStart, selEnd)//截取选择部分字符
       var s3 = (themess.value).substring(selEnd, selLength);//截取终点后部分字符
    
       themess.value = s1 + topen + s2 + tclose + s3;//替换
    
       themess.focus();
       themess.selectionStart = newStart;
       themess.selectionEnd = newStart;
       themess.scrollTop = scrollPos;
       return;
    }
}
//获取页面宽度和高度
function getBodySize(){
	var bodySize = [];
	with(document.documentElement) {
		//如果滚动条的宽度大于页面的宽度，取得滚动条的宽度，否则取页面宽度
		bodySize[0] = (scrollWidth>clientWidth)?scrollWidth:clientWidth;
		//如果滚动条的高度大于页面的高度，取得滚动条的高度，否则取高度
		bodySize[1] = (scrollHeight>clientHeight)?scrollHeight:clientHeight;
	}
	return bodySize;
}
//弹出窗口
function funcPopWind(width,height,str) {
    //获取覆盖层宽,高
	var bgWidth = getBodySize()[0];
	var bgHeight = getBodySize()[1];
    //var bgHeight = $(document).height();
    //var bgWidth = $(document).width();
    //覆盖层样式
    strBg =
    '<div id="sysIdPopBg" style="height:'+bgHeight+'px;width:'+bgWidth+'px;'
    +'background:black;position:absolute;top:0;left:0;z-index:50;display:block;'
    +'filter:alpha(opacity=10);opacity:0.1;"></div>';

    $("body").append(strBg);

    var winHeight = $(window).height();//浏览器窗口高
    if ($.browser.msie && $.browser.version <7.0) position='absolute';else position='fixed';//IE6不支持absolute
    //弹出窗口样式
    strWind =
    '<div id="sysIdPopWind" style="height:'+height+'px;width:'+width+'px;'
    +'position:'+position+';z-index:100;'
    +'top:'+(winHeight/2)+'px;left:50%;margin-left:'+(-width/2)+'px;margin-top:'+(-height/2-20)+'px;">'

    +'<div style="height:'+height+'px;width:'+width+'px;position:absolute;'
    +'background:black;filter:alpha(opacity=20);opacity:0.2;top:0;left:0;"></div>'

    +'<div style="height:'+(height-16)+'px;width:'+(width-16)+'px;'
    +'top:7px;left:7px;background:#F1F1F1;position:absolute;'
    +'border:1px solid gray;overflow:hidden;">'+str+'</div>'

    +'</div>';

    $("body").append(strWind);
}
//关闭窗口
function funcCloseWind() {
    $("#sysIdPopWind").remove();
    $("#sysIdPopBg").remove();
}
//窗口标题
function funcTitleWind(title) {
    //关闭按钮字符串引入
    var strClose = '<a href="javascript:funcCloseWind()" class="sysClose">关闭</a>';
    var strTitle = '<div class="sysTitle">'+title+'</div>';
    return strClose+strTitle;
}
//加载窗口
function funcPopLoading() {
	funcPopTip("Loading...");
}
//提示窗口
function funcPopTip(str) {
    funcPopWind(200,80,'<div class="sysTip">'+str+'</div>');
}







/**
 * 以上为弹出窗口的基本函数
 * 以下为各种操作函数
 */






//图片预加载
$(function() {
    loadImage1 = new Image();
    loadImage1.src = "images/close.gif";
    loadImage2 = new Image();
    loadImage2.src = "images/title.gif";
    loadImage3 = new Image();
    loadImage3.src = "images/btn.png";
    loadImage4 = new Image();
    loadImage4.src = "images/tool.png";
});

//文章搜索
function funcSearch() {
    $(function(){
        var key = $("#sysIdSearch").val();
        location.href="index.php?key="+encodeURIComponent(key);
    });
}
//文章搜索回车提交
$(function() {
    $("#sysIdSearch").live('keydown',function(e){
        var e = e || window.event;
        if(e.keyCode==13){
            var key = $("#sysIdSearch").val();
            location.href="index.php?key="+encodeURIComponent(key);
        }
    });
});

//登录
function funcLogin() {
    $(function(){
        var str = funcTitleWind('用户登录')
        +'<div class="sysLoginItem">'
            +'<span>用户名:</span>'
            +'<input id="sysIdLoginUn" type="text" />'
        +'</div>'
        +'<div class="sysLoginItem">'
            +'<span>密&nbsp;&nbsp;码:</span>'
            +'<input id="sysIdLoginPw" type="password" />'
        +'</div>'
        +'<div class="sysSubmit">'
            +'<a class="sysSubmit_a" id="sysIdLoginSubmit" href="javascript:funcLoginSubmit()">登录</a>'
        +'</div>';
        funcPopWind(300,153,str);
        $("#sysIdLoginUn").focus();
    });
}
//登录回车提交
$(function() {
    $("#sysIdLoginUn").live('keydown',function(e){
        var e = e || window.event;
        if(e.keyCode==13){
            $("#sysIdLoginSubmit").focus();
            if($.browser.msie) $("#sysIdLoginSubmit").onclick;
            else funcLoginSubmit();
        }
    });
    $("#sysIdLoginPw").live('keydown',function(e){
        var e = e || window.event;
        if(e.keyCode==13){
            $("#sysIdLoginSubmit").focus();
            if($.browser.msie) $("#sysIdLoginSubmit").onclick;
            else funcLoginSubmit();
        }
    });
});
//登录提交
function funcLoginSubmit() {
    $(function() {
        var loginUn = $("#sysIdLoginUn").val();
        var loginPw = $("#sysIdLoginPw").val();
        if(loginUn=='' || loginUn==null || loginPw=='' || loginPw==null) {
            funcCloseWind();
            funcPopTip('用户名，密码不能为空');
            setTimeout(function(){funcCloseWind();},1500);
        }else {
            $.ajax({
                type: "POST",
                url: "action.php?act=login",
                data: "loginUn="+encodeURIComponent(loginUn)+'&loginPw='+encodeURIComponent(loginPw),
                success: function(data){
                    var result = $(data).filter("span#sysRe").text();
                    if(result == 'loginSuccess') {
                        $.get(location.href,{'temp':Math.random()},function(data){
                            $("#sysIdContain").replaceWith($(data).filter("div#sysIdContain"));
                            funcCloseWind();
                            funcPopTip('登录成功');
                            setTimeout(function(){funcCloseWind();},1500);
                        });
                    }else {
                        funcCloseWind();
                        funcPopTip('登录失败');
                        setTimeout(function(){funcCloseWind();},1500);
                    }
                },
                beforeSend:function(data){
                    funcCloseWind();
                    funcPopLoading();
                }
            });
        }
    });
}
//退出
function funcLogout() {
    $(function() {
        $.ajax({
            type: "GET",
            url: "action.php?act=logout",
            success: function(data){
                var result = $(data).filter("span#sysRe").text();
                if(result == 'logoutSuccess') {
                    $.get(location.href,{'temp':Math.random()},function(data){
                        $("#sysIdContain").replaceWith($(data).filter("div#sysIdContain"));
                        funcCloseWind();
                        funcPopTip('退出成功');
                        setTimeout(function(){funcCloseWind();},1500);
                    });
                }else {
                    funcCloseWind();
                    funcPopTip('退出失败');
                    setTimeout(function(){funcCloseWind();},1500);
                }
            },
            beforeSend:function(data){
                funcPopLoading();
            }
        });
    });
}

//留言
function funcMessage() {
    $(function() {
        str = funcTitleWind('给我留言')
        +'<div class="sysMessageP1">'
            +'<span class="sysMessageP1Span1">* 昵称:</span>'
            +'<input id="sysIdMePoster" type="text" />'
            +'<span class="sysMessageP1Span2">* 留言内容:</span>'
        +'</div>'
        +'<div class="sysMessageP2">'
            +'<textarea id="sysIdMeContent"></textarea>'
        +'</div>'
        +'<div class="sysSubmit">'
            +'<a class="sysSubmit_a" href="javascript:funcMessageSubmit()">留言</a>'
        +'</div>';
        funcPopWind(400,238,str);
        $("#sysIdMePoster").focus();
    });
}
//留言提交
function funcMessageSubmit() {
    $(function() {
        var mePoster = $.trim($("#sysIdMePoster").val());
        var meContent = $.trim($("#sysIdMeContent").val());
        if(mePoster=='' || mePoster==null || meContent=='' || meContent==null) {
            funcCloseWind();
            funcPopTip('昵称，内容不能为空');
            setTimeout(function(){funcCloseWind();},1500);
        }else {
            $.ajax({
                type: "POST",
                url: "action.php?act=message",
                data: "mePoster="+encodeURIComponent(mePoster)+'&meContent='+encodeURIComponent(meContent),
                success: function(data){
                    var result = $(data).filter("span#sysRe").text();
                    if(result == 'messageSuccess') {
                        $.get(location.href,{'temp':Math.random()},function(data){
                            $("#sysIdContain").replaceWith($(data).filter("div#sysIdContain"));
                            funcCloseWind();
                            funcPopTip('留言成功');
                            setTimeout(function(){funcCloseWind();},1500);
                        });
                    }else {
                        funcCloseWind();
                        funcPopTip('留言失败');
                        setTimeout(function(){funcCloseWind();},1500);
                    }
                },
                beforeSend:function(data){
                    funcCloseWind();
                    funcPopLoading();
                }
            });
        }
    });
}
//留言回复
function funcReply(mid) {
    $(function() {
        $.ajax({
            type: "GET",
            url: "action.php?act=replyGet&mid="+mid,
            success: function(data){
                var result = decodeURIComponent($(data).filter("span#sysRe").text());
                funcCloseWind();
                str = funcTitleWind('留言回复')
                    +'<div class="sysMessageP2">'
                        +'<textarea id="sysIdReContent">'+result+'</textarea>'
                    +'</div>'
                    +'<div class="sysSubmit">'
                        +'<a class="sysSubmit_a" href="javascript:funcReplySubmit('+mid+')">回复</a>'
                    +'</div>';
                funcPopWind(400,209,str);
                $("#sysIdReContent").focus();
            },
            beforeSend:function(data){
                funcCloseWind();
                funcPopLoading();
            }
        });
    });
}
//回复提交
function funcReplySubmit(mid) {
    $(function() {
        var reContent = $.trim($("#sysIdReContent").val());
        if(reContent=='' || reContent==null) {
            funcCloseWind();
            funcPopTip('内容不能为空');
            setTimeout(function(){funcCloseWind();},1500);
        }else {
            $.ajax({
                type: "POST",
                url: "action.php?act=reply",
                data: "mid="+mid+"&reContent="+encodeURIComponent(reContent),
                success: function(data){
                    var result = $(data).filter("span#sysRe").text();
                    if(result == 'replySuccess') {
                        $.get(location.href,{'temp':Math.random()},function(data){
                            $("#sysIdContain").replaceWith($(data).filter("div#sysIdContain"));
                            funcCloseWind();
                            funcPopTip('回复成功');
                            setTimeout(function(){funcCloseWind();},1500);
                        });
                    }else {
                        funcCloseWind();
                        funcPopTip('回复失败');;
                        setTimeout(function(){funcCloseWind();},1500);
                    }
                },
                beforeSend:function(data){
                    funcCloseWind();
                    funcPopLoading();
                }
            });
        }
    });
}
//留言删除
function funcMessageDel(mid) {
    $(function() {
        $.ajax({
            type: "GET",
            url: "action.php?act=messageDel&mid="+mid,
            success: function(data){
                var result = $(data).filter("span#sysRe").text();
                if(result == 'messageDelSuccess') {
                    $.get(location.href,{'temp':Math.random()},function(data){
                        $("#sysIdContain").replaceWith($(data).filter("div#sysIdContain"));
                        funcCloseWind();
                        funcPopTip('删除成功');
                        setTimeout(function(){funcCloseWind();},1500);
                    });
                }else {
                    funcCloseWind();
                    funcPopTip('删除失败');
                    setTimeout(function(){funcCloseWind();},1500);
                }
            },
            beforeSend:function(data){
                funcCloseWind();
                funcPopLoading();
            }
        });
    });
}

//编辑器样式
function funcEditStyle(content) {
    var id = 'sysIdEditContent';
    str = ''
    +'<div class="sysEdit">'
        +'<div class="sysEditTool">'
            //加粗
            +'<a href="javascript:funcInsertTag('+"'[B]',"+"'[/B]','"+id+"'"+')" '
                +'onclick="javascript:void(0)" '
                +'class="tool_b" title="字体加粗">加粗</a>'  
            //倾斜
            +'<a href="javascript:funcInsertTag('+"'[I]',"+"'[/I]','"+id+"'"+')" '
                +'onclick="javascript:void(0)" '
                +'class="tool_i" title="字体倾斜">倾斜</a>'
            //下划线
            +'<a href="javascript:funcInsertTag('+"'[U]',"+"'[/U]','"+id+"'"+')" '
                +'onclick="javascript:void(0)" '
                +'class="tool_u" title="添加下划线">下划线</a>'
            //字体大小
            +'<a href="javascript:funcInsertTag('+"'[SIZE=12px]',"+"'[/SIZE]','"+id+"'"+')" '
                +'onclick="javascript:void(0)" '
                +'class="tool_size" title="字体大小">大小</a>' 
            //字体
            +'<a href="javascript:funcInsertTag('+"'[FONT=宋体]',"+"'[/FONT]','"+id+"'"+')" '
                +'onclick="javascript:void(0)" '
                +'class="tool_font" title="字体">字体</a>'
            //引用
            +'<a href="javascript:funcInsertTag('+"'[QUOTE]',"+"'[/QUOTE]','"+id+"'"+')" '
                +'onclick="javascript:void(0)" '
                +'class="tool_quote" title="引用">引用</a>' 
            //简单链接
            +'<a href="javascript:funcInsertTag('+"'[URL]url',"+"'[/URL]','"+id+"'"+')" '
                +'onclick="javascript:void(0)" '
                +'class="tool_link" title="简单链接">简单链接</a>'
            //完整链接
            +'<a href="javascript:funcInsertTag('+"'[URL=url]linkName',"+"'[/URL]','"+id+"'"+')" '
                +'onclick="javascript:void(0)" '
                +'class="tool_link" title="完整链接">完整链接</a>'  
            //红色
            +'<a href="javascript:funcInsertTag('+"'[RED]',"+"'[/RED]','"+id+"'"+')" '
                +'onclick="javascript:void(0)" '
                +'class="tool_red" title="红色">红色</a>'  
            //绿色
            +'<a href="javascript:funcInsertTag('+"'[GREEN]',"+"'[/GREEN]','"+id+"'"+')" '
                +'onclick="javascript:void(0)" '
                +'class="tool_green" title="绿色">绿色</a>'  
            //蓝色
            +'<a href="javascript:funcInsertTag('+"'[BLUE]',"+"'[/BLUE]','"+id+"'"+')" '
                +'onclick="javascript:void(0)" '
                +'class="tool_blue" title="蓝色">蓝色</a>'   
            //颜色
            +'<a href="javascript:funcInsertTag('+"'[COLOR=#00000]',"+"'[/COLOR]','"+id+"'"+')" '
                +'onclick="javascript:void(0)" '
                +'class="tool_color" title="自定义颜色">颜色</a>'   
            //居中
            +'<a href="javascript:funcInsertTag('+"'[CENTER]',"+"'[/CENTER]','"+id+"'"+')" '
                +'onclick="javascript:void(0)" '
                +'class="tool_center" title="内容居中">居中</a>'  
            //居右
            +'<a href="javascript:funcInsertTag('+"'[RIGHT]',"+"'[/RIGHT]','"+id+"'"+')" '
                +'onclick="javascript:void(0)" '
                +'class="tool_right" title="内容居右">居右</a>'   
            //插入图片
            +'<a href="javascript:funcInsertTag('+"'[IMG]url',"+"'[/IMG]','"+id+"'"+')" '
                +'onclick="javascript:void(0)" '
                +'class="tool_img" title="插入图片">图片</a>'
            //插入Flash
            +'<a href="javascript:funcInsertTag('+"'[FLASH=400,300]url',"+"'[/FLASH]','"+id+"'"+')" '
                +'onclick="javascript:void(0)" '
                +'class="tool_flash" title="插入Flash">Flash</a>' 
            //插入标签
            +'<a href="javascript:funcInsertTag('+"'[TAG]',"+"'[/TAG]','"+id+"'"+')" '
                +'onclick="javascript:void(0)" '
                +'class="tool_tag" title="插入标签">标签</a>' 
			//文件上传
            +'<a href="javascript:void(0)" title="文件上传" class="tool_upload" style="text-indent: 0;">'
				+'<form id="sysIdUpload" action="action.php?act=fileUpload" encType="multipart/form-data"  method="post" target="hidden_frame">'
				+'<input name="uploadFile" id="sysIdUploadFile" type="file" onchange="funcUpload();" /></form>'
                +'<iframe name="hidden_frame" style="display:none;"></iframe></a>'
        +'</div>'
        +'<div class="sysEditText">'
            +'<textarea id="sysIdEditContent">'+content+'</textarea>'
        +'</div>'
    +'</div>';
    return str;
}
//文件上传
function funcUpload() {
    var str1 = document.getElementById('sysIdUploadFile').value;
    var str2 = str1.split('\\');
    var str = '本地文件：'+str2[str2.length-1]
             +'&nbsp;&nbsp;<a href="javascript:funcUploadSubmit()">上传</a>'
             +'&nbsp;&nbsp;<a href="javascript:funcUploadRemove()">取消</a>';
    document.getElementById('sysIdUploadInfo').innerHTML = str;
}
//文件上传提交
function funcUploadSubmit() {
    var str1 = document.getElementById('sysIdUploadFile').value;
    var str2 = str1.split('\\');
    var str = '本地文件：'+str2[str2.length-1]+'&nbsp;&nbsp;文件正在上传...';
    document.getElementById('sysIdUploadInfo').innerHTML = str;
    document.getElementById('sysIdUpload').submit();
}
//取消文件上传
function funcUploadRemove() {
    document.getElementById('sysIdUploadInfo').innerHTML = '支持上传的文件格式：jpg，gif，png，zip，rar';
	var str = '<input name="uploadFile" id="sysIdUploadFile" type="file" onchange="funcUpload();" />';
	document.getElementById('sysIdUpload').innerHTML = str;
}
//显示上传成功
function funcUploadSuccess(meg) {
	document.getElementById('sysIdUploadInfo').innerHTML = '文件上传成功!';
    setTimeout(function(){
		document.getElementById('sysIdUploadInfo').innerHTML = meg;
	},1000);
	var str = '<input name="uploadFile" id="sysIdUploadFile" type="file" onchange="funcUpload();" />';
	document.getElementById('sysIdUpload').innerHTML = str;
}
//显示上传失败
function funcUploadFailed() {
    document.getElementById('sysIdUploadInfo').innerHTML = '文件上传失败!';
    setTimeout(function(){
		document.getElementById('sysIdUploadInfo').innerHTML = '支持上传的文件格式：jpg，gif，png，zip，rar';
	},1500);
	var str = '<input name="uploadFile" id="sysIdUploadFile" type="file" onchange="funcUpload();" />';
	document.getElementById('sysIdUpload').innerHTML = str;
}
//上传文件删除
function funcFileDel(fileDir) {
    $(function() {
        $.ajax({
            type: "GET",
            url: "action.php?act=fileDel&fileDir="+fileDir,
            success: function(data){
                var result = $(data).filter("span#sysRe").text();
                if(result == 'fileDelSuccess') {
                    $.get(location.href,{'temp':Math.random()},function(data){
                        document.getElementById('sysIdUploadInfo').innerHTML = '文件删除成功!';
                        setTimeout(function(){
							document.getElementById('sysIdUploadInfo').innerHTML = '支持上传的文件格式：jpg，gif，png，zip，rar';
						},1500);
                    });
                }
            },
			beforeSend:function(data){
				var str = '文件路径：'+fileDir+'&nbsp;&nbsp;文件正在删除...';
				document.getElementById('sysIdUploadInfo').innerHTML = str;
            }
        });
    });
}
//文章编辑
function funcEdit(gid) {
    $(function() {
        $.ajax({
            type: "GET",
            url: "action.php?act=editGet&gid="+gid,
            success: function(data){
                var result = decodeURIComponent($(data).filter("span#sysRe").text());
                funcCloseWind();
                str = funcTitleWind('修改内容')+funcEditStyle(result)
                +'<div class="sysSubmit">'
                    +'<div class="sysUploadInfo" id="sysIdUploadInfo">支持上传的文件格式：jpg，gif，png，zip，rar</div>'
                    +'<a class="sysSubmit_a" href="javascript:funcEditSubmit('+gid+')">修改</a>'
                +'</div>';
                funcPopWind(600,300,str);
                $("#sysIdEditContent").focus();
            },
            beforeSend:function(data){
                funcCloseWind();
                funcPopLoading();
            }
        });
    });
}
//文章编辑提交
function funcEditSubmit(gid) {
    $(function() {
        var editContent = $("#sysIdEditContent").val();
        if(editContent=='' || editContent==null) {
            funcCloseWind();
            funcPopTip('内容不能为空');
            setTimeout(function(){funcCloseWind();},1500);
        }else {
            $.ajax({
                type: "POST",
                url: "action.php?act=edit",
                data: "gid="+gid+"&editContent="+encodeURIComponent(editContent),
                success: function(data){
                    var result = $(data).filter("span#sysRe").text();
                    if(result == 'editSuccess') {
                        $.get(location.href,{'temp':Math.random()},function(data){
                            $("#sysIdContain").replaceWith($(data).filter("div#sysIdContain"));
                            funcCloseWind();
                            funcPopTip('修改成功');
                            setTimeout(function(){funcCloseWind();},1500);
                        });
                    }else {
                        funcCloseWind();
                        funcPopTip('修改失败');;
                        setTimeout(function(){funcCloseWind();},1500);
                    }
                },
                beforeSend:function(data){
                    funcCloseWind();
                    funcPopLoading();
                }
            });
        }
    });
}
//文章删除
function funcDel(gid) {
    $(function() {
        $.ajax({
            type: "GET",
            url: "action.php?act=delete&gid="+gid,
            success: function(data){
                var result = $(data).filter("span#sysRe").text();
                if(result == 'deleteSuccess') {
                    $.get(location.href,{'temp':Math.random()},function(data){
                        $("#sysIdContain").replaceWith($(data).filter("div#sysIdContain"));
                        funcCloseWind();
                        funcPopTip('删除成功');
                        setTimeout(function(){funcCloseWind();},1500);
                    });
                }else {
                    funcCloseWind();
                    funcPopTip('删除失败');
                    setTimeout(function(){funcCloseWind();},1500);
                }
            },
            beforeSend:function(data){
                funcCloseWind();
                funcPopLoading();
            }
        });
    });
}

//发布内容
function funcNew() {
    $(function() {
        str = funcTitleWind('发布内容')+funcEditStyle('')
        +'<div class="sysSubmit">'
            +'<div class="sysUploadInfo" id="sysIdUploadInfo">支持上传的文件格式：jpg，gif，png，zip，rar</div>'
            +'<a class="sysSubmit_a" href="javascript:funcNewSubmit()">发布</a>'
        +'</div>';
        funcPopWind(600,302,str);
        $("#sysIdEditContent").focus();
    });
}
//发布内容提交
function funcNewSubmit() {
    $(function() {
        var newContent = $("#sysIdEditContent").val();
        if(newContent=='' || newContent==null) {
            funcCloseWind();
            funcPopTip('内容不能为空');
            setTimeout(function(){funcCloseWind();},1500);
        }else {
            $.ajax({
                type: "POST",
                url: "action.php?act=new",
                data: "newContent="+encodeURIComponent(newContent),
                success: function(data){
                    var result = $(data).filter("span#sysRe").text();
                    if(result == 'newSuccess') {
                        $.get(location.href,{'temp':Math.random()},function(data){
                            $("#sysIdContain").replaceWith($(data).filter("div#sysIdContain"));
                            funcCloseWind();
                            funcPopTip('发布成功');
                            setTimeout(function(){funcCloseWind();},1500);
                        });
                    }else {
                        funcCloseWind();
                        funcPopTip('发布失败');
                        setTimeout(function(){funcCloseWind();},1500);
                    }
                },
                beforeSend:function(data){
                    funcCloseWind();
                    funcPopLoading();
                }
            });
        }
    });
}