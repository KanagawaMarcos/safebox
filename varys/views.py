from django.shortcuts import render,redirect
from django.contrib.auth.decorators import login_required
from django.contrib.auth import authenticate, login, logout

# It's required to querie two o more objects into one list
from itertools import chain

#Import all types of withdraw transactions
from withdraw.models import Withdraw,EventSubscription
#Import all types of deposit transactions
from deposit.models import Deposit,MonthlyDeposit
#Import all types of trasnference transactions
from transfer.models import Transference
#Import all boxes
from varys.models import Box

from django.shortcuts import get_object_or_404

from withdraw.models import Withdraw,EventSubscription
from deposit.models import Deposit,MonthlyDeposit
from transfer.models import Transference

from django.views.generic.edit import DeleteView

class DepositDelete (DeleteView):
    model = Deposit
    success_url = '/box/historico/'

class TransferenceDelete (DeleteView):
    model = Transference
    success_url = '/box/historico/'

class MonthlyDepositDelete (DeleteView):
    model = MonthlyDeposit
    success_url = '/box/historico/'

class WithdrawDelete (DeleteView):
    model = Withdraw
    success_url = '/box/historico/'

class EventSubscriptionDelete (DeleteView):
    model = EventSubscription
    success_url = '/box/historico/'

@login_required
def admin(request):
    return redirect('admin-redirect')

@login_required
def sair(request):
    logout(request)
    return redirect('login')

@login_required
def historico(request):
    # Those 3 lines are queries of all transactions
    deposits = chain(Deposit.objects.all(), MonthlyDeposit.objects.all())
    withdraws = chain(Withdraw.objects.all(), EventSubscription.objects.all())
    transferences = Transference.objects.all()

    # Then all transactions are sorted by their atribute "created_at"
    transactions = sorted(
        chain(deposits,withdraws,transferences),
        key=lambda instance: instance.created_at
    )

    # Get all boxes to show their values in interface
    boxes = Box.objects.all()

    return render(
        request,
        'shell/app_shell.html',
        {
            'is_varys': True,
            'transactions': transactions,
            'boxes':boxes,
            'title': 'Histórico'
        }
    )

def redirect_login(request):
    return redirect('login')
