from django import forms
from .varys import Transaction

class WithdrawForm( forms.ModelForm ):

    class Meta:
        model = Transaction
        fields = ('value','who_did_it','destination','justification','receipt')
