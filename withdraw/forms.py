from django import forms
from varys.models import Transaction

#To get all users and list as "who_did_it"
from django.contrib.auth.models import User

class WithdrawForm(forms.Form):

    value = forms.DecimalField()
    justification = forms.CharField(widget=forms.Textarea(attrs={'class':'materialize-textarea'}))
    #receipt = forms.FileField(widget=forms.ClearableFileInput(attrs={'multiple': True}))

    #Get all users from database
    all_users = User.objects.all()
    #Empty tuple of tuples
    users_options = ()
    #loop throught all users and get their names
    for cur_user in all_users:
        if not cur_user.groups.filter(name='Administradores').exists():
            users_options += ((cur_user.get_full_name(), cur_user.get_full_name()),)

    who_did_it = forms.ChoiceField(choices=users_options)

    class Meta:
        model = Transaction
        fields = ('value','justification','who_did_it')
