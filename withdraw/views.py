from django.shortcuts import render
from django.contrib.auth.decorators import login_required

# Create your views here.
@login_required
def saque(request):
    #withdraw = WithdrawForm()
    return render(request, 'withdraw/saque.html')#,{'withdraw', withdraw}
