from django.shortcuts import render
from django.contrib.auth.decorators import login_required
from django.http import HttpResponseRedirect

from transfer.forms import TransferenceForm
from varys.models import Box

# Create your views here.
@login_required
def transferencia(request):
    # Check if the form is being submited by the user
    if request.method == 'POST':
        # Bind the form data to a Model Form
        transference = TransferenceForm(request.POST)
        if transference.is_valid():
            transference.save()

            #Transfer money between boxes
            origins = Box.objects.filter(name=transference.cleaned_data['origin'].name)
            destinations = Box.objects.filter(name=transference.cleaned_data['destination'].name)

            for destination,origin in zip(destinations,origins):

                origin.value = origin.value - transference.cleaned_data['value']
                destination.value = destination.value + transference.cleaned_data['value']
                origin.save()
                destination.save()
            return HttpResponseRedirect('/historico/')

    else:
        transference = TransferenceForm()

    return render(
        request,
        'shell/app_shell.html',
        {
            'title' : 'Transferência',
            'is_transfer' : True,
            'transaction' : transference
        }
    )
