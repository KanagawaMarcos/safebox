# Django uses this class for mapping your models in your database
from django.db import models

# Any abstract Transaction class needs it for it's atribute "User(s)"
from django.contrib.auth.models import User

# The abstract class "info" needs it for it's atribute "date"
from django.utils import timezone

# An Abstract class containing basic info about any financial object
class Info(models.Model):
	# How much money has or had this instance
	value = models.DecimalField(max_digits=6, decimal_places=2)
	# Why was this instance made
	justification = models.CharField(max_length=257, default='')
	# In what date was this instance created
	date = models.DateTimeField(default=timezone.now)

	class Meta:
		abstract = True

class Box (models.Model):
	info = OneToOneField(
		Info,
		on_delete = models.CASCADE,
		primary_key = True
	)

	class Meta:
		# It makes the django admin panel spell "box" plural correctly
		verbose_name_plural = "boxes"

	#Return a string if it's object is printed ex: print(box)
	def __str__(self):
		return "%s - R$ %s" %(self.name, self.value)

# This is an abstract class containing info about a Transaction made by one user
class SingleTransaction(models.Model):
	info = models.OneToOneField(
		Info,
		on_delete = models.CASCADE,
		primary_key = True
	)
	user = models.OneToOneField(
		User,
		on_delete=models.CASCADE,
		primary_key=True
	)

	class Meta:
		abstract = True
	#Separe essas duas linhas em classes separadas por herança
	# origin = models.CharField(max_length=257, default='', blank=True, null=True)
	# destination = models.CharField(max_length=257, default='', blank=True, null=True)
	# receipt = models.FileField(upload_to='comprovantes', blank=True, null=True)
	# its_type = models.CharField(max_length=257, default='')


	def __str__(self):
		if self.its_type == 'Transferencia':
			return "Transferencia da caixa %s para %s no valor de %s" % (self.origin , self.destination, self.value)
		else:
			return "%s - %s" % (self.justification , self.who_did_it)

	def save(self,*args,**kwargs):
		if self.its_type == 'Saque':
			boxes = Box.objects.filter(name=self.origin)
			for box in boxes:
				cur_value = box.value
				box.update(value=cur_value - box.value)
		elif self.its_type == 'Deposito':
			boxes = Box.objects.filter(name=self.destination)
			for box in boxes:
				cur_value = box.value
				box.update(value=cur_value + box.value)

		elif self.its_type == 'Transferencia':
			#Adiciona o valor ao destino
			current_value = Box.objects.filter(name=self.destination)[0].value
			Box.objects.filter(name=self.destination).update(value=(current_value + self.value))
			#Remove da origem
			current_value = Box.objects.filter(name=self.origin)[0].value
			Box.objects.filter(name=self.origin).update(value=(current_value - self.value))
		super().save(*args, **kwargs)  # Call the "real" save() method.

	def delete(self, *args, **kwargs):
		if self.its_type == 'Saque':
			current_value = Box.objects.filter(name=self.origin)[0].value
			Box.objects.filter(name=self.origin).update(value=(current_value + self.value))
		elif self.its_type == 'Deposito':
			current_value = Box.objects.filter(name=self.destination)[0].value
			Box.objects.filter(name=self.destination).update(value=(current_value - self.value))
		elif self.its_type == 'Transferencia':
			#Adiciona o valor ao destino
			current_value = Box.objects.filter(name=self.destination)[0].value
			Box.objects.filter(name=self.destination).update(value=(current_value - self.value))
			#Remove da origem
			current_value = Box.objects.filter(name=self.origin)[0].value
			Box.objects.filter(name=self.origin).update(value=(current_value + self.value))
		super().delete(*args, **kwargs)  # Call the "real" save() method.

class MultipleTransactions(models.Model):
	info = models.OneToOneField(
		Info,
		on_delete = models.CASCADE,
		primary_key = True
	)

	users = models.ManyToManyField(

	)
	#name = models.CharField(max_length=257, default='')

	created_date = models.DateTimeField(default=timezone.now)
	date = models.CharField(max_length=257, default='')
	#Separe essas duas linhas em classes separadas por herança
	receipt = models.FileField(upload_to='comprovantes', blank=True, null=True)
	its_type = models.CharField(max_length=257, default='')


	def __str__(self):
		#INCOMPLETOreturn "%s fez a movimentação financeira de %d para %s no dia " % (self.name, self.restaurant)
		if self.its_type == 'Evento':
			return "Inscrição no evento %s de %s" % (self.name, self.date)
		else:
			return "Depósito mensal de  %s" % (self.date)

	def save(self,*args,**kwargs):
		if self.its_type == 'Evento':#Inscrição em evento
			current_value = Box.objects.filter(name='Geral')[0].value
			super().save(*args, **kwargs)  # Call the "real" save() method.
			Box.objects.filter(name='Geral').update(value=(current_value - self.value*self.who_paid.count()))
		else:
			current_value = Box.objects.filter(name='Geral')[0].value
			super().save(*args, **kwargs)  # Call the "real" save() method.
			Box.objects.filter(name='Geral').update(value=(current_value + self.value*self.who_paid.count()))


	def delete(self, *args, **kwargs):
		if self.its_type == 'Evento':#Inscrição em evento
			current_value = Box.objects.filter(name='Geral')[0].value
			Box.objects.filter(name='Geral').update(value=(current_value + self.value))
		else:
			current_value = Box.objects.filter(name='Geral')[0].value
			Box.objects.filter(name='Geral').update(value=(current_value - self.value))
		super().delete(*args, **kwargs)  # Call the "real" save() method.



class MonthlyPayment (models.Model):
	info = models.GroupTransaction(
		Transaction,
		on_delete=models.CASCADE,
		primary_key=True
	)

class Withdraw(models.Model):
	#Basic information about such as: User, value, justification ...
	info = models.OneToOneField(
		Transaction,
		on_delete=models.CASCADE,
		primary_key = True
	)

	#From which safebox the money comes from
	origin = models.OneToOneField(
		Box,
		on_delete = models.CASCADE,
		primary_key = True
	)

	#A file as receipt, it can be an image or a pdf. This is optional
	receipt = models.FileField(upload_to='comprovantes', blank=True, null=True)

# This Model is a super class "Financial Transaction"
