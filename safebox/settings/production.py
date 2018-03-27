from .base import *

#200.137.132.90 port 22

DEBUG = False

ALLOWED_HOSTS = [
    'pet.ufma.br/safebox',
    'pet.ufma.br/petbox',
    'pet.ufma.br/box',
    'pet.ufma.br/comp/petbox',
    'pet.ufma.br/comp/safebox',
    'pet.ufma.br/comp/box',
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
