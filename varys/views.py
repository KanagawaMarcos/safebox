from django.shortcuts import render,redirect
from .models import Transaction
from django.contrib.auth.decorators import login_required



# Create your views here.
@login_required
def historico(request):
    transactions = Transaction.objects.all()
    # return render(request, 'varys/historico.html', {'transactions':transactions})
    return render(request, 'shell/app_shell.html',
                    {'is_varys': True,
                     'transactions': transactions,
                     'title': 'Histórico'})

def redirect_login(request):
    return redirect('login')
