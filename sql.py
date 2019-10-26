# 导入pymysql模块
import basesql as BaseSql
# 连接database
#json_str = json.dumps(test_dict, indent=4)#注意这个indent参数
#with open('test_data.json', 'w') as json_file:
#     json_file.write(json_str)
#exit
sql = """
SELECT * FROM `config` WHERE 1
"""
SqlAction=BaseSql.BaseSql()
res=SqlAction.Select(sql)
print(res)
