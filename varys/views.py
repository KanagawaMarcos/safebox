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

from varys.models import SingleTransaction,MultipleTransaction
from django.shortcuts import get_object_or_404

#It needs to be ADMIN as well
@login_required
def deletar(request, id):
    singleTransactions = SingleTransaction.objects.get(id=id)
    multipleTransactions = MultipleTransaction.objects.get(id=id)

    if request.user.is_superuser:

        if singleTransaction:

            for transaction in singleTransactions:
                transaction.delete()
        elif multipleTransaction:

            for transaction in multipleTransactions:
                transaction.delete()
        else:
            print('Object does not exist!')
    else:
        print('User is not a superuser. Object not deleted!')

    return HttpResponseRedirect('/historico/')

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

    return render(
        request,
        'shell/app_shell.html',
        {
            'is_varys': True,
            'transactions': transactions,
            'title': 'Histórico'
        }
    )

def redirect_login(request):
    return redirect('login')
