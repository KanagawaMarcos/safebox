from django.db import models
from varys.models import SingleTransaction,MultipleTransaction,Box

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

	def save(self,*args,**kwargs):
		boxes = Box.objects.filter(id=self.origin.id)
		for box in boxes:
			box.value = box.value - self.value
			box.save()
		super().save(*args, **kwargs)  # Call the "real" save() method.

	def delete(self, *args, **kwargs):
		boxes = Box.objects.filter(id=self.origin.id)
		for box in boxes:
			box.value = box.value + self.value
			box.save()
		super().delete(*args, **kwargs)  # Call the "real" save() method.


# Model for every time there's a group subscription in some event
class EventSubscription (MultipleTransaction):

	# The actual name of the event
	name = models.CharField('Nome Do Evento', max_length=64)

	# The date that this will happen
	date = models.CharField('Data do Evento', max_length=32)

	class Meta:
		# Human friendly singular and plural name
		verbose_name = 'Inscrição em evento'
		verbose_name_plural = 'Inscrições em eventos'

	def save(self,*args,**kwargs):
		boxes = Box.objects.filter(name='Geral') #BAD PRATICE

		for box in boxes:
			super().save(*args, **kwargs)  # the transaction must be save before!
			box.value = box.value - (self.value * self.users.count())
			box.save()


	def delete(self, *args, **kwargs):
		boxes = Box.objects.filter(name='Geral') #BAD PRATICE
		for box in boxes:
			box.value = box.value + (self.value*self.users.count())
			box.save()
		super().delete(*args, **kwargs)  # Call the "real" save() method.
