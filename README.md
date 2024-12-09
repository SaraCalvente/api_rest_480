**API REST con Symfony, PHP y SQLite**

Este proyecto implementa una API REST utilizando Symfony como framework backend, PHP como lenguaje de programación y SQLite como base de datos. 
La API permite realizar operaciones CRUD (Crear, Leer, Actualizar y Eliminar) sobre una entidad de “libros”, y está protegida por autenticación JWT.

*Requisitos*
Para ejecutar este proyecto, necesitarás tener los siguientes requisitos previos:
	•	PHP 8.0 o superior
	•	Composer (para gestionar dependencias)
	•	Symfony CLI
	•	SQLite (no requiere instalación adicional, ya que Symfony se conecta a una base de datos SQLite)
	•	Un cliente HTTP como Postman o Thunder Client para realizar las peticiones a la API.



 **Instalación**
 
 **1. CLONAR REPOSITORIO EN LOCAL**
  
    git clone https://github.com/SaraCalvente/api_rest_480.git
    cd api_rest_480
  
 **2. INSTALAR DEPENDENCIAS**
  
    composer install

 **3. CONFIGURACIÓN DE LA BBDD**
  
  El proyecto utiliza SQLite como base de datos, por lo que no es necesario instalar un servidor de base de datos como MySQL o PostgreSQL. 
  Solo necesitas crear el archivo de base de datos en el directorio var/.
  Ejecuta el siguiente comando para crear las tablas necesarias en la base de datos SQLite: 
    
    php bin/console doctrine:schema:create
  
 **4. CONFIGURACION DE JWT**
  
  Ejecuta el siguiente comando para generar las claves privadas y públicas necesarias para la autenticación: 
        
     php bin/console lexik:jwt:generate-keypair 
  
  Esto creará dos archivos: config/jwt/private.pem y config/jwt/public.pem.

  Abre .env y asegura que las variables esten configuradas correctamente, remplaza your_secret_passphrase por tu contraseña segura

 **5. CONFIGURACIÓN DE LAS RUTAS DE AUTENTICACIÓN**
  
  El archivo config/packages/security.yaml contiene la configuración para proteger las rutas con JWT.
  Asegúrate de que la configuración de seguridad esté correctamente definida para que las rutas de la API estén protegidas.

  
  
  **Uso**
 
  **1. LEVANTAR EL SERVIDOR DE SYMFONY**
    
    symfony server:start
    La API estará disponible en http://127.0.0.1:8000

  **2. REALIZAR PETICIONES API**

   La API proporciona las siguientes rutas para interactuar con los “libros”:
  	•	GET /libro/get: Obtiene una lista de todos los libros.
  	•	POST /libro/post: Crea un nuevo libro. Necesita los campos titulo, autor, genero, y año_publicacion en el cuerpo de la solicitud.
  	•	PUT /libro/put/{id}: Actualiza un libro existente.
  	•	DELETE /libro/delete/{id}: Elimina un libro por ID.

   Y  proporciona las siguientes rutas para interactuar con los “usuarios”:
  	•	GET /user/get: Obtiene una usuario de todos los usuarios.
  	•	POST /user/post: Crea un nuevo usuario. Necesita los campos email, nombre, y edad en el cuerpo de la solicitud.
  	•	DELETE /user/delete/{id}: Elimina un usuario por ID.

  **3. EJEMPLO DE AUTENTICACIÓN CON JWT**
    
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
 
