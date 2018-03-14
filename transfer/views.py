from django.shortcuts import render
from django.contrib.auth.decorators import login_required
from varys.models import Transaction
from django.http import HttpResponseRedirect

from transfer.forms import TransferenceForm

# Create your views here.
@login_required
def transferencia(request):
    # Check if the form is being submited by the user
    if request.method == 'POST':
        # Bind the form data to a Model Form
        transference = TransferenceForm(request.POST)
        if form.is_valid():
            form.save()
            return HttpResponseRedirect('/historico/')
    else:
        form = TransferForm()

    return render(
        request,
        'shell/app_shell.html',
        {
            'title' : 'Transferência',
            'is_transfer' : True,
            'transaction' : transference
        }
    )
