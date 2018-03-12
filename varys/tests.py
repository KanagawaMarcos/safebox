from django.test import TestCase
from varys.models import Transaction

# Create your tests here.
class Transaction_Model_Test(TestCase):

    def setUp(self):
        deposit = Transaction.objects.create(
            who_did_it='Generic_Deposit',
            value=0,
            justification='Testing some deposits',
            its_type='Deposito',
        )

    def test_deposit_str_function(self):
        deposits = Transaction.objects.filter(who_did_it='Generic_Deposit')
        for deposit in deposits:
            self.assertEqual(deposit.__str__(), deposit.justification + " - " + deposit.who_did_it )
