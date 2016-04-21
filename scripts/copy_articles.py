#encoding:utf-8
import psycopg2
import MySQLdb
import datetime, time



psycopg2_conn = psycopg2.connect(
        #database="expat", 
        database="postgres", 
        user="david", 
        password="1", 
        host="localhost", 
        port="5432"
    )

mysql_conn= MySQLdb.connect(
        host='localhost',
        port = 3306,
        user='root',
        passwd='1',
        db ='blog',
    )


def copy_category():
    cur = psycopg2_conn.cursor()
    #cur.execute("SELECT * FROM auth_user;")
    cur.execute('''
        select * from article_articlecategory;
        ''')
    rows = cur.fetchall() 

    cur.close()
    psycopg2_conn.commit()
    psycopg2_conn.close()


    # save data
    cur = mysql_conn.cursor()
    
    for row in rows:
        rows2 = list()
        rows2.append(row[0])
        rows2.append(row[1])
        rows2.append(row[2])
        rows2.append(row[3]) if row[3] else rows2.append('null') 
        rows2.append(row[4])
        rows2.append(row[5]) if row[5] else rows2.append('null') 
        rows2.append(row[6]) if row[6] else rows2.append('null') 
        rows2.append(row[7])# if row[7] else rows2.append('null') 

        sql = '''
        insert into article_category values(%d,%d,'%s',%s,'%s',%s,%s,%s)
        ''' % tuple(rows2)
        print sql
        cur.execute(sql) 
    cur.close()
    mysql_conn.commit()
    mysql_conn.close()
#get_user_data()


def copy_author():
    cur = psycopg2_conn.cursor()
    #cur.execute("SELECT * FROM auth_user;")
    cur.execute('''
        select * from article_articleauthor;
        ''')
    rows = cur.fetchall() 

    cur.close()
    psycopg2_conn.commit()
    psycopg2_conn.close()


    # save data
    cur = mysql_conn.cursor()
    
    for row in rows:
        rows2 = list()
        rows2.append(row[0])
        rows2.append(row[1])
        rows2.append(row[2]) if row[2] else rows2.append('')
        rows2.append(row[3]) if row[3] else rows2.append('') 


        sql = '''
        insert into article_author values(%d,"%s",'%s','%s')
        ''' % tuple(rows2)
        print sql
        cur.execute(sql) 
    cur.close()
    mysql_conn.commit()
    mysql_conn.close()


def copy_article():
    '''
    这个方法不用了  用导入导出csv的方法
    '''
    cur = psycopg2_conn.cursor()
    cur.execute('''
        select * from article_article where id = 11361
        ''')
    rows = cur.fetchall() 

    cur.close()
    psycopg2_conn.commit()
    psycopg2_conn.close()

    
    # save data
    cur = mysql_conn.cursor()
    
    for row in rows:
        #print row
        article = list()
        article.append(row[0])
        article.append(1) if row[1] is True else article.append(0) # is_approved
        article.append(1) if row[2] is True else article.append(0) # is_special
        article.append(1) if row[3] is True else article.append(0) # is_welcome
        article.append(row[4])  # category_id
        article.append(row[5]) # user_id
        article.append(row[6]) # date_created
        article.append(row[7]) # date_modified
        article.append(row[8]) if row[8] else article.append('') # title
        article.append(row[9]) if row[9] else article.append('') # subtitle
        article.append(row[10]) if row[10] else article.append('') # content
        article.append(row[11]) if row[11] else article.append('') # page_title
        article.append(row[12]) if row[12] else article.append('') # meta description
        article.append(row[13]) if row[13] else article.append('null') # nid
        article.append(row[14]) if row[14] else article.append('') # hyperlink
        article.append(row[15]) if row[15] else article.append('') # keywords
        article.append(row[16]) if row[16] else article.append('') # pic
        article.append(row[17]) if row[17] else article.append('') # related_threads
        article.append(1) if row[18] is True else article.append(0) # is_shf_featured
        article.append(1) if row[19] is True else article.append(0) # is_shf_sponsored
        article.append(1) if row[20] is True else article.append(0) # is homepage sponsored
        article.append(row[21]) # author id
        article.append(row[22]) # shf priority
        article.append(1) if row[23] is True else article.append(0) # is home featured
        article.append(row[24]) # date created
        article.append(row[25]) # date modified
        
        #     column               0   1  2  3 4  5  6    7    8    9    10   11   12   13 14   15   16   17   18 19 20 21 22 23  24 25
        #sql = '''
        #insert into article values(%d,%d,%d,%d,%d,%d,'%s','%s','%s','%s','%s','%s','%s',%s,'%s','%s','%s','%s',%d,%d,%d,%d,%d,%d,'%s','%s')
        #''' % tuple(article)

        #     column               0   1  2  3 4  5  6    7    8    9    11   12   13 14   15   16   17   18 19 20 21 22 23  24 25
        sql = '''
        insert into article(id,is_approved,is_special,is_welcome,category_id,)
                            values(%d,%d,%d,%d,%d,%d,'%s','%s','%s','%s','%s','%s',%s,'%s','%s','%s','%s',%d,%d,%d,%d,%d,%d,'%s','%s')
        ''' % tuple(article)

        print sql
        cur.execute(sql) 
    cur.close()
    mysql_conn.commit()
    mysql_conn.close()

def import_mysql_boolean():
    '''
    postgres中boolean是用true和false表示 （在csv中是t和f）
    但mysql中是用1和0（tinyint）表示，直接导入的话在mysql中都是显示0
    直接改csv把t和f改成1和0导致导入mysql的某些数据column对不上

    先把原数据导入mysql，再通过这个函数update布尔值
    '''
    cur = psycopg2_conn.cursor()
    cur.execute('''
        select id,is_approved, is_special, is_welcome, is_shf_featured,
            is_shf_sponsored, is_homepage_sponsored, is_home_featured
        from article_article 
        --where id in (8029 ,10691,  10099, 8810, 8936, 8939 , 10126 ,10128 ,10222 ,9217 ,9178,7898,7899)
        --limit 1000
        ''')
    rows = cur.fetchall() 
    #print rows

    cur.close()
    psycopg2_conn.commit()
    psycopg2_conn.close()

    cur2 = mysql_conn.cursor()

    for row in rows:
        arow = list()
        arow.append(row[0])
        arow.append(1) if row[1] is True else arow.append(0) # is_approved
        arow.append(1) if row[2] is True else arow.append(0) # is_special
        arow.append(1) if row[3] is True else arow.append(0) # is_welcome
        arow.append(1) if row[4] is True else arow.append(0) # is_shf_featured
        arow.append(1) if row[5] is True else arow.append(0) # is_shf_sponsored
        arow.append(1) if row[6] is True else arow.append(0) # is_homepage_sponsored
        arow.append(1) if row[7] is True else arow.append(0) # is_home_featured
        sql = '''
        update article set 
            is_approved={is_approved}, 
            is_special={is_special}, 
            is_welcome={is_welcome}, 
            is_shf_featured={is_shf_featured}, 
            is_shf_sponsored={is_shf_sponsored}, 
            is_homepage_sponsored={is_homepage_sponsored}, 
            is_home_featured={is_home_featured}
        where id = {id}
        '''.format(id=arow[0],
                   is_approved=arow[1],
                   is_special=arow[2],
                   is_welcome=arow[3],
                   is_shf_featured=arow[4],
                   is_shf_sponsored=arow[5],
                   is_homepage_sponsored=arow[6],
                   is_home_featured=arow[7],

            )

        print sql
        cur2.execute(sql) 
    cur2.close()
    mysql_conn.commit()
    mysql_conn.close()





if __name__ == '__main__':
    #copy_category()
    #copy_author()
    #copy_article()
    import_mysql_boolean()

    pass



