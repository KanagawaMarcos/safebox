from django import forms
from django.contrib.auth.models import User
from django.core.validators import MaxValueValidator

# Get all safeboxes
from varys.models import Box,MultipleTransaction

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

    class Meta:
        abstract = True


class MultipleTransactionForm(BasicInfoForm):

    users = forms.ModelMultipleChoiceField(User.objects.all())

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

    class Meta:
        model = MultipleTransaction
        fields = ('value', 'date','who_paid','its_type')
        widgets = {
            'who_paid': forms.CheckboxSelectMultiple()
        }
