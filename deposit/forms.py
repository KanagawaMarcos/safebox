from django import forms
from django.contrib.auth.models import User

# Get all safeboxes
from varys.models import Box
# Get the base model for each form
from varys.forms import MultipleTransactionForm,BasicInfoForm
# Get the base form for each form
from deposit.models import Deposit,MonthlyDeposit

# Allows to check if a deposit is invalid
from django.core.exceptions import ValidationError
from django.utils.translation import gettext_lazy as _

class DepositForm(BasicInfoForm):

    user = forms.ModelChoiceField(User.objects.all())
    destination = forms.ModelChoiceField(Box.objects.all())

    def clean(self):

        # Don't allow invalid deposit value.
        if self.cleaned_data['value'] <= 0 :
            raise ValidationError(_('Valor do depósito inválido.'))

    class Meta:
        model = Deposit
        fields = ('value','justification','user','destination','receipt')


class MonthlyDepositForm(MultipleTransactionForm):

    class Meta:
        model = MonthlyDeposit
        fields = ('value', 'date','users','justification')
        widgets = {
            'users': forms.CheckboxSelectMultiple()
        }
