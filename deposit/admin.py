from django.contrib import admin
from deposit.models import Deposit,MonthlyDeposit

# Register your models here.
admin.site.register(Deposit)
admin.site.register(MonthlyDeposit)
