<?php
class DBTool{
  const HOST="dbhost";
  const USER="user";
  const PASS="password";
  const DATABASE="database";

  private static $mysqli= NULL;
  static function getMysqli(){
    if (self::$mysqli==NULL){
      self::$mysqli=new mysqli(self::HOST,self::USER,self::PASS,self::DATABASE);
    }
    return self::$mysqli;
  }

  /**@Deprecated**/
  private static $instance = NULL;
  static function getInstance(){
    if (self::$instance==NULL){
      self::$instance=new DBTool();
    }
    return self::$instance;
  }

  private $conn=null;

  private function __construct(){
    $this->connect();
    $this->useDB(self::DATABASE);
  }
  private function __destruct(){
    mysql_close($this->conn);
    $instance=NULL;
  }
  private function __clone(){}
  
  public function connect(){
    $this->conn=mysql_connect(self::HOST,self::USER,self::PASS);
  }

  public function close(){
    mysql_close($this->conn);
    $instance=NULL;
  }

  public function useDB($db){
    $sql='use '.$db;
    $this->query($sql);
  }

  public function query($sql){
    return mysql_query($sql,$this->conn);
  }

  public function getAll($sql){
    $list=array();
    $rs=$this->query($sql);
    if (!$rs){
      return false;
    }
    while($row=mysql_fetch_assoc($rs)){
      $list[]=$row;
    }
    return $list;
  }

  public function getOne(){
    $rs=$this->query($sql);
    if (!$rs){
      return false;
    }
    $row=mysql_fetch_assoc($rs);
    return $row[0];
  }
}
?>
