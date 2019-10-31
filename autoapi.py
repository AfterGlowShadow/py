#coding=UTF-8
import basesql as BaseSql
#只支持php5以上
#apiName 名称
#apiURI 网址
#apiFailureContentType 参数格式
#createTime 创建时间 
#apiRequestType 类型0post 1get
#requestInfo参数
#paramName参数解释
#paramKey 参数名称
#
#"paramNotNull": "0",
	#		"paramType": "0",
	#		"paramName": "当前页数",
	#		"paramKey": "page",
	#		"paramValue": "0",
	#		"paramLimit": "",
	#		"paramNote": "",
	#		"paramValueList": [],
	#		"default": 0,
	#		"childList": []
	### 获取读取route文件的路径 添加controller/model/validate/middleware的根目录  分析route文件得到url controller文件名
file = open("./route.php", "rb")
urllsit=[]
path=""
rule=[]
zhushi=""
name=""
isshow=0
menu=""
menulist={}
type=""
while True:
  lines = file.readline().decode('utf-8')
  if 'Route::' in lines:
    if 'group' in lines:
     zhushi=""
     x = lines.split(",", 1)
     x = x[0].split("(", 1)
     x= x[1][1:-1]
     urllsit.append(x)
    else:
      x = lines.split(",", 1)
      temp=x[0].split("::",1)
      path=x[1].split(")",1)
      path=path[0][1:-1]
      temp=temp[1].split("(",1)
      contorller=temp[1][1:-1]
      urltemp={}
      urltemp['RequestType']=temp[0]
      urltemp['url']='/'.join(urllsit)+"/"+contorller
      urltemp['path']=path
      urltemp['name']=name
      urltemp['menu']=menu
      urltemp['isshow']=isshow
      urltemp['type']=type
      rule.append(urltemp)
      name=""
      type=""
      isshow=0
      menu=""
  elif "})" in lines:
    urllsit.pop()
  elif "@name" in lines:
    lines=lines.rstrip("\r\n")
    x = lines.split("@name ", 1)
    name=x[1]
  elif "@menu" in lines:
    lines=lines.rstrip("\r\n")
    x = lines.split("@menu ", 1)
    menu=x[1]
    menulist[menu]='0'
  elif "@isshow" in lines:
    lines=lines.rstrip("\r\n")
    x = lines.split("@isshow ", 1)
    isshow=x[1]
  elif "@type" in lines:
    lines = lines.rstrip("\r\n")
    x = lines.split("@type ", 1)
    type = x[1]
    urltemp = {}
    urltemp['RequestType'] = temp[0]
    urltemp['url'] = ''
    urltemp['path'] = path
    urltemp['name'] = name
    urltemp['menu'] = menu
    urltemp['isshow'] = isshow
    urltemp['type'] = type
    rule.append(urltemp)
    name = ""
    type = ""
    isshow = 0
    menu = ""
  if not lines:
    break
#读取完toute文件获得结构为[{REquestType:post,url:api/tian/long,path:admin/tian,name:tian},{REquestType:post,url:api/tian/long,path:admin/tian,name:""}]列表
#遍历route字典 保存到数据库的rule权限表中
for ruleitem in rule:
  prule='0'
  if ruleitem['menu'].strip():
    prule=menulist[ruleitem['menu']]
  # print(prule)
  sql="INSERT INTO `lj_rule` (`title` , `prule` , `url`,`is_show`) VALUES ('{}', '{}' , '{}','{}')".format(ruleitem['name'],prule,ruleitem['url'],ruleitem['isshow'])
  # sql="INSERT INTO `lj_rule` (`title` , `prule` , `url`,`is_show`) VALUES ('"+ruleitem['name']+"' , "+prule+" , '"+ruleitem['url']+"',"+ruleitem['isshow']+")"
  SqlAction=BaseSql.BaseSql()
  res=SqlAction.InsertData(sql)
  if ruleitem['type']=="menu":
    menulist[ruleitem['menu']]=str(res)
  #数据库操作没有写(先完善数据库的添加操作)
  ### 1.先查询要插入的表 获得表的数据结构
  ### 2.遍历获得的表结构与要保存的表结构进行处理 组成最终添加的结构
  ### 3.将最终结果保存到数据库
