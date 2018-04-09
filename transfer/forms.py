from django import forms
from django.contrib.auth.models import User

# Get all safeboxes
from varys.models import Box
# Get the base model for each form
from varys.forms import MultipleTransactionForm,BasicInfoForm
# Get the base form for each form
from transfer.models import Transference

# Allows to check if a safebox has money to do a transfer
from django.core.exceptions import ValidationError
from django.utils.translation import gettext_lazy as _

class TransferenceForm(BasicInfoForm):

    origin = forms.ModelChoiceField(Box.objects.all())
    destination = forms.ModelChoiceField(Box.objects.all())

    def clean(self):

        # Don't allow a transference if there isn't money available.
        if self.cleaned_data['value'] > self.cleaned_data['origin'].value :
            raise ValidationError(_('A caixinha não tem esta quantia em dinheiro.'))

    class Meta:
        model = Transference
        fields = ('value','origin','destination')
