# ÉDEN
---------------------------------


- Visão do projeto - https://www.mindmeister.com/711310006/eventos-art

- Admin - Adicionar eventos - Admin http://admin-eden.cursophprj.com.br/wp-admin/ (login:admin e senha: senha123) - WordPress

- API: http://eden-api.cursophprj.com.br (Diretório /api) - Slim Framework
- APP Entrada: http://eden-app-entrada.cursophprj.com.br (Diretório /app_entrada/www) (Ionic Framework)
- APP Entrada: http://eden-app-cliente.cursophprj.com.br (Diretório /app_cliente/www) (Ionic Framework)
- Site - http://admin-eden.cursophprj.com.br - WordPress
- https://www.facebook.com/experienciaeden


---------------------------------------

Técnologias:

- Mapa mental - https://www.mindmeister.com/711310006/eventos-art
- Slim Framework, ele é um microframework simples com capacidade para desenvolver APIs poderosas
- Conexão PDO para garantir facilidade caso no futuro tenha a necessidade de modificar o banco de dados.
- Mysql (Innodb) para garantir relacionamento com chave estrangeira e transações (commit e rollback)
- Mysql Workbeanch (Para gerar o Diagrama EER e o gerenciamento do banco de dados)
- Designer patterns:
    - Singleton: Na conexão com o Banco de dados.
    - Dao: Para persistência de dados.
    - Rest x MVC
- Ionic Framework
- https://github.com/google/material-design-lite (Material designer do google para documentação do projeto da api - http://eden-api.cursophprj.com.br)
- WordPress para administração dos eventos em todas as plataformas
- Git

---------------------------------------

Performance:
- Configure o .htaccess para armazenar os arquivos assets em cache.
- Vanish cache.
- Minify HTML and any CSS or JS.
