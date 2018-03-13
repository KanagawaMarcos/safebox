# Django uses this class for mapping your models in your database
from django.db import models

# Any abstract Transaction class needs it for it's atribute "User(s)"
from django.contrib.auth.models import User

# The abstract class "info" needs it for it's atribute "date"
from django.utils import timezone

# An Abstract class containing basic info about any financial object
class Info (models.Model):
	# How much money has or had this instance
	value = models.DecimalField('Valor', max_digits=6, decimal_places=2)
	# Why was this instance made
	justification = models.CharField('Justificativa', max_length=257, default='')
	# In what date was this instance created
	created_at = models.DateTimeField('Data de criação', default=timezone.now)

	class Meta:
		abstract = True
		verbose_name = 'Informações'

	def __str__(self):
		return "%s no valor de R$%s na data %s" % (self.destination, self.value, self.date)

# A Abstract class representing the any safebox or account
class Box (Info):
	#The label for this safebox
	name = models.CharField('Nome', max_length=255)

	class Meta:
		# Human friendly singular and plural name
		verbose_name = 'Caixinha'
		verbose_name_plural = 'Caixinhas'

	#Return a string if it's object is printed ex: print(box)
	def __str__(self):
		return "%s - R$ %s" %(self.name, self.value)

# An abstract class containing info about a Transaction made by one user
class SingleTransaction (Info):
	# The user related to this transaction
	user = models.ForeignKey(
		User,
		on_delete = models.SET_NULL,
		blank = True,
		null = True
	)

	#A file as receipt, it can be an image or a pdf. This is optional
	receipt = models.FileField(
		'Comprovante(s)',
		upload_to='comprovantes',
		blank=True,
		null=True
	)

	class Meta:
		# Make this class an Abstract class
		abstract = True
		# Human friendly singular and plural name
		verbose_name = 'Transação'
		verbose_name_plural = 'Transações'

# An abstract class containing info about a Transaction made by multiple users
class MultipleTransaction (Info):
	# All users that paid the the monthly bill
	users = models.ManyToManyField(User)

	#A file as receipt, it can be an image or a pdf. This is optional
	receipt = models.FileField(
		'Comprovante(s)',
		upload_to='comprovantes',
		blank=True,
		null=True
	)

	class Meta:
		# Make this class an Abstract class
		abstract = True
		# Human friendly singular and plural name
		verbose_name = 'Transação em Grupo'
		verbose_name_plural = 'Transações em Grupo'

# Any withdraw made to any safebox by any user
class Withdraw (SingleTransaction):
	#From which safebox the money comes from
	origin = models.ForeignKey(
		Box,
		on_delete = models.SET_NULL,
		null = True
	)

	class Meta:
		# Human friendly singular and plural name
		verbose_name = 'Saque'
		verbose_name_plural = 'Saques'

# Any deposit made to any safebox by any user
class Deposit (SingleTransaction):
	#To which safebox the money goes to
	destination = models.ForeignKey(
		Box,
		on_delete = models.SET_NULL,
		null = True
	)

	class Meta:
		# Human friendly singular and plural name
		verbose_name = 'Depósito'
		verbose_name_plural = 'Depósitos'

# An payment that every user should make every month
class MonthlyDeposit (MultipleTransaction):
	# The date that this bill is referent to
	date = models.CharField('Data do pagamento', max_length=32)

	class Meta:
		# Human friendly singular and plural name
		verbose_name = 'Pagamento Mensal Obrigatório'
		verbose_name_plural = 'Pagamentos Mensal Obrigatórios'

class EventSubscription (MultipleTransaction):
	# The date that this will happen
	date = models.CharField('Data do Evento', max_length=32)

	class Meta:
		# Human friendly singular and plural name
		verbose_name = 'Inscrição em evento'
		verbose_name_plural = 'Inscrições em eventos'
