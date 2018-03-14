from django import forms
from django.contrib.auth.models import User

# Get all safeboxes
from varys.models import Box
# Get the base model for each form
from withdraw.models import Withdraw,EventSubscription
# Get the base form for each form
from varys.forms import MultipleTransactionForm,BasicInfoForm


class WithdrawForm(BasicInfoForm):

    user = forms.ModelChoiceField(User.objects.all())
    origin = forms.ModelChoiceField(Box.objects.all())

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
