from django.shortcuts import render
from django.contrib.auth.decorators import login_required
from django.http import HttpResponseRedirect
from django.contrib.auth.models import User

from withdraw.forms import WithdrawForm,EventSubscriptionForm


@login_required
def saque(request):
    # Check if the form is being submited by the user
    if request.method == 'POST':
        # If the submit button was the one from withdraw form
        if 'withdraw-submit' in request.POST:

            # Bind the form data to a Model Form
            withdraw = WithdrawForm(request.POST, request.FILES)

            if withdraw.is_valid():
                print('Foi!')
                withdraw.save()
                return HttpResponseRedirect('/historico/')

            # Clean the cached data from the event subscription form
            event_subscription = EventSubscriptionForm()

        elif 'event-submit' in request.POST:

            # Bind the form data to an Model Form
            event_subscription = EventSubscriptionForm(request.POST, request.FILES)

            if event_subscription.is_valid():
                event_subscription.save()
                return HttpResponseRedirect('/historico/')

            # Clean the cached data from the withdraw form
            withdraw = WithdrawForm()

    #If it's a GET request
    else:
        # Create a clean new form
        withdraw = WithdrawForm()
        event_subscription = EventSubscriptionForm()

    return render(
        request,
        'shell/app_shell.html',
        {
            'is_withdraw': True,
            'title': 'Saque',
            'transaction' : withdraw,
            'groupTransaction' : event_subscription,
            'users' : User.objects.all()
        }
    )
