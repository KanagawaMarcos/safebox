from django import forms
from withdraw.forms import WithdrawForm
from varys.choices import who_did,which_box
from varys.models import Transaction

class DepositForm(forms.ModelForm):
    value = forms.DecimalField()
    justification = forms.CharField(widget=forms.Textarea(attrs={'class':'materialize-textarea'}))
    receipt = forms.FileField(required=False,widget=forms.ClearableFileInput(attrs={'multiple': True}))
    its_type = forms.CharField(widget=forms.HiddenInput(attrs={'readonly':True}), initial='Deposito')
    who_did_it = forms.ChoiceField(choices=who_did())
    destination = forms.ChoiceField(choices=which_box())

    class Meta:
        model = Transaction
        fields = ('value','justification','who_did_it','destination','receipt', 'its_type')
