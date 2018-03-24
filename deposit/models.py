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

	def __str__(self):
		return "%s no valor de R$%s" % (self.justification, self.value)

	class Meta:
		# Human friendly singular and plural name
		verbose_name = 'Depósito'
		verbose_name_plural = 'Depósitos'

	def save(self,*args,**kwargs):
		boxes = Box.objects.filter(id=self.origin.id)
		for box in boxes:
			box.value = box.value + self.value
			box.save()
		super().save(*args, **kwargs)  # Call the "real" save() method.

	def delete(self, *args, **kwargs):
		boxes = Box.objects.filter(id=self.origin.id)
		for box in boxes:
			box.value = box.value - self.value
			box.save()
		super().delete(*args, **kwargs)  # Call the "real" save() method.

# An payment that every user should make every month
class MonthlyDeposit (MultipleTransaction):
	# The date that this bill is referent to
	date = models.CharField('Data do pagamento', max_length=32)

	class Meta:
		# Human friendly singular and plural name
		verbose_name = 'Pagamento Mensal Obrigatório'
		verbose_name_plural = 'Pagamentos Mensais Obrigatórios'

	def save(self,*args,**kwargs):
		boxes = Box.objects.filter(name='Geral') #BAD PRATICE

		for box in boxes:
			super().save(*args, **kwargs)  # the transaction must be save before!
			box.value = box.value + (self.value * self.users.count())
			box.save()

	def delete(self, *args, **kwargs):
		boxes = Box.objects.filter(name='Geral') #BAD PRATICE
		for box in boxes:
			box.value = box.value - (self.value*self.users.count())
			box.save()
		super().delete(*args, **kwargs)  # Call the "real" save() method.
