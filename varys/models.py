from django.db import models

# This Model is a super class "Financial Transaction"
class Transaction(models.Model):
	who_did_it = models.CharField(max_length=257, default='Desconhecido')
	value = models.DecimalField(max_digits=6, decimal_places=2, default=-666)
	justification = models.CharField(max_length=257, default='Sem Descrição')
	created_at = models.DateTimeField(auto_now_add=True)

	def __str__(self):
		return self.justification + ' - ' + who_did_it + ' ( R$ ' + str(value) +' ) ( ' + str(date)+' )'
