from django.test import TestCase
from varys.models import Transaction

# Create your tests here.
class Transaction_Model_Test(TestCase):

    def setUp(self):
        deposit = Transaction.objects.create(
            who_did_it='Positive_Deposit',
            value=10,
            justification='Testing positive values',
            its_type='Deposito',
        )
    def test_positive_deposits(self):
        positive_deposit = Transaction.objects.get(who_did_it='Positive_Deposit')
        self.assertEqual(positive_deposit.value > 0.0 , True)
