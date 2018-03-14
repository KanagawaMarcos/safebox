from django.shortcuts import render
from django.contrib.auth.decorators import login_required
from django.http import HttpResponseRedirect
from django.contrib.auth.models import User

# from varys.models import Transaction
from .forms import WithdrawForm,EventForm

#To get all boxes and Transactions
from varys.models import Transaction


#Import the safebox
from varys.models import Box

@login_required
def saque(request):
    # Check if the form is being submited by the user
    if request.method == 'POST':
        # If the submit button was the one from withdraw form
        if 'withdraw-submit' in request.POST:

            # Bind the form data to a Model Form
            withdraw_form = WithdrawForm(request.POST, request.FILES)

            if withdraw_form.is_valid():
                withdraw_form.save()

            # Clean the cached data from the event subscription form
            event_form = EventSubscriptionForm(prefix='Event Subscription Form')
            return HttpResponseRedirect('/historico/')

        elif 'event-submit' in request.POST:

            # Bind the form data to an Model Form
            event_form = EventSubscriptionForm(request.POST, request.FILES)

            if event_form.is_valid():
                event_form.save()

            # Clean the cached data from the withdraw form
            withdraw_form = WithdrawForm(prefix='Withdraw Form')
            return HttpResponseRedirect('/historico/')

    #If it's a GET request
    else:
        # Create a clean new form
        withdraw_form = WithdrawForm(prefix='Withdraw Form')
        event_form = EventSubscriptionForm(prefix='Event Subscription Form')

    return render(
        request,
        'shell/app_shell.html',
        {
            'is_withdraw': True,
            'title': 'Saque',
            'transaction' : withdraw_form,
            'groupTransaction' : event_form,
            'users' : User.objects.all()
        }
    )
