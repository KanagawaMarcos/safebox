from django import forms
from django.contrib.auth.models import User

# Get all safeboxes
from varys.models import Box
# Get the base model for each form
from withdraw.models import Withdraw,EventSubscription
# Get the base form for each form
from varys.forms import MultipleTransactionForm,BasicInfoForm

# Allows to check if a safebox has money to do a withdraw
from django.core.exceptions import ValidationError
from django.utils.translation import gettext_lazy as _

class WithdrawForm(BasicInfoForm):

    user = forms.ModelChoiceField(User.objects.all())
    origin = forms.ModelChoiceField(Box.objects.all())

    def clean(self):

        # Don't allow withdraw if there isn't money available.
        if self.cleaned_data['value'] > 0 and (self.cleaned_data['origin'].value < self.cleaned_data['value']):
            raise ValidationError(_('A caixinha não tem esta quantia em dinheiro.'))

    class Meta:
        model = Withdraw
        fields = ('value','justification','receipt','user','origin')

class EventSubscriptionForm(MultipleTransactionForm):
    name = forms.CharField(max_length=46)


    class Meta:
        model = EventSubscription
        fields = ('name','value','justification', 'date','users','receipt')
        widgets = {
            'users' : forms.CheckboxSelectMultiple()
        }
