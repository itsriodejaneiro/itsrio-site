## ITS - Rio

### Como subir um ambiente dev

1. clonar o repositório e criar a pasta `.tmp` na raiz do projeto

2. executar o script `scripts/init.sh`

3. obter um dump da base e substituir o arquivo `docker/data/base.sql` por ele.

4. alterar o prefixo das tabelas para `wp_` e o nome da base de dados para `wordpress` (compatibilidade com a imagem `montefuscolo/wordpress` do arquivo `docker-compose.yml`)

3. inserir o dominio itsrio.org no seu /etc/hosts

```
127.0.0.1    	itsrio.org
``` 

4. Subir o projeto com o docker-compose

```
docker-compose up
```

