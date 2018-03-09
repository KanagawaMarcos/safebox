from django.shortcuts import render
from django.contrib.auth.decorators import login_required
from django.http import HttpResponseRedirect

# from varys.models import Transaction
from .forms import WithdrawForm

#To get all boxes and Transactions
from varys.models import Transaction


#Import the safebox
from varys.models import Box

# Create your views here.
@login_required
def saque(request):
    #Se esse view está recebendo um POST, ou seja
    #já foi renderizado e o formulário completado
    if request.method == 'POST':
        #Copia os dados de transação enviados via método POST
        #E cria um formulário novo com eles
        form = WithdrawForm(request.POST, request.FILES)
        #Se os dados foram preenchido corretamente
        if form.is_valid():
            form.cleaned_data['its_type'] = 'Deposito'
            form.save()
            return HttpResponseRedirect('/historico/')
        else:
            return HttpResponseRedirect('/deu-ruim/'+str(form.errors.as_data()))
    #Se for a primeira vez que a página é renderizada
    else:
        #Cria uma transação vazia para ser preenchida
        form = WithdrawForm()

    return render(request, 'shell/app_shell.html',{
                     'is_withdraw': True,
                     'title': 'Saque',
                     'transaction': form,
                     })
