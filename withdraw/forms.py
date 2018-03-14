from django import forms
from django.core.validators import MaxValueValidator
from django.contrib.auth.models import User

# Get all safeboxes
from varys.models import Box
# Get the base model for each form
from withdraw.models import Withdraw,EventSubscription

class BasicInfoForm(forms.ModelForm):
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
    origin = forms.ModelChoiceField(Box.objects.all())

    class Meta:
        abstract = True

class WithdrawForm(BasicInfoForm):

    user = forms.ModelChoiceField(User.objects.all())

    class Meta:
        model = Withdraw
        fields = ('value','justification','receipt','user','origin')


class EventSubscriptionForm(BasicInfoForm):
    name = forms.CharField(max_length=46)
    date = forms.CharField(widget=forms.TextInput(attrs={
            'class' : 'datepicker picker__input',
            'readonly' : '',
            'tabindex' : '54',
            'aria-haspopup' : 'True',
            'aria-expanded' : 'false',
            'aria-readonly' : 'false',
            'aria-owns' : 'birthdate_root'
            }
        )
    )
    users = forms.MultipleModelChoiceField(User.objects.all())

    class Meta:
        model = EventSubscription
        fields = ('name','value','justification', 'date','users','receipt')
        widgets = {
            'users' : forms.CheckboxSelectMultiple()
        }
