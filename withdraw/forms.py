from django import forms
from varys.models import Transaction

class WithdrawForm(forms.Form):

    value = forms.DecimalField()
    justification = forms.CharField(widget=forms.Textarea(attrs={'class':'materialize-textarea'}))
    #receipt = forms.FileField(widget=forms.ClearableFileInput(attrs={'multiple': True}))

    #Get all users from database
    all_users = User.objects.all()
    #Make all users name an option
    users_options = (('valor','marcos'),('outra_coisa','helena'))
    who_did_it = forms.ChoiceField(choices=users_options)

    class Meta:
        model = Transaction
        fields = ('value','justification','who_did_it')
