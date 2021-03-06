<?php
class article {
    public $server = '';
    public $user   = '';
    public $password = '';
    public $db = '';
    private $table;
    /**
     * 初始化
     */  
    public function __construct($prefix) {
        $this->table = $prefix.'article';
    }
    /**
     * 配置mysql连接信息
     */  
    public function config($server,$user,$password,$db) {
        $this->server = $server;
        $this->user = $user;
        $this->password = $password;
        $this->db = $db;
    }
    /**
     * 连接mysql,选择数据库
     */ 
    public function connect() {
        if(mysql_connect($this->server,$this->user,$this->password)) {
            if(mysql_select_db($this->db)) {
                mysql_query("set names utf8;");
				mysql_query("set time_zone = '+8:00';");
                return true;
            }else {
                return false;
            }
        }else {
            return false;
        }
    }
    /**
     * 插入新记录
     */
    public function add($content) {
        $sql = "insert into ".$this->table." values (null,'".$content."',now(),now())";
        if(mysql_query($sql)) {
            return true;
        }else {
            return false;
        }
    }
    /**
     * 获取记录总数
     */
    public function count() {
        $sql = "select count(gid) as num from ".$this->table;
        if($result = mysql_query($sql)) {
            $row = mysql_fetch_array($result);
            return $row['num'];
        }
    }
    /**
     * 获取分页内容
     */ 
    public function getByPage($each,$page) {
        $begin = $each*($page-1);
        $sql = "select * from ".$this->table." order by gid desc limit $begin,$each";
        if($result = mysql_query($sql)) {
            while ($row = mysql_fetch_array($result)) {
                $array[] = $row;
            }  
            return @$array;          
        }
    }
    /**
     * 删除内容
     */
    public function delete($gid) {
        $sql = "delete from ".$this->table." where gid=".$gid;
        if(mysql_query($sql)) {
            return true;
        }else {
            return false;
        }
    }
    /**
     * 通过id获取内容
     */
    public function getById($gid) {
        $sql = "select * from ".$this->table." where gid = '".$gid."'";
        if($result = mysql_query($sql)) {
            $row = mysql_fetch_array($result);
            return $row;                      
        }
    }
    /**
     * 修改单条记录内容
     */
    public function updateById($gid,$content) {
        $sql = "update ".$this->table." set content='".$content."' where gid=".$gid;
        if(mysql_query($sql)) {
            return true;
        }else {
            return false;
        }
    }
    /**
     * 多关键字搜索结果总数
     */
    public function searchCount($key) {
        $array = explode(' ',$key);
        $sql = "select count(*) as num from ".$this->table." where ";
		$str = '';
        for($num = 0;$num<count($array);$num++) {
            if($num == count($array)-1){
                $str = $str."content like '%".$array[$num]."%'";
            }else {
                $str = $str."content like '%".$array[$num]."%' or ";
            }      
        }
        $sql = $sql.'('.$str.") order by gid desc";
        if($result = mysql_query($sql)) {
            $row = mysql_fetch_array($result);
            return $row['num'];
        }
    }
    /**
     * 多关键字搜索结果
     */
    public function search($key,$each,$page) {
        $begin = $each*($page-1);
        $array = explode(' ',$key);
        $sql = "select * from ".$this->table." where ";
		$str = '';
        for($num = 0;$num<count($array);$num++) {
            if($num == count($array)-1){
                $str = $str."content like '%".$array[$num]."%'";
            }else {
                $str = $str."content like '%".$array[$num]."%' or ";
            }      
        }
        $sql = $sql.'('.$str.") order by gid desc limit $begin,$each";
        if($result = mysql_query($sql)) {
            while ($row = mysql_fetch_array($result)) {
                $search[] = $row;
            }  
            return @$search;          
        }
    }
}
?>
