from django import forms
from varys.models import Transaction

#To get all users and list as "who_did_it"
from django.contrib.auth.models import User

#To get all boxes
from varys.models import Box,GroupTransaction

#That's a custom library made by @Marcos Costa Santos
from varys.choices import who_did,which_box

class TransferForm(forms.ModelForm):

    its_type = forms.CharField(widget=forms.HiddenInput(attrs={'readonly':True}), initial='Transferencia')
    value = forms.DecimalField()
    origin = forms.ChoiceField(choices=which_box())
    destination = forms.ChoiceField(choices=which_box())

    class Meta:
        model = Transaction
        fields = ('value','origin','destination', 'its_type')
