from django.db import models
import datetime

# Create your models here.
class Transaction(models.Model):
	value = models.DecimalField(max_digits=6, decimal_places=2)
	justification = models.CharField(max_length=257)
	#date = models.DateField(_(Date), default=datetime.date.today)
	#date = models.DateField(_("Date"), auto_now_add=True)
	user = models.ForeignKey(User)

	def __str__(self):
		return self.justification + " ( R$ " + str(value) +" ) ( " + str(date)+" )"