from .base import *

#200.137.132.90 port 22

DEBUG = False

ALLOWED_HOSTS = [
    'pet.ufma.br',
]


DATABASES = {
    'default': {
        'ENGINE': 'django.db.backends.mysql',
        'NAME': 'safebox',
        'USER': 'petbox',
        'PASSWORD': 'QMwzv5yGnYuCLtEt',
#	'HOST':'pet.ufma.br',
#	'HOST':'/var/run/mysqld',
	'HOST':'pet.ufma.br',
#	'PORT':'80',
	'PORT':'3306',
    }
}
