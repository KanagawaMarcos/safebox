from django.db import models
from varys.models import SingleTransaction

class Transfer (SingleTransaction):
	#From which safebox the money comes from
	origin = models.ForeignKey(
		Box,
		on_delete = models.SET_NULL,
		null = True
	)

	#To which safebox the money goes to
	destination = models.ForeignKey(
		Box,
		on_delete = models.SET_NULL,
		null = True
	)

    class Meta:
    	# Human friendly singular and plural name
    	verbose_name = 'Transferência'
    	verbose_name_plural = 'Transferências'
