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

	def __str__(self):
		return "%s no valor de R$%s na data %s" % (self.destination, self.value, self.date)

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
	user = models.ForeignKey(User)

	class Meta:
		abstract = True

class MultipleTransactions(models.Model):
	info = models.OneToOneField(
		Info,
		on_delete = models.CASCADE,
		primary_key = True
	)

	users = models.ManyToManyField(User)

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
