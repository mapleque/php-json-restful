<?php
class OneDao{
  private $mysqli=null;

  const TABLE="one_table";//define the tablename

  #const CreateTableSql="create table ".TABLE." ( `one_key` varchar(32) not null unique primary key, `one_value` blob);";//create the table

  private static $instance=NULL;
  static function getInstance(){
    if (self::$instance==NULL){
      self::$instance=new OneDao();
    }
    return self::$instance;
  }
  
  private function __construct(){
    $this->mysqli=DBTool::getMysqli();
  }
  private function __clone(){}

  public function getOneList($start=0,$num=10){
    $list=array();
    $oneModel=new OneModel();
    $sql="select * from ".self::TABLE." limit ?,?";
    $stmt=$this->mysqli->prepare($sql);
    $stmt->bind_param("ii",$start,$num);
    $stmt->execute();
    $stmt->bind_result(
      $oneModel->key,
      $oneModel->value
    );
    while($stmt->fetch()){
      $nm=new OneModel();
      $nm->buildNew($oneModel);
      $list[]=$nm;
    }
    $stmt->close();
    return $list;
  }
  public function getOneNum(){
    $num=0;
    $sql="select count(*) from ".self::TABLE;
    $stmt=$this->mysqli->prepare($sql);
    $stmt->bind_result($num);
    $stmt->execute();
    $stmt->close();
    return $num;
  }

  public function getOne($oneModel){
    $result=new OneModel();
    $sql="select * from ".self::TABLE." where one_key = ? ";
    $stmt=$this->mysqli->prepare($sql);
    $stmt->bind_param("s",$oneModel->key);
    $stmt->execute();
    $stmt->bind_result(
      $result->key,
      $result->value
    );
    $stmt->fetch();
    $stmt->close();
    return $result;
  }
  public function addOne($oneModel){
    $sql="insert into ".self::TABLE." (one_key,one_value) values (?,?)";
    $stmt=$this->mysqli->prepare($sql);
    $stmt->bind_param("ss",
      $oneModel->key,
      $oneModel->value
    );
    $stmt->execute();
    $stmt->close();
  }
  public function updateOne($oneModel){
    $sql="update ".self::TABLE." set 
            one_value = ?
            where 
            one_key = ?
            ";
    $stmt=$this->mysqli->prepare($sql);
    $stmt->bind_param("ss",
      $oneModel->value,
      $oneModel->key
    );
    $stmt->execute();
    $stmt->close();
  }
  public function deleteOne($oneModel){
    $sql="delete from ".self::TABLE." where one_key=?";
    $stmt=$this->mysqli->prepare($sql);
    $stmt->bind_param("s",$oneModel->key);
    $stmt->execute();
    $stmt->close();
  }
}
?>
