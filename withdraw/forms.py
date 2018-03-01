from django import forms
from varys.models import Transaction

class WithdrawForm(forms.Form):
    value = forms.DecimalField(label='Valor do Saque')

    class Meta:
        model = Transaction
        fields = ('value')
