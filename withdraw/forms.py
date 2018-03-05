from django import forms
from varys.models import Transaction

class WithdrawForm(forms.Form):

    value = forms.DecimalField()
    who_did_it = forms.CharField()
    destination = forms.CharField()
    justification = forms.CharField(widget=forms.Textarea(attrs={'class':'materialize-textarea'}) )
    receipt = forms.FileField()

    class Meta:
        model = Transaction
        fields = ('value','who_did_it','destination','justification','receipt')

    # def clean_value(self):
    #     self.cleaned_data.get('value')
    #     # validators=[
    #     #         MaxValueValidator(16000,"Valor Alto demais."),
    #     #         MinValueValidator(0.05, "Valor Baixo demais."),
    #     #         DecimalValidator(5,2,3)
    #     #     ]
