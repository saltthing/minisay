<?php
/*
**************************************************************************
[uploadx for php 通用上传类]
程序版本：uploadx version 1.1
更新时间：2010-02-20
版权所有：思维网络 
官方网站：http://www.Samxy.com 
联系方式：Email:vip@Samxy.com
程序编写：陶之11 QQ:14779023
**************************************************************************

使用方法:

HTML表单页
-------------------------------------------------------------------------
<form enctype="multipart/form-data" action="upload.php" method="post"> 
	<input name="swfile" type="file"> 
	<input type="submit" value="上传"> 
</form> 
-------------------------------------------------------------------------


upload.php处理页
-------------------------------------------------------------------------
<?php
require_once './uploadx.php';
$upx = new uploadx();
$upx->uploadx_form = 'swfile';              //表单控件名称(表单上传控件的名称<input name="swfile" type="file" />)
$upx->uploadx_save = "temp";                //保存文件目录(上传文件保存目录可以是相对路径也可以是绝对路径) 
$upx->uploadx_type = 'jpg|gif|png|swf';    //允许上传类型(根据后缀限制上传类型,每个后缀用“|”隔开)  
$upx->uploadx_size = "1024";                //允许上传大小(单位是KB。例:1024=1024KB) 
$upx->uploadx_name = time();                //上传后文件名(可自定义。例:date("Y-m-d",time()))

if($upx->file()){
  echo "上传成功<br />";
  echo "名称->".$upx->file['name']."<br />";
  echo "路径->".$upx->file['path']."<br />";
  echo "大小->".$upx->file['size']."<br />";
  echo "类型->".$upx->file['type']."<br />";
  echo "时间->".$upx->file['time']."<br />";
  echo "结果->".$upx->file['info']."<br />";
  
}else{
  echo $upx->file['info'];
}



-------------------------------------------------------------------------
*/
class uploadx {

        
       public $uploadx_form; //表单控件名称
       public $uploadx_save; //保存文件目录
       public $uploadx_type; //允许上传类型
       public $uploadx_size; //允许上传大小
       public $uploadx_name; //上传后文件名
       
       function __construct(){//初始化函数
          $this->uploadx_form = 'attach';
          $this->uploadx_save = 'temp';
          $this->uploadx_type = 'jpg|gif|png|bmp|swf|flv|rar|7z|zip|doc|docx|ppt|pptx|xls|xlsx|txt|pdf|wav|mp3|wma|rm|rmvb|wmv';         
          $this->uploadx_size = '1024';
          $this->uploadx_info = false;
       }
       
      function mkdirs($path , $mode = 0777){
          $rootdir = '';
          if(substr($path,0,1)=='/') $rootdir = $_SERVER['DOCUMENT_ROOT'];          
          $path = $rootdir . $path;
          if(!is_dir($path)){
              $this->mkdirs(dirname($path),$mode);
              mkdir($path,$mode);
          }
          return true;
      }



     function file(){
              if(!isset($_FILES[$this->uploadx_form])){
                  $this->file = array('file'=>false,'info' => '上传错误!请检查表单上传控件名称['.$this->uploadx_form.']是否正确!');
                  return false;
              }
              
              switch($_FILES[$this->uploadx_form]['error']){
                 
                 case 1:
                  $this->file = array('file'=>false,'info' => '指定上传的文件大小超出服务器限制!');
                  return false;
                 break;  
                 
                 case 2:
                  $this->file = array('file'=>false,'info' => '指定上传的文件大小超出表单限制!');
                  return false;
                 break;  
                                             
                 case 3:
                  $this->file = array('file'=>false,'info' => '只有部份文件被上传,文件不完整!');
                  return false;
                 break;  
                                                      
                 case 4:
                  $this->file = array('file'=>false,'info' => '您没有选择上传任何文件!');
                  return false;
              }
              
              $postfix = pathinfo($_FILES[$this->uploadx_form]['name'], PATHINFO_EXTENSION);  
              if(stripos($this->uploadx_type,$postfix)===false){
                $this->file = array('file'=>false,'info' => '指定上传的文件类型超出限制,允许上传文件类型：'.$this->uploadx_type);
                return false;
                
              }
          
              if(round($_FILES[$this->uploadx_form]['size']/1024)>$this->uploadx_size){
                $this->file = array('file'=>false,'info' => '指定上传的文件超出大小限制,文件上传限制范围：'.$this->uploadx_size.'kb');
                return false;  
              }                
            
              if($this->mkdirs($this->uploadx_save)){              
                $this->uploadx_name = isset($this->uploadx_name) ? $this->uploadx_name.'.'.$postfix : $_FILES[$this->uploadx_form]['name'];
                if(!@move_uploaded_file($_FILES[$this->uploadx_form]['tmp_name'],$this->uploadx_save.'/'.$this->uploadx_name)){
                  $this->file = array('file'=>false,'info' => '上传文件保存过程中出现错误,请检查路径或目录权限.');
                  return false;
                }
              }else{
                 $this->file = array('file'=>false,'info' => '服务器目录不存在,自动创建目录失败,请检查是否有权限!');
                  return false;
              }                 
              
              @chmod($this->uploadx_save.'/'.$this->uploadx_name,0777);  		
              $this->file = array(
                    'file' => true,
                    'name' => $this->uploadx_name,
                    'path' => $this->uploadx_save.'/'.$this->uploadx_name,
                    'size' => $_FILES[$this->uploadx_form]['size'],
                    'type' => $postfix,
                    'time' => time(),
                    'info' => '上传成功!'
              );                
              return true;
                         
     }


}