<?php
require 'BaseController.php';
require 'DBTool.php';
require 'OneModel.php';
require 'OneService.php';
require 'OneDao.php';
class RequestFilter{
  static $CTRL_MAP=array(
    'one'=>'BaseController'
  );
  static function getController($res){
    if (array_key_exists($res,self::$CTRL_MAP)){
      $class=new ReflectionClass(self::$CTRL_MAP[$res]);
      $instance=$class->newInstanceArgs();
      return $instance;
    }
  }
}
?>
