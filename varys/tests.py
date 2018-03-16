from django.test import TestCase
from deposit.models import Deposit
from varys.models import Box

# Create your tests here.
class Deposit_Model_Test(TestCase):

    def setUp(self):
        deposit = Deposit.objects.create(
            value = 0,
            justification = 'Testing some deposits',
        )

    def test_deposit_str_function(self):
        deposits = Deposit.objects.all()
        for deposit in deposits:
            self.assertEqual(deposit.value , 0)
