from django import forms
from django.core.validators import MaxValueValidator
from django.contrib.auth.models import User

# Get all safeboxes
from varys.models import Box
# Get the base model for each form
from withdraw.models import Withdraw,EventSubscription

class WithdrawForm(forms.ModelForm):

    value = forms.DecimalField(widget=forms.NumberInput(attrs={
        'min':'0.05',
        'max':'16000',
        'step':'any',
        'class':'validate'
    }),
        validators=[
            MaxValueValidator(16000,message='Valor Alto demais')
        ]
    )
    justification = forms.CharField(widget=forms.Textarea(attrs={
        'class':'materialize-textarea'
        }),
        max_length=255
    )

    receipt = forms.FileField(required=False,widget=forms.ClearableFileInput(attrs={'multiple': True}))

    user = forms.ModelChoiceField(User.objects.all())
    origin = forms.ModelChoiceField(Box.objects.all())

    class Meta:
        model = Withdraw
        fields = ('value','justification','receipt','user','origin')


class EventForm(forms.ModelForm):
    name = forms.CharField(max_length=46)
    value = forms.DecimalField(widget=forms.NumberInput(attrs={
        'min':'0.05',
        'max':'16000',
        'step':'any',
        'class':'validate'
    }),
        validators=[
            MaxValueValidator(16000,message='Valor Alto demais')
        ]
    )
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
    justification = forms.CharField(widget=forms.Textarea(attrs={
        'class':'materialize-textarea'
        }),
        max_length=255
    )
    its_type = forms.CharField(widget=forms.HiddenInput(attrs={'readonly':True}),
                            initial='Evento')

    class Meta:
        model = GroupTransaction
        fields = ('name','justification','value', 'date','who_paid','its_type','receipt')
        widgets = {
            'who_paid': forms.CheckboxSelectMultiple()
        }
