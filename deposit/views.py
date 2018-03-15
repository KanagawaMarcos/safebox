from django.shortcuts import render
from django.contrib.auth.decorators import login_required
from django.http import HttpResponseRedirect
from django.contrib.auth.models import User

from deposit.forms import DepositForm,MonthlyDepositForm

# Create your views here.
@login_required
def deposito(request):
    # Check if the form is being submited by the user
    if request.method == 'POST':
        # If the submit button was the one from deposit form
        if 'deposit-submit' in request.POST:

            # Bind the form data to a Model Form
            deposit = DepositForm(request.POST, request.FILES)

            if deposit.is_valid():
                deposit.save()
                return HttpResponseRedirect('/historico/')

            # Clean the cached data from the event subscription form
            monthly_deposit = MonthlyDepositForm(prefix='Monthly Deposit')
        elif 'monthly-submit' in request.POST:

            # Bind the form data to a Model Form
            monthly_deposit = MonthlyDepositForm(request.POST,request.FILES)

            if monthly_deposit.is_valid():
                monthly_deposit.save()
                HttpResponseRedirect('/historico/')

            # Clean the cached data from the withdraw form
            deposit = DepositForm(prefix='Deposit Form')

    #If it's a GET request
    else:
        # Create a clean new form
        deposit = DepositForm(prefix='Deposit Form')
        monthly_deposit = MonthlyDepositForm(prefix='Event Subscription')

    return render(
        request,
        'shell/app_shell.html',
        {
            'is_deposit' : True,
            'title' : 'Depósito',
            'transaction' : deposit,
            'groupTransaction' : monthly_deposit,
            'users': User.objects.all(),
        }
    )
