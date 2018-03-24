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
