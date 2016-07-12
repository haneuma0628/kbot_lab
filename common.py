# -*- coding:utf-8 -*-

import dotenv
from os.path import join, dirname, abspath


def denv(envkey):
    return dotenv.get_key(join(abspath(dirname(__file__)), '.env'), envkey)


def markov():
    return 'aaa'