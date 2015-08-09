<?php
class OneService{
  private $oneDao=null;

  private static $instance=NULL;
  static function getInstance(){
    if (self::$instance==NULL){
      self::$instance=new OneService();
    }
    return self::$instance;
  }

  private function __construct(){
    $this->oneDao=OneDao::getInstance();
  }
  private function __clone(){}

  public function getOne($oneModel){
    return $this->oneDao->getOne($oneModel);
  }

  public function getOneList($start=0,$num=10){
    return $this->oneDao->getOneList($start,$num);
  }

  public function getOneNum(){
    return $this->oneDao->getOneNum();
  }

  public function addOne($oneModel){
    $curOne=$this->oneDao->getOne($oneModel);
    if ($curOne->key){
      return false;
    }else{
      $this->oneDao->addOne($oneModel);
    }
    return true;
  }

  public function updateOne($oneModel){
    $curOne=$this->oneDao->getOne($oneModel);
    if ($curOne){
      $this->oneDao->updateOne($oneModel);
    }else{
      return false;
    }
    return true;
  }

  public function deleteOne($oneModel){
    $curOne=$this->oneDao->getOne($oneModel);
    if ($curOne){
      $this->oneDao->deleteOne($oneModel);
    }else{
      return false;
    }
    return true;
  }
}
?>
