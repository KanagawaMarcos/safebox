# Safebox

Um webapp de gerenciamento financeiro do grupo PETComp (UFMA).
Seu objetivo é manter de forma simples um gerenciamento sobre entrada e saída de recurso financeiro do grupo de Ensino e Extensão.

## Como rodar localmente

Instale os pré-requisitos citados abaixo, após isso clone o projeto e entre no repositório.
Abra o seu terminal na pasta do projeto e rode o comando:

```
python manage.py runserver
```

Um servidor local será inicial, para encerra-lo pressione "**Ctrl**" + "**c**".

Acesse o endereço [127.0.0.1:8000](http://127.0.0.1:8000/) no seu navegador e divirta-se.

### Pré-requisitos

* Python 3.0
* Pip
* Django 2.0.2
* Materialize CSS 1.0
* Git

### Instalação

Primeiramente você deve instalar python 3.0. Python é uma linguagem de programação de alto nível, interpretada, de script, imperativa, orientada a objetos, funcional, de tipagem dinâmica e forte. 

```
sudo apt-get install python3
```

Após isso instale o pip. Pip é um sistema de gerenciamento de pacotes usado para instalar e gerenciar pacotes de software em python.

```
sudo apt-get install python3-pip
```
Instale o virtual enviorement.
```
sudo pip3 install virtualenv
```
Vá até onde deseja salvar o projeto e crie uma pasta com um nome qualquer. No caso desse tutorial, o código foi salvo na pasta home de um sistema linux.
```
mkdir ~/safebox-projeto
```
Entre na pasta que você acabou de criar.
```
cd ~/safebox-projeto
```
Então *crie um ambiente virtual* para que as dependências utilizadas no projeto não entrem em conflito com as suas dependências. Esse comando irá criar um conjunto de arquivos que permitirá você isolar esse webapp do resto do seu computador, impedindo que possíveis erros tragam danos à seus projetos próprios. (Boa prática)
```
virtualenv ambiente-virtual
```
Para ativar o ambiente virtual use o comando:
```
source ambiente-virtual/bin/activate
```
Entre na pasta do seu ambiente virtual 
```
cd ambiente-virtual/
```
Finalmente clone o repositório do github
```
git clone https://github.com/Marcos-Costa/safebox.git
```
Por fim, execute o **pip** para que ele instale automáticamente as demais dependências.
```
pip install -r /safebox/requirements.txt
```
Isso é tudo, o projeto está instalado.

Para roda-lo use entre na pasta do repositório
```
cd safebox/
```
Execute o seguinte comando:
```
python3 manage.py runserver
```
Acesse o [link](http://127.0.0.1:8000/) para usar o webapp. Ou pressione **Ctrl** + **C** no seu terminal para encerrar o webapp.

### Testes

Testes são automátizados e executados no ambiente do [CircleCI](http://circleci.com/).
Caso você possua algum conhecimento sobre *Unit Test* você pode executar os testes
localmente utilizado o comando

```
python3 manage.py test
```

## Deploy

O deploy da aplicação também é automatizada utilizando [CircleCI](http://circleci.com/). Toda vez que há um merge/commit no branch master (que é um branch protegido), um webhook é executado e o deploy automatizado acontece no servidor.
Para configurar o deploy em seu servidor, leia a [documentação](https://circleci.com/docs/1.0/introduction-to-continuous-deployment/) do CircleCI sobre arquivos de configuração YAML.
O arquivo de configuração se encontra no sub diretório **.circleci/config.yml**

## Tecnologias Usadas

* [Django](https://www.djangoproject.com/) - Back-end framework 
* [Materialize](http://materializecss.com/) - Front-end framework
* [CircleCI](https://circleci.com/) - Continuos Integration 
* [Javascript](https://www.javascript.com/) e [Python](https://www.python.org/) - Linguagens de programação
* [Jquery](https://jquery.com/) - Bibliotecas
* YAML - Linguagem de serialização
* HTML e CSS - Linguagem de marcação

## Versionamento

Foi usado o [Git](https://git-scm.com/) para versionamento.

## Autores

* **Marcos Costa Santos**

Veja também a lista de [contribuidores](https://github.com/Marcos-Costa/safebox/graphs/contributors) que participaram do projeto.

## License

Esse projeto usa a licença MIT License - veja o arquivo de licença [LICENSE.md](https://github.com/Marcos-Costa/safebox/blob/master/LICENSE) para mais detalhes.
