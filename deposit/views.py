from django.shortcuts import render
from django.contrib.auth.decorators import login_required
from django.http import HttpResponseRedirect
from deposit.forms import DepositForm

# Create your views here.
@login_required
def deposito(request):
    if request.method == 'POST':
        form = DepositForm(request.POST, request.FILES)
        if form.is_valid():
            form.save()
            HttpResponseRedirect('/historico/')
        else:
            print (str(form.errors.as_data()))
    else:
        form = DepositForm()
    return render(request, 'shell/app_shell.html', {
        'is_deposit' : True,
        'title' : 'Depósito',
        'transaction' : form
    })
