<?php
class message {
    public $server = 'localhost';
    public $user   = 'root';
    public $password = '';
    public $db = '';
    private $table;
    /**
     * 初始化
     */  
    public function __construct($prefix) {
        $this->table = $prefix.'message';
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
     * 获取记录总数
     */
    public function count() {
        $sql = "select count(mid) as num from ".$this->table;
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
        $sql = "select * from ".$this->table." order by mid desc limit $begin,$each";
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
    public function delete($mid) {
        $sql = "delete from ".$this->table." where mid=".$mid;
        if(mysql_query($sql)) {
            return true;
        }else {
            return false;
        }
    }
    /**
     * 通过id获取内容
     */
    public function getById($mid) {
        $sql = "select * from ".$this->table." where mid = '".$mid."'";
        if($result = mysql_query($sql)) {
            $row = mysql_fetch_array($result);
            return $row;                      
        }
    }
    /**
     * 回复
     */
    public function updateById($mid,$reply) {
        $sql = "update ".$this->table." set reply='".$reply."' where mid=".$mid;
        if(mysql_query($sql)) {
            return true;
        }else {
            return false;
        }
    }
    /**
     * 插入留言
     */
    public function add($poster,$message) {
        $sql = "insert into ".$this->table." values (null,'$poster','$message',null,now(),now())";
        if(mysql_query($sql)) {
            return true;
        }else {
            return false;
        }
    }
}
?>