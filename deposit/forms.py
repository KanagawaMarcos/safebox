from django import forms
from withdraw.forms import WithdrawForm
from varys.choices import who_did,which_box
from varys.models import Transaction

class DepositForm(WithdrawForm):
    its_type = forms.CharField(widget=forms.HiddenInput(attrs={'readonly':True}), initial='Depósito')
    destination = forms.ChoiceField(choices=which_box())

    class Meta(WithdrawForm.Meta):
        model = Transaction
        exclude = ('origin',)
        fields = ('its_type','destination')
