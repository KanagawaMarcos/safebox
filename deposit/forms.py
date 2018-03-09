from django import forms
from withdraw.forms import WithdrawForm
from varys.choices import who_did,which_box
from varys.models import Transaction

class DepositForm(WithdrawForm):
    its_type = forms.CharField(widget=forms.HiddenInput(), initial='Depósito')

    class Meta(WithdrawForm.Meta):
        model = Transaction
        fields = ('its_type',)
