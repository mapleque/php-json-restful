# php-json-restful
这是一个基于rest规则实现的php web service框架，数据全部采用json格式，存储采用key-value形式，能够适用于大多数简单web应用场景。
##部署方法
-将api目录及目录下所有文件部署到php项目根目录下。
-修改DBTool.php中的数据库相关信息
-使用OneDao.php中的sql创建数据库表
-可以发请求进行测试了

##请求示例

```
    /api/?res=one&ret=info&_mtd=put&sid=0001&key=atestkey&value=atestvalue
    /api/?res=one&ret=info&_mtd=get&sid=0001&key=atestkey
    /api/?res=one&ret=info&_mtd=post&sid=0001&key=atestkey&value=atestvalueupdate
    /api/?res=one&ret=info&_mtd=list&sid=0001&start=0&num=10
    /api/?res=one&ret=info&_mtd=delete&sid=0001&key=atestkey
```
*注意，这里的value可以传入json字符串，相当于可以自定义数据结构*
##返回示例

```
    {"status":200,"result":{"key":"atestkey","value":"atestvalue"}}
```
##代码说明
index.php为代码入口，所有请求通过index.php接入后转入处理流程，其中请求参数说明如下：
```
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
    
    ## key ## 数据的key for model 某些情况下该参数可能不传
    ## value ## 数据的value for model 某些情况下该参数可能不传
    ## start ## list查询时作为第一条数据index for list 某些情况下该参数可能不传
    ## num ## list查询时作为数据列表大小 for list 某些情况下该参数可能不传
```
index.php中只判断请求来源(可以添加代码输入该来源用于统计)，其他逻辑都放在controller中进行处理，具体使用哪个controller，可在RequestFilter中配置（默认使用BaseControler即可）。


RequestFilter.php中实现了Controller的分发，并且定义了方法调用数据和整个框架的依赖。


BaseController.php中实现了rest全部方法，并可以通过prepare方法初始化用户信息以及数据信息等。


OneService.php是服务层逻辑的简单实现，通过调用dao层提供的方法，实现对数据的综合逻辑操作。


OneDao.php是数据层逻辑的简单实现，本实例实现的是基于mysql的数据存储和读写。


OneModel.php是数据Bean


DBTool.php封装了mysqli的查询方法，用于提供mysql数据库链接及操作接口。
