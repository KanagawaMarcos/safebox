from .base import *

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
        'ENGINE': 'mysql_cymysql',
        'NAME': 'safebox',
        'USER': 'petbox',
        'PASSWORD': 'QMwzv5yGnYuCLtEt',
        'HOST': 'pet.ufma.br',   # Or an IP Address that your DB is hosted on
        'PORT': '',
    }
}
