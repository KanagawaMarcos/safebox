import csv
from varys.models import Transaction

def carregar():
    with open("varys.csv") as f:
        reader = csv.reader(f)
        for row in reader:
            tipo = ''
            origem=''
            destino=''
            if row[1] == 'deposito':
                tipo = 'Deposito'
                origem = ''
                destino = 'Caixa Geral'
            else:
                tipo = 'Saque'
                origem = 'Caixa Geral'
                destino = ''
            quem = ''
            if row[3] == 'arthurcst':
                quem = 'Arthur Costa'
            else:
                quem = 'Geraldo Braz'
            created = Transaction()
            created.who_did_it = quem
            created.value = row[2]
            created.justification = row[6]
            created.created_date = row[5]
            created.origin = origem
            created.destination = destino
            created.its_type = tipo
            created.save()
            print(created)
