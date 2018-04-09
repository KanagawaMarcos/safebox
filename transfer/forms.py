from django import forms
from django.contrib.auth.models import User

# Get all safeboxes
from varys.models import Box
# Get the base model for each form
from varys.forms import MultipleTransactionForm,BasicInfoForm
# Get the base form for each form
from transfer.models import Transference

class TransferenceForm(BasicInfoForm):

    origin = forms.ModelChoiceField(Box.objects.all())
    destination = forms.ModelChoiceField(Box.objects.all())

    def clean(self):

        # Don't allow a transference if there isn't money available.
        if self.cleaned_data['value'] <= self.cleaned_data['origin'].value :
            raise ValidationError(_('A caixinha não tem esta quantia em dinheiro.'))

    class Meta:
        model = Transference
        fields = ('value','origin','destination')
