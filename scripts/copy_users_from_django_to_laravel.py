import psycopg2
import MySQLdb
import datetime, time


psycopg2_conn = psycopg2.connect(
        database="expat", 
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


def get_user_data():
    cur = psycopg2_conn.cursor()
    #cur.execute("SELECT * FROM auth_user;")
    cur.execute('''
    select * from auth_user join accounts_myprofile 
    on auth_user.id = accounts_myprofile.user_id
    limit 20;
        ''')
    rows = cur.fetchall() 

    cur.close()
    psycopg2_conn.commit()
    psycopg2_conn.close()
    #for row in rows:
    #    print row
    return rows
#get_user_data()


def save_user_to_mysql(rows):
    cur = mysql_conn.cursor()
    for row in rows:
        ####### insert into user table
        userrow = list()
        userrow.append(row[0]) # 0 id 
        userrow.append(row[4]) # 1 name
        userrow.append(row[7]) # 2 email
        userrow.append(row[1]) # 3 password
        userrow.append(1) if row[9] is True else userrow.append(0) # 5 activated
        userrow.append(0)      # 6 banned
        r2 = row[2]
        last_login = datetime.datetime(r2.year, r2.month, r2.day, r2.hour, r2.minute, r2.second)
        last_login = last_login.strftime('%Y-%m-%d %H:%M:%S')

        userrow.append(last_login) # 9 last_login
        userrow.append(0) # 12 protected
        r10 = row[10]
        created_at = datetime.datetime(r10.year, r10.month, r10.day, r10.hour, r10.minute, r10.second)
        created_at = created_at.strftime('%Y-%m-%d %H:%M:%S')
        userrow.append(created_at) #  13 created_at
        #userrow.append(row[1]) # 16 password_old

        sql = '''
            insert into users(id, name, email, password, activated, banned,last_login,protected, created_at) 
                       values(%d, '%s', '%s',  '%s',     %s,        %d,    '%s',        %d,        '%s')
        ''' % tuple(userrow)
        
        cur.execute(sql) 

        ######## insert into user group
        if row[3] is True: # is_superuser is True
            cur.execute('''
                insert into users_groups (user_id, group_id)
                values(%d, 1)
                ''' % row[0]
                )

        ######## insert into profile table
        print row
        profile_row = list()
        profile_row.append(row[11])  # profile table field  id
        profile_row.append(row[0])   # user_id
        profile_row.append(row[5]) if row[5] else profile_row.append('')  # first_name
        profile_row.append(row[6]) if row[6] else profile_row.append('')  # last_name
        profile_row.append(row[16]) if row[16] else profile_row.append('')  # phone
        profile_row.append(row[15]) if row[15] else profile_row.append('')  # address
        profile_row.append(created_at)   # created_at
        profile_row.append(row[12]) if row[12] else profile_row.append('')  # mugshot
        profile_row.append(row[13])   # privacy
        profile_row.append(row[17]) if row[17] else profile_row.append('')  # company_name
        profile_row.append(row[14]) if row[14] else profile_row.append('null')   # housing_uid
        profile_row.append(row[18]) if row[18] else profile_row.append('null')   # live_area
        profile_row.append(row[19]) if row[19] else profile_row.append('null')   # come_from
        profile_row.append(row[20]) if row[20] else profile_row.append('null')   # come_reason
        profile_row.append(row[21]) if row[21] else profile_row.append('null')   # gender
        profile_row.append(row[22]) if row[22] else profile_row.append('null')   # marital
        profile_row.append(row[23]) if row[23] else profile_row.append('null')   # kids
        #profile_row.append(row[26])   # is_bussiness
        profile_row.append(1) if row[26] is True else profile_row.append(0) # is_bussiness
        #profile_row.append(row[27])   # is_paid_for_classifieds
        profile_row.append(1) if row[27] is True else profile_row.append(0) # is_paid_for_classifieds
        #profile_row.append(row[28])   # is_approved
        profile_row.append(1) if row[28] is True else profile_row.append(0) # is_approved
        if row[24]:
            r24 = row[24]
            birthday = datetime.datetime(r24.year, r24.month, r24.day)
            birthday = birthday.strftime('%Y-%m-%d')
            profile_row.append(birthday)
        else:
            profile_row.append(row[24])



        profile_sql = '''
        insert into user_profile(id, user_id, first_name, last_name, phone, address,created_at,mugshot, privacy,company_name,housing_uid, live_area, come_from, come_reason, gender, marital, kids, is_bussiness, is_paid_for_classifieds, is_approved, birthday) 
                          values(%d, %d,      '%s',       '%s',      '%s',  '%s',   '%s',      '%s',    '%s',   '%s',        %s,          %s,        %s,        %s,          %s,     %s,      %s,   %s,            %d,                       %d,        '%s'  )
        '''% tuple(profile_row)
        print profile_sql
        cur.execute(profile_sql) 
    cur.close()
    mysql_conn.commit()
    mysql_conn.close()
#save_user_to_mysql(None)



if __name__ == '__main__':
    rows=get_user_data()
    save_user_to_mysql(rows)
    pass