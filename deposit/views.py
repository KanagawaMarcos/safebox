from django.shortcuts import render
from django.contrib.auth.decorators import login_required
from django.http import HttpResponseRedirect
from django.contrib.auth.models import User

from deposit.forms import DepositForm,MonthlyDepositForm
from varys.models import Box

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

                #add  money from the box
                boxes = Box.objects.filter(name=deposit.cleaned_data['destination'].name)
                for box in boxes:
                    box.value = box.value + deposit.cleaned_data['value']
                    box.save()
                return HttpResponseRedirect('/box/historico/')

            # Clean the cached data from the event subscription form
            monthly_deposit = MonthlyDepositForm()
        elif 'monthly-submit' in request.POST:
            # Bind the form data to a Model Form
            monthly_deposit = MonthlyDepositForm(request.POST)

            if monthly_deposit.is_valid():
                monthly_deposit.save()

                #add the money from the box
                boxes = Box.objects.filter(name='Geral')#Bad Pratice!!!!
                for box in boxes:
                    total = monthly_deposit.cleaned_data['value']*monthly_deposit.cleaned_data['users'].count()
                    box.value = box.value + total
                    box.save()
                return HttpResponseRedirect('/box/historico/')

            # Clean the cached data from the normal deposit form
            deposit = DepositForm()

    #If it's a GET request
    else:
        # Create a clean new form
        deposit = DepositForm()
        monthly_deposit = MonthlyDepositForm()

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
