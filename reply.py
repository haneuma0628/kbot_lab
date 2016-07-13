# -*- coding:utf-8 -*-

import tweepy
import yaml
from os.path import join, dirname, abspath
from common import denv, markov


auth = tweepy.OAuthHandler(denv('CONSUMER_KEY'), denv('CONSUMER_SECRET'))
auth.set_access_token(denv('ACCESS_TOKEN'), denv('ACCESS_SECRET'))
api = tweepy.API(auth)

f = open(join(abspath(dirname(__file__)), 'last_replied_id'), 'r')
last_replied_id = file.read(f)
f.close()

mentions = api.mentions_timeline()
unreplied_mentions = []
for mention in mentions:
    if mention.id > last_replied_id:
        unreplied_mentions.append(mention)

if len(unreplied_mentions) > 0:
    for mention in unreplied_mentions:
        pair = mention.user
        keyword = '励まし'
        pos = mention.text.find(keyword)
        if pos > 0:
            f = open(join(abspath(dirname(__file__)), 'message_main.yml'), 'r')
            msgs = yaml.load(f)
            f.close()
            reply_body = msgs['hagemashi']
        else:
            reply_body = markov()

        reply = {
            'status': '@' + pair.screen_name + ' ' + reply_body,
            'in_reply_to_status_id': mention.id
        }

        api.update_status(status=reply['status'], in_reply_to_status_id=reply['in_reply_to_status_id'])

    last_mention = unreplied_mentions[0]
    f = open(join(abspath(dir(__file__)), 'last_replied_id'), 'w')
    f.write(last_mention.id)
    f.close()
