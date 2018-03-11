from django import forms
from varys.models import Transaction

#To get all users and list as "who_did_it"
from django.contrib.auth.models import User

#To get all boxes
from varys.models import Box,GroupTransaction

#That's a custom library made by @Marcos Costa Santos
from varys.choices import who_did,which_box

class EventForm(forms.ModelForm):
    name = forms.CharField()
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
    who_paid = forms.CheckboxInput()
    justification = forms.CharField(widget=forms.Textarea(attrs={'class':'materialize-textarea'}))
    its_type = forms.CharField(widget=forms.HiddenInput(attrs={'readonly':True}),
                                initial='Evento')
    class Meta:
        model = GroupTransaction
        fields = ('name','justification','value', 'date','who_paid','its_type','receipt')
        widgets = {
            'who_paid': forms.CheckboxSelectMultiple()
        }

class WithdrawForm(forms.ModelForm):

    value = forms.DecimalField()
    justification = forms.CharField(widget=forms.Textarea(attrs={'class':'materialize-textarea'}))
    receipt = forms.FileField(required=False,widget=forms.ClearableFileInput(attrs={'multiple': True}))
    its_type = forms.CharField(widget=forms.HiddenInput(attrs={'readonly':True}), initial='Saque')
    who_did_it = forms.ChoiceField(choices=who_did())
    origin = forms.ChoiceField(choices=which_box())

    class Meta:
        model = Transaction
        fields = ('value','justification','who_did_it','origin','receipt', 'its_type')
