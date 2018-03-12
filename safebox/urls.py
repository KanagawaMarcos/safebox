"""safebox URL Configuration

The `urlpatterns` list routes URLs to views. For more information please see:
    https://docs.djangoproject.com/en/2.0/topics/http/urls/
Examples:
Function views
    1. Add an import:  from my_app import views
    2. Add a URL to urlpatterns:  path('', views.home, name='home')
Class-based views
    1. Add an import:  from other_app.views import Home
    2. Add a URL to urlpatterns:  path('', Home.as_view(), name='home')
Including another URLconf
    1. Import the include() function: from django.urls import include, path
    2. Add a URL to urlpatterns:  path('blog/', include('blog.urls'))
"""
from django.contrib import admin
from django.urls import path,include

#static files
from django.conf import settings
from django.conf.urls.static import static


import deposit.views    #Página Deposito
import metas.views      #Página Metas
import transfer.views   #Página Transferência
import varys.views      #Página Histórico e Home(Redireciona Login)
import withdraw.views   #Página Saque

urlpatterns = [
    path('', varys.views.redirect_login, name='home'),
    path('contas/', include('django.contrib.auth.urls'), name='login'),
    path('admin/', admin.site.urls, name='admin'),
    path('admin/', varys.views.admin, name='admin-redirect'),
    path('contas/sair', varys.views.sair, name='sair'),
    path('historico/', varys.views.historico, name='historico'),
    path('deposito/', deposit.views.deposito, name='deposito'),
    path('saque/', withdraw.views.saque, name='saque'),
    path('metas/', metas.views.metas, name='metas'),
    path('transferencia/', transfer.views.transferencia, name='transferencia'),
]


if settings.DEBUG:
    urlpatterns += static(settings.STATIC_URL, document_root=settings.STATIC_ROOT)
    urlpatterns += static(settings.MEDIA_URL, document_root=settings.MEDIA_ROOT)
