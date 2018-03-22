from django.shortcuts import render
from django.contrib.auth.decorators import login_required
from django.http import HttpResponseRedirect

from transfer.forms import TransferenceForm

# Create your views here.
@login_required
def transferencia(request):
    # Check if the form is being submited by the user
    if request.method == 'POST':
        # Bind the form data to a Model Form
        transference = TransferenceForm(request.POST)
        if transference.is_valid():
            transference.save()
            return HttpResponseRedirect('/historico/')
        else:
            print(transference.errors)
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
