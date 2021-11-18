# ITS - Rio
Desenvolvimento do tema ITS - Rio

# Desenvolvimento

### Editor
Para o desenvolvimento recomenda-se a utilização do editor Visual Studio Code com as seguintes extenções:

- EditorConfig for VS Code
- PHP Intelephense
- Docker
- Beautify
- Beautify css/sass/scss/less
- GitLens
- ...

### Requisitos
Para o desenvolvimento é requisito ter instaladas ao menos as seguintes ferramtas:

- **Git**
- **Docker** e **Docker Compose** - Docker é a ferramenta recomendada para desenvolver localmente. Para instalá-lo siga [estas instruções](https://docs.docker.com/install/#supported-platforms).
- **node** e **npm**

### Clonando o repositório
Clone o repositório e seus submódulos recursivamente:

```
$ git clone git@github.com:itsriodejaneiro/itsrio-site.git --recursive
```

### Subindo o ambiente
Abra outro terminal e na raíz do repositório execute o comando abaixo:

```
docker-compose up
```
Acesse em http://localhost

### Importar um dump de banco de dados
Se você tem um dump de banco de dados `.sql` ou `.sql.gz`, para importá-lo em sua versão local, copie o arquivo para `compose/local/mariadb/data` e execute:

```
docker-compose down -v (-v para apagar os dados do mariadb)
docker-compose up 
```

# Instalando plugins e temas

### Copiando arquivos para dentro do repositório
O conteúdo de `wp-content` está excluído do versionamento por padrão. Para adicionar seu plugin ou tema como parte do repositório, você deve colocá-los nas pastas `plugins` ou `themes` que estão na raiz do repositório.