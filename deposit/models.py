from django.db import models

from varys.models import SingleTransaction,MultipleTransaction,Box

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
		verbose_name_plural = 'Pagamentos Mensais Obrigatórios'
