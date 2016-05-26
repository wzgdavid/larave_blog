import psycopg2
import MySQLdb
import datetime, time


psycopg2_conn = psycopg2.connect(
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
    cur.execute('''
        select * from classified_classifiedcategory order by id;
        ''')
    rows = cur.fetchall() 

    cur.close()
    psycopg2_conn.commit()
    psycopg2_conn.close()

    cur2 = mysql_conn.cursor()
    for row in rows:
        #print type(row)
        row2 = list()
        row2.append(row[0])
        row2.append(row[1])
        row2.append(row[2])
        row2.append(row[3])
        row2.append(row[4]) if row[4] else row2.append('null') # title
        row2.append(row[5])
        sql = '''
            insert into classified_category values({id}, '{name}', '{slug}',
                {sort_order}, {parent_id}, {form_type})
        '''.format(id=row2[0],
            name=row2[1],
            slug=row2[2],
            sort_order=row2[3],
            parent_id=row2[4],
            form_type=row2[5],

            )
        print sql
        cur2.execute(sql) 
    cur2.close()
    mysql_conn.commit()
    mysql_conn.close()


def copy_classified():
    cur = psycopg2_conn.cursor()
    cur.execute('''
        select * from classified_classified order by id;
        ''')
    rows = cur.fetchall() 

    cur.close()
    psycopg2_conn.commit()
    psycopg2_conn.close()

    cur2 = mysql_conn.cursor()
    for row in rows:
        #print row
        row2 = list()
        row2.append(row[0])
        row2.append(1) if row[1] is True else row2.append(0)
        row2.append(1) if row[2] is True else row2.append(0)
        row2.append(row[3].replace('"', "'"))
        row2.append(row[4])
        row2.append(row[5].replace('"', "'"))
        row2.append(row[6]) if row[6] else row2.append('')
        row2.append(row[7]) if row[7] else row2.append('')
        row2.append(row[8])
        row2.append(row[9]) if row[9] else row2.append('null')
        row2.append(1) if row[10] is True else row2.append(0)
        row2.append(1) if row[11] is True else row2.append(0)
        row2.append(row[12])
        row2.append(row[13])
        row2.append(row[14]) if row[14] else row2.append('null')
        row2.append(row[15]) if row[15] else row2.append('null')
        row2.append(row[16])
        row2.append(row[17]) if row[17] else row2.append('')
        row2.append(1) if row[18] is True else row2.append(0)
        row2.append(row[19]) if row[19] else row2.append('null')
        row2.append(row[20]) if row[20] else row2.append('null')
        row2.append(row[21]) if row[21] else row2.append('null')
        row2.append(row[22])
        sql = '''
            insert into classified values(
                {id}, {is_approved}, {is_individual}, "{title}", "{slug}",
                "{content}", '{start_datetime}', '{end_datetime}', '{price}', {size},
                {is_shared}, {is_agency}, "{geo_location}", "{size_sequare}", {contributor_id},
                {district_id}, '{create_datetime}', '{forum_url}', {featured},
                {category_id}, {metro_line}, {station}, '{date_modified}'
                )
        '''.format(id=row2[0],
            is_approved=row2[1],
            is_individual=row2[2],
            title=row2[3],
            slug=row2[4],
            content=row2[5],
            start_datetime=row2[6],
            end_datetime=row2[7],
            price=row2[8],
            size=row2[9],
            is_shared=row2[10],
            is_agency=row2[11],
            geo_location=row2[12],
            size_sequare=row2[13],
            contributor_id=row2[14],
            district_id=row2[15],
            create_datetime=row2[16],
            forum_url=row2[17],
            featured=row2[18],
            category_id=row2[19],
            metro_line=row2[20],
            station=row2[21],
            date_modified=row2[22],


            )
        print sql
        cur2.execute(sql) 
    cur2.close()
    mysql_conn.commit()
    mysql_conn.close()


def copy_metro():
    cur = psycopg2_conn.cursor()
    cur.execute('''
        select * from housing_metro order by id;
        ''')
    rows = cur.fetchall() 
    cur.close()
    psycopg2_conn.commit()
    psycopg2_conn.close()

    cur2 = mysql_conn.cursor()
    for row in rows:
        sql = '''
            insert into metro values({id}, {line}, "{station}")
        '''.format(id=row[0],
            line=row[1],
            station=row[2])
        print sql
        cur2.execute(sql) 
    cur2.close()
    mysql_conn.commit()
    mysql_conn.close()


if __name__ == '__main__':
    #copy_category()
    #copy_classified()
    copy_metro()
    pass