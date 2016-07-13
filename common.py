# -*- coding:utf-8 -*-

import dotenv
import random
import yaml
from os.path import join, dirname, abspath


def denv(envkey):
    return dotenv.get_key(join(abspath(dirname(__file__)), '.env'), envkey)


def markov():
    f = open(join(abspath(dirname(__file__)), 'table.yml'), 'r')
    table = yaml.load(f)
    f.close()
    if table:
        period = [u'。', u'！', u'？']
        punc = [u'・', u'、', u'「', u'」']
        current_wd = random.choice(table.keys())
        while current_wd in period or current_wd in punc:
            current_wd = random.choice(table.keys())

        result = [current_wd]
        while current_wd not in period:
            next_wd = random.choice(table[current_wd])
            if not next_wd:
                break
            result.append(next_wd)
            current_wd = next_wd

        sentence = ''.join(result)
        return sentence
    else:
        return None
