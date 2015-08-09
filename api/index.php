<?php
require 'RequestFilter.php';
#### 参数说明 ####

## res ## 用于区分业务 for result service
# 参考RequestFilter中的定义
# 默认为one
#

## ret ## 用于区分返回数据类型 for result type
# state   ：  返回状态型数据
# info    ：  返回实体性数据
# list    ：  返回列表型数据

## _mtd ## 用于区分数据操作方式 for method
# get     ：  查询
# put     ：  添加
# post    ：  修改
# delete  ：  删除
# list    ：  列表

## sid ## 用于区分来源 for source_id
# defined as follow
$SOURCE_MAP=array(
  '0001'=>'test'
);

## key ## 数据的key for model 某些情况下该参数可能不传
## value ## 数据的value for model 某些情况下该参数可能不传
## start ## list查询时作为第一条数据index for list 某些情况下该参数可能不传
## num ## list查询时作为数据列表大小 for list 某些情况下该参数可能不传


#### 请求示例 ####

# /api/?res=one&ret=info&_mtd=put&sid=0001&key=atestkey&value=atestvalue
# /api/?res=one&ret=info&_mtd=get&sid=0001&key=atestkey
# /api/?res=one&ret=info&_mtd=post&sid=0001&key=atestkey&value=atestvalueupdate
# /api/?res=one&ret=info&_mtd=list&sid=0001&start=0&num=10
# /api/?res=one&ret=info&_mtd=delete&sid=0001&key=atestkey

#deal param
$res=$_GET['res'];
$ret=$_GET['ret'];
$mtd=$_GET['_mtd'];
if (!isset($res)||!isset($ret)||!isset($mtd)){
  echo json_encode(array('status'=>400,'info'=>'Bad Request!'));
  #TODO error log
  return;
}

#map source
$source_id=$_GET['sid'];
$source='unkown';
if (isset($source_id)&&array_key_exists($source_id,$SOURCE_MAP)){
  $source=$SOURCE_MAP[$source_id];
}else{
  echo json_encode(array('status'=>403,'info'=>'Unknown Source! Request Forbidden!'));
  #TODO error log
  return;
}

$controller=RequestFilter::getController($res);
$controller->filter($mtd);
$result=$controller->formatResult($ret);
echo $result;
?>
