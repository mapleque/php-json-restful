<?php
class BaseController{
  
  protected $result;//for return value
  protected $status;//for return value
  protected $ret_info;//for return value

  protected $oneModel;
  protected $OneService;

  protected $is_login;

  public function __construct(){
    $this->oneService=OneService::getInstance();
  }

  public function filter($mtd){
    if (!$this->prepare()){
      $this->status=403;
      $this->result=$this->ret_info='forbidden!';
      return;
    }

    switch ($mtd){
      case 'get':$this->get();break;
      case 'put':$this->put();break;
      case 'post':$this->post();break;
      case 'delete':$this->del();break;
      case 'list':$this->lis();break;
      default:
        #TODO: error log
        break;
    }
  }

  //for login check
  //return false stand for not login
  //will not do next and return 403
  public function prepare(){
    $this->oneModel=new OneModel();
    $this->oneModel->key=$_GET['key'];
    $this->oneModel->value=$_GET['value'];
    return true;
  }

  public function get(){
    if (empty($this->oneModel->key)){
      $this->ret_info="failed";
      $this->status=400;
      return;
    }
    $this->result=$this->oneService->getOne($this->oneModel);
    if ($this->result){
      $this->ret_info="success";
      $this->status=200;
    }else{
      $this->ret_info="failed";
      $this->status=400;
    }
  }

  public function put(){
    if (empty($this->oneModel->key)&&empty($this->oneModel->value)){
      $this->ret_info="require param";
      $this->status=400;
      return;
    }
    $this->result=$this->oneService->addOne($this->oneModel);
    if ($this->result){
      $this->ret_info="success";
      $this->status=200;
    }else{
      $this->ret_info="failed";
      $this->status=400;
    }
  }
  
  public function post(){
    if (empty($this->oneModel->key)){
      $this->ret_info="require param";
      $this->status=400;
      return;
    }
    if (empty($this->oneModel->value)){
      $this->ret_info="require param";
      $this->status=400;
      return;
    }
    $this->result=$this->oneService->updateOne($this->oneModel);
    if ($this->result){
      $this->ret_info="success";
      $this->status=200;
    }else{
      $this->ret_info="failed";
      $this->status=400;
    }
  }

  public function del(){
    if (empty($this->oneModel->key)){
      $this->ret_info="failed";
      $this->status=400;
      return;
    }
    $this->result=$this->oneService->deleteOne($this->oneModel);
    if ($this->result){
      $this->ret_info="success";
      $this->status=200;
    }else{
      $this->ret_info="failed";
      $this->status=400;
    }
  }

  public function lis(){
    $start=$_GET['start'];
    $num=$_GET['num'];
    if (empty($start)){
      $start=0;
    }
    if (empty($num)){
      $num=10;
    }
    $this->result=$this->oneService->getOneList($start,$num);
    if ($this->result){
      $this->ret_info="success";
      $this->status=200;
    }else{
      $this->ret_info="failed";
      $this->status=400;
    }
  }

  public function formatResult($ret){
    switch ($ret){
      case 'state':
        $this->formatState();break;
      default:
        break;
    }
    return json_encode(array('status'=>$this->status,'result'=>$this->result));
  }
  
  public function formatState(){
    $this->result=$this->ret_info;
  }

}
?>
