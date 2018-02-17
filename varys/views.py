from django.shortcuts import render
from .models import Transaction

# Create your views here.
def historico(request):
    transactions = Transaction.objects.all()
    return render(request, 'varys/historico.html',{'transactions':transactions})
