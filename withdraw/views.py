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

# Create your views here.
@login_required
def saque(request):
    #Se esse view está recebendo um POST, ou seja
    #já foi renderizado e o formulário completado
    if request.method == 'POST':
        #Copia os dados de transação enviados via método POST
        #E cria um formulário novo com eles
        form = WithdrawForm(request.POST, request.FILES)
        groupForm = EventForm(request.POST, request.FILES)
        #Se os dados foram preenchido corretamente
        if request.POST['its_type'] == 'Saque':
            if form.is_valid():
                form.save()
                return HttpResponseRedirect('/historico/')
        else:
            print("lets see")
            if groupForm.is_valid():
                groupForm.save()
                return HttpResponseRedirect('/historico/')
            else:
                return HttpResponseRedirect('/erro/'+str(groupForm.errors.as_data()))


    #Se for a primeira vez que a página é renderizada
    else:
        #Cria uma transação vazia para ser preenchida
        form = WithdrawForm()
        groupForm = EventForm()
    return render(request, 'shell/app_shell.html',{
                     'is_withdraw': True,
                     'title': 'Saque',
                     'transaction': form,
                     'groupTransaction':groupForm,
                     'users':User.objects.all()
                     })
