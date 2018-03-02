from django.db import models

#created_date attibute needs it
from django.utils import timezone

# This Model is a super class "Financial Transaction"
class Transaction(models.Model):
	who_did_it = models.CharField(max_length=257, default='')
	value = models.DecimalField(max_digits=6, decimal_places=2)
	justification = models.CharField(max_length=257, default='')
	#created_at = models.DateTimeField(auto_now_add=True)
	created_date = models.DateTimeField(default=timezone.now)

	#Separe essas duas linhas em classes separadas por herança
	origin = models.CharField(max_length=257, default='', blank=True, null=True)
	destination = models.CharField(max_length=257, default='', blank=True, null=True)
	receipt = models.FileField(upload_to='comprovantes', blank=True, null=True)
	its_type = models.CharField(max_length=257, default='')

	def __str__(self):
		#INCOMPLETOreturn "%s fez a movimentação financeira de %d para %s no dia " % (self.name, self.restaurant)
		return "%s - %s" % (self.justification , self.who_did_it)
