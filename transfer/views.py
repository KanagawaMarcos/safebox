from django.shortcuts import render
from django.contrib.auth.decorators import login_required
from varys.models import Transaction
from .forms import TransferForm
from django.http import HttpResponseRedirect

# Create your views here.
@login_required
def transferencia(request):
    if request.method == 'POST':
        form = TransferForm(request.POST)
        if form.is_valid():
            form.save()
            HttpResponseRedirect('/historico/')
    else:
        form = TransferForm()
    return render(request, 'shell/app_shell.html', {
        'title':'Transferência',
        'is_transfer':True,
        'transaction':form
        })
