from django.shortcuts import render
from django.contrib.auth.decorators import login_required

# Create your views here.
@login_required
def saque(request):
    return render(request, 'shell/app_shell.html',{'is_withdraw':True})
