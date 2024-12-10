## API REST con Symfony, PHP y SQLite

Este proyecto implementa una API REST utilizando Symfony como framework backend, PHP como lenguaje de programación y SQLite como base de datos. 
La API permite realizar operaciones CRUD (Crear, Leer, Actualizar y Eliminar) sobre una entidad de “libros” y "usuarios" y está protegida por autenticación JWT.

Tabla de contenidos:

- [Requisitos](#requisitos)
- [Instalación](#instalación)
- [Uso](#uso)
- [Pruebas](#pruebas)
- [Licencia](#licencia)


## Requisitos

Para ejecutar este proyecto, necesitarás tener los siguientes requisitos previos:
- PHP 8.0 o superior
- Composer (para gestionar dependencias)
- Symfony CLI
- SQLite (no requiere instalación adicional, ya que Symfony se conecta a una base de datos SQLite)
- Un cliente HTTP como Postman o Thunder Client para realizar las peticiones a la API.



 ## Instalación
 
 ### 1. Clonar el repositorio en local
  
    git clone https://github.com/SaraCalvente/api_rest_480.git
    cd api_rest_480
  
 ### 2. Instalar dependencias
  
    composer install

 ### 3. Configuración de la base de datos y del archivo .env
  
  El proyecto utiliza SQLite como base de datos, por lo que no es necesario instalar un servidor de base de datos como MySQL o PostgreSQL. 
  Solo necesitas crear el archivo de base de datos en el directorio var/.
  Ejecuta el siguiente comando para crear las tablas necesarias en la base de datos SQLite: 
    
    php bin/console doctrine:schema:create

  En el archivo .env:
  
  	DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db"

  Ejecuta las migraciones para crear las tablas necesarias en la base de datos SQLite:

  	php bin/console doctrine:migrations:migrate	
  
 ### 4. Configuración de JWT
  
  Ejecuta el siguiente comando para generar las claves privadas y públicas necesarias para la autenticación: 
        
     php bin/console lexik:jwt:generate-keypair 
  
  Esto creará dos archivos: config/jwt/private.pem y config/jwt/public.pem.

  Abre .env y asegura que las variables esten configuradas correctamente, remplaza your_secret_passphrase por tu contraseña segura

 ### 5. CONFIGURACIÓN DE LAS RUTAS DE AUTENTICACIÓN
  
  El archivo config/packages/security.yaml contiene la configuración para proteger las rutas con JWT.
  Asegúrate de que la configuración de seguridad esté correctamente definida para que las rutas de la API estén protegidas.

  
  
  ## Uso
 
  ### 1. Arrancar el servidor de Symfony
    
    symfony server:start
    La API estará disponible en http://127.0.0.1:8000

  ### 2. Realizar peticiones API

   La API proporciona las siguientes rutas para interactuar con los “libros”:
   
- GET /libro/get: Obtiene una lista de todos los libros.
- POST /libro/post: Crea un nuevo libro. Necesita los campos titulo, autor, genero, y año_publicacion en el cuerpo de la solicitud.
- PUT /libro/put/{id}: Actualiza un libro existente.
- DELETE /libro/delete/{id}: Elimina un libro por ID.

 #### Y  proporciona las siguientes rutas para interactuar con los “usuarios”:
  
- GET /user/get: Obtiene una usuario de todos los usuarios.
- POST /user/post: Crea un nuevo usuario. Necesita los campos email, nombre, y edad en el cuerpo de la solicitud.
- DELETE /user/delete/{id}: Elimina un usuario por ID.

  ### 3.Ejemplo de autenticación con JWT
    
   Realiza una solicitud POST a /api/login_check con el cuerpo:

    {
    "email": "prueba@sara.com",
    "password": "Password"
    }

  La respuesta será algo como:

    {
      "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9..."
    }
Usar el token JWT para acceder a las rutas protegidas:

Authorization: Bearer <tu_token_aqui> (en postman o ThunderClient)

## Pruebas

Este proyecto incluye pruebas automatizadas utilizando PHPUnit. Puedes ejecutar las pruebas con el siguiente comando:

	php bin/phpunit	

Hay tres pruebas comentadas, aunque no pasen los test, TODOS los metodos funcionan correctamente.

## Licencia

Este proyecto está bajo la licencia MIT.
 
