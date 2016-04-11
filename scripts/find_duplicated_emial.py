#encoding:utf-8
'''
shanghaiexpat 中有些用命令创建的superuser,所以导致了有些email不唯一
找出这些email ，可能需要手动删掉
不知道什么原因，重复的email有500多个 常识来说emial应该是唯一的

这不是个函数，只是一个脚本，拷贝到django的shell中运行
'''

from collections import Counter
from django.contrib.auth.models import User


users = User.objects.all()
emails = []
users2 = [] # users no email
for user in users:
    if len(user.email) > 0:
        emails.append(user.email)

cnt = Counter()
for email in emails:
    cnt[email] += 1

cnt.most_common(10)


for user in users:
    if len(user.email)<=1:
        users2.append(user)
# the users have no email is not the instance of User
for user in users:
    if not isinstance(users[2], User):
        users2.append(user)

