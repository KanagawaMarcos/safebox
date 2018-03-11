from django.shortcuts import render
from django.contrib.auth.decorators import login_required
from django.http import HttpResponseRedirect
from deposit.forms import DepositForm,MonthlyDepositForm
from django.contrib.auth.models import User

# Create your views here.
@login_required
def deposito(request):
    if request.method == 'POST':
        form = DepositForm(request.POST, request.FILES)
        groupForm = MonthlyDepositForm(request.POST)

        if request.POST['its_type'] == 'Deposito':
            if form.is_valid():
                form.save()
                HttpResponseRedirect('/historico/')
        else:
            if groupForm.is_valid():
                groupForm.save()

    else:
        form = DepositForm()
        groupForm = MonthlyDepositForm()
    return render(request, 'shell/app_shell.html', {
        'is_deposit' : True,
        'title' : 'Deposit',
        'transaction' : form,
        'groupTransaction' : groupForm,
        'users': User.objects.all(),
    })
