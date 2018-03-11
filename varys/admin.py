from django.contrib import admin
from .models import Transaction,GroupTransaction
from .models import Box

# Register your models here.
admin.site.register(Transaction)
admin.site.register(GroupTransaction)
admin.site.register(Box)
