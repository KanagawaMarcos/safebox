from django.shortcuts import render
from django.contrib.auth.decorators import login_required
from django.http import HttpResponseRedirect
from django.contrib.auth.models import User


from varys.models import Box
from withdraw.forms import WithdrawForm,EventSubscriptionForm


@login_required
def saque(request, evento=False):
    # Check if the form is being submited by the user
    if request.method == 'POST':
        # If the submit button was the one from withdraw form
        if 'withdraw-submit' in request.POST:

            # Bind the form data to a Model Form
            withdraw = WithdrawForm(request.POST, request.FILES)

            if withdraw.is_valid():
                #Save the action in the database
                withdraw.save()

                #Removes the money from the box
                boxes = Box.objects.filter(name=withdraw.cleaned_data['origin'].name)
                for box in boxes:
                    box.value = box.value - withdraw.cleaned_data['value']
                    box.save()

                return HttpResponseRedirect('/box/historico/')

            # Clean the cached data from the event subscription form
            event_subscription = EventSubscriptionForm()

        elif 'event-submit' in request.POST:

            # Bind the form data to an Model Form
            event_subscription = EventSubscriptionForm(request.POST, request.FILES)

            if event_subscription.is_valid():
                event_subscription.save()

                #Removes the money from the box
                boxes = Box.objects.filter(name='Geral')#Bad Pratice!!!!
                for box in boxes:
                    total = event_subscription.cleaned_data['value']*event_subscription.cleaned_data['users'].count()
                    box.value = box.value - total
                    box.save()

                return HttpResponseRedirect('/box/historico/')

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
            'boxes':Box.objects.all(),
            'groupTransaction' : event_subscription,
            'users' : User.objects.all(),
            'is_event': evento,
        }
    )
@login_required
def evento(request):
    return saque(request, evento=True)
