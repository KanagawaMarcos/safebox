from django.shortcuts import render
from django.contrib.auth.decorators import login_required

# Create your views her
@login_required
def metas(request):
    return render(request, 'metas/metas.html', {})
