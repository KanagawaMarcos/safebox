from django.shortcuts import render
from django.contrib.auth.decorators import login_required

# from varys.models import Transaction
from .forms import WithdrawForm

#To get all users and list as "who_did_it"
from django.contrib.auth.models import User

#Import the safebox
from varys.models import Box

# Create your views here.
@login_required
def saque(request):
    #Se esse view está recebendo um POST, ou seja
    #já foi renderizado e o formulário completado
    if request.method == 'POST':
        #Copia o objeto de transação enviados via método POST
        transaction = WithdrawForm(request.POST)

        #Se os dados foram preenchido corretamente
        if transaction.is_valid():
            #return HttpResponseRedirect('/thanks/')
            return render(request,'debug.html', {'transaction' : transaction})
    #Se for a primeira vez que a página é renderizada
    else:
        #Cria uma transação vazia para ser preenchida
        transaction = WithdrawForm()

    return render(request, 'shell/app_shell.html',
                    {'is_withdraw': True,
                     'title': 'Saque',
                     'transaction': transaction,
                     'users_list': User.objects.all(),
                     'boxes' : Box.objects.all()
                     })
