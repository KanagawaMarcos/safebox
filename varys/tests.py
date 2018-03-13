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
        deposits = Transaction.objects.all()
        #"%s no valor de R$%s na data %s" % (self.destination, self.value, self.date)
        for deposit in deposits:
            self.assertEqual(deposit.__str__(), deposit.info.destination + ' no valor de R$' + deposit.info.value + ' na data' + deposit.info.date)
