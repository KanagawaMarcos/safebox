from django import forms
from varys.models import Transaction

class WithdrawForm(forms.Form):

    value = forms.DecimalField()
    justification = forms.CharField(widget=forms.Textarea(attrs={'class':'materialize-textarea'}))
    #receipt = forms.FileField(widget=forms.ClearableFileInput(attrs={'multiple': True}))

    class Meta:
        model = Transaction
        fields = ('value','justification')
