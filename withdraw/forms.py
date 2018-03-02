from django import forms
from varys.models import Transaction

class WithdrawForm(forms.Form):

    value = forms.DecimalField()
    justification = forms.CharField(widget=forms.Textarea(attrs={'class':'materialize-textarea'}))
    receipt = forms.FileField(widget=forms.ClearableFileInput(attrs={'multiple': True}))

    class Meta:
        model = Transaction
        fields = ('value','justification','receipt')

    # def clean_value(self):
    #     self.cleaned_data.get('value')
    #     # validators=[
    #     #         MaxValueValidator(16000,"Valor Alto demais."),
    #     #         MinValueValidator(0.05, "Valor Baixo demais."),
    #     #         DecimalValidator(5,2,3)
    #     #     ]
