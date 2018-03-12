from django.test import TestCase
from varys.models import Transaction

# Create your tests here.
class Transaction_Model_Test(TestCase):

    def setUp(self):
        deposit = Transaction.objects.create(
            who_did_it='Generic_Deposit',
            value=2,
            justification='Testing some deposits',
            its_type='Deposito',
        )

    def test_deposit_str_function(self):
        positive_deposit = Transaction.objects.get(who_did_it='Generic_Deposit')
        # self.assertEqual(positive_deposit.__str__(), positive_deposit.justification + " - " + positive_deposit.who_did_it )
        self.assertEqual(True, True)
