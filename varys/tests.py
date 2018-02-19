from django.test import TestCase
from varys.models import Transaction

from random
# Create your tests here.
class Transaction_Model_Test(TestCase):

    def setUp(self):
        deposit = Transaction.objects.create(
            who_did_it='Generic_Deposit',
            value=0,
            justification='Testing some deposits',
            its_type='Deposito',
        )
    def test_deposits(self):

        #Test if only values greater or equal to 0 are valid
        positive_deposit = Transaction.objects.get(who_did_it='Generic_Deposit')
        positive_deposit.value = random.uniform(0.05 , 16000.0)
        self.assertEqual(positive_deposit.value > 0.0 , True)
