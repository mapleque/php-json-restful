<?php
class OneModel{
  public $key;
  public $value;

  public function buildNew($oneModel){
    
    $this->key=$oneModel->key;
    $this->value=$oneModel->value;
  }
}
?>
