from django.shortcuts import render
from .models import Transaction
from django.contrib.auth.decorators import login_required



# Create your views here.
@login_required
def historico(request):
    transactions = Transaction.objects.all()
    return render(request, 'varys/historico.html',{'transactions':transactions})
