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
        'PASSWORD': 'look_at_other_place',
	'HOST':'pet.ufma.br',
	'PORT':'3306',
    }
}
