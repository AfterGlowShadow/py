import pymysql
import json
class BaseSql:
    cursor=""
    conn=""
    sqlconfig={}
    def __init__(self):
        # 连接database
        sqlconfig=self.output()
        self.conn = pymysql.connect(sqlconfig['host'],sqlconfig['username'],sqlconfig['password'],sqlconfig['database'])
        self.cursor = self.conn.cursor()
    def output(self):
        file = open("./test_data.json", "rb")
        fileJson = json.load(file)
        return fileJson['sql']
    #基本执行方法(执行完处理数据 整理出对应字典返回)
    def Execute(self,sql):
        self.cursor.execute(sql)
        dataname=self.cursor.description  #可以通过此方法在控制台中打印出表中所有的字段名和字段信息
        return dataname
    #关闭sql 连接
    def Close(self):
        # 关闭光标对象
        self.cursor.close()
        # 关闭数据库连接
        self.conn.close()
    #创建表
    def CreateTable(self,sql):
        return self.Execute(self,sql)
    #删除表
    def DeleteTable(self,sql):
        return self.Execute(self,sql)
    #删除数据
    def DeleteData(self,sql):
        return self.Execute(self,sql)
    #更新数据
    def UpdateData(self,sql):
        return self.Execute(self,sql)
    #插入数据
    def InsertData(self,table,data):
        # self.cursor.execute(sql)
        # cursor = self.conn.insert_id()
        # self.conn.commit()
        # return cursor
        findselect="SELECT * FROM "+table+" LIMIT 1 "
        tableinfo=self.Execute(findselect)
        insertdata={}
        for k,v in enumerate(tableinfo):
            if v[0] in tableinfo:
                print ("tioan")
                insertdata[v[0]]=tableinfo[v[0]]
            else:
                insertdata[v[0]]=""
        print(tableinfo)
        print(data)
        print(insertdata)
        exit()
        # insert="INSERT INTO `lj_rule` (`title` , `prule` , `url`,`is_show`) VALUES ('{}', '{}' , '{}','{}')".format(ruleitem['name'],prule,ruleitem['url'],ruleitem['isshow'])
        return self.Execute(self,sql)
    #查询数据
    def Select(self,sql):
        dataname=self.Execute(sql)
        return self.SqlBackFormat(dataname)
    #处理执行完返回的数据
    def SqlBackFormat(self,dataname):
        data = self.cursor.fetchall()
        cursor = self.conn.insert_id()
        backdata={}
        back={}
        for k , v in enumerate(data):
            item={}
            for k1 ,v1 in enumerate(dataname):
                item[v1[0]]=v[k1]
            backdata[k]=item
        back['backdata']=backdata
        back['id']=cursor
        return back
    #处理外面传过来的数据

