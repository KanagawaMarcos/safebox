from django.db import models
from django.contrib.auth.models import User

#created_date attibute needs it
from django.utils import timezone
# This Model is a super class "Financial Transaction"
class GroupTransaction(models.Model):
	name = models.CharField(max_length=257, default='')
	who_paid = models.ManyToManyField(User)
	value = models.DecimalField(max_digits=6, decimal_places=2)
	justification = models.CharField(max_length=257, default='')
	#created_at = models.DateTimeField(auto_now_add=True)
	created_date = models.DateTimeField(default=timezone.now)
	date = models.CharField(max_length=257, default='')

	#Separe essas duas linhas em classes separadas por herança
	receipt = models.FileField(upload_to='comprovantes', blank=True, null=True)
	its_type = models.CharField(max_length=257, default='')

	def __str__(self):
		#INCOMPLETOreturn "%s fez a movimentação financeira de %d para %s no dia " % (self.name, self.restaurant)
		if its_type == 'Evento':
			return "Inscrição no evento %s de %s" % (self.name, self.date)
		else:
			return "Depósito mensal de  %s" % (self.date)


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


class Box (models.Model):
	name = models.CharField(max_length=257)
	value = models.DecimalField(max_digits=6, decimal_places=2)

	class Meta:
		verbose_name_plural = "boxes"
	def __str__(self):
		return "%s - R$ %s" %(self.name, self.value)
