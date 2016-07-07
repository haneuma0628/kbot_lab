# -*- coding:utf-8 -*-

import dotenv
import tweepy
import yaml
import random
import datetime
import pprint

from os.path import join, dirname, abspath


def denv(envkey):
    return dotenv.get_key(join(dirname(__file__), '.env'), envkey)


def hour_to_timezone(hour):
    table = {
        0: 'night',
        8: 'morning'
    }
    if hour in table.keys():
        return table[hour]
    else:
        return 'normal'


auth = tweepy.OAuthHandler(denv('CONSUMER_KEY'), denv('CONSUMER_SECRET'))
auth.set_access_token(denv('ACCESS_TOKEN'), denv('ACCESS_SECRET'))
api = tweepy.API(auth)

f = open(join(abspath(dirname(__file__)), 'message_main.yml'), 'r')
msgs = yaml.load(f)
f.close()

hour = int(datetime.datetime.now().hour)
timezone = hour_to_timezone(hour)
rnd = int(random.uniform(0, len(msgs[timezone]) - 1))
msg = msgs[timezone][rnd]

api.update_status(msg)
