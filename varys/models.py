from django.db import models
from django.contrib.auth.models import User

#created_date attibute needs it
from django.utils import timezone
class Box (models.Model):
	name = models.CharField(max_length=257)
	value = models.DecimalField(max_digits=6, decimal_places=2)

	class Meta:
		verbose_name_plural = "boxes"
	def __str__(self):
		return "%s - R$ %s" %(self.name, self.value)

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
		if self.its_type == 'Transferencia':
			return "Transferencia da caixa %s para %s no valor de %s" % (self.origin , self.destination, self.value)
		else:
			return "%s - %s" % (self.justification , self.who_did_it)

	def save(self,*args,**kwargs):
		if self.its_type == 'Saque':
			current_value = Box.objects.filter(name=self.origin)[0].value
			Box.objects.filter(name=self.origin).update(value=(current_value - self.value))
		elif self.its_type == 'Deposito':
			boxes = Box.objects.filter(name=self.destination)
			for box in boxes:
				cur_value = box.value
				box.update(value=cur_value + box.value)
				#Box.objects.filter(name=self.destination).update(value=(current_value + self.value))

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
