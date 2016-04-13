#encoding:utf-8
'''
shanghaiexpat 中有些用命令创建的superuser,所以导致了有些email不唯一
找出这些email ，可能需要手动删掉
不知道什么原因，重复的email有500多个 常识来说emial应该是唯一的

这不是个函数，只是一个脚本，拷贝到django的shell中运行
'''

from collections import Counter
from django.contrib.auth.models import User
from accounts.models import MyProfile
import datetime


users = User.objects.all()
emails = []
for user in users:
    if len(user.email) > 0:
        emails.append(user.email)

cnt = Counter()
for email in emails:
    cnt[email] += 1

cnt.most_common(10)

users2 = list() # users no email
for user in users:
    if len(user.email)<=1:
        users2.append(user)

# the users have no email is not the instance of User
#users3 = list() # users no email
#for user in users:
#    if not isinstance(users[2], User):
#        users3.append(user)


# user have a long time not login
a = datetime.datetime(2014, 11, 21, 0, 0, 0)
users3 = User.objects.filter(last_login__lt=a)
for one in users3:
    if isinstance(one, User):
        print type(one)
        profile = MyProfile.objects.get(user=one)


# 名字带有__rent 且没有在那之后登录过 sdfsd
a = datetime.datetime(2014, 11, 21, 0, 0, 0)
users3 = User.objects.filter(username__contains="__rent", last_login__lt=a)#;len(users3)
for i, user in enumerate(users3[:]):
    profile = MyProfile.objects.get(user_id=user.id)
    profile.delete()
    user.delete()
    print 'delete one ' + str(i)


a = datetime.datetime(2014, 11, 21, 0, 0, 0)
cnt2 = cnt.most_common(36)
for i,n in enumerate(cnt2):
    #print str(i) + ' delete -------------------------- ' + n[0]
    users3 = User.objects.filter(email=n[0], last_login__lt=a)#.exclude(email__contains='ringierchina').exclude(email__contains='shanghaiexpat')#;len(users3)
    for user in users3[:]:
        print user
        #profile = MyProfile.objects.get(user=user)
        #profile.delete()
        #user.delete()

#user have no email
users = User.objects.all()
un = []
for user in users:
    if len(user.email) < 1:
        print user
        #profile = MyProfile.objects.get(user=user)
        #profile.delete()
        #user.delete()