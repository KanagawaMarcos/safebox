from django import forms
from withdraw.forms import WithdrawForm
from varys.choices import who_did,which_box
from varys.models import Transaction,GroupTransaction

class MonthlyDepositForm(forms.ModelForm):
    value = forms.DecimalField()
    date = forms.CharField(widget=forms.TextInput(attrs={
        'class':'datepicker picker__input',
        'readonly':'',
        'tabindex':'54',
        'aria-haspopup':'True',
        'aria-expanded':'false',
        'aria-readonly':'false',
        'aria-owns':'birthdate_root'
        }))
    who_paid = forms.BooleanField()

    its_type = forms.CharField(widget=forms.HiddenInput(attrs={'readonly':True}),
                                initial='Deposito Mensal')


    class Meta:
        model = GroupTransaction
        fields = ('value', 'date','who_paid','its_type')

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
