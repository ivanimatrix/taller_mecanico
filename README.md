# PANDEMOLDE
Pandemolde framework PHP : otro framework para desarrollos en PHP. Ojalá intituivo y rápido, ya que esa es la idea...

Usa la arquitectura **MVC** (Modelo - Vista - Controlador), pero basado en módulos. O sea, se deben crear módulos y cada uno de estos tendrá sus propios controladores, modelos y vistas.

Otra característica es que **Pandemolde** ocupa el concepto de **Entidad** para referirse a los "modelos", de otros frameworks.

## Migas
**migas** es un script que permite administrar y generar elementos como Módulos, Controladores y Entidades para tu proyecto. Se puede ejecutar en una consola/terminal tanto en Linux, MacOS y Windows (para Windows se debe usar el ejecutable del **PHP**).

A continuación, una mirada rápida a ciertos comandos que acepta **migas**

### Crear Proyecto
~~~
$ php migas app::create
~~~
Crea la estructura completa para comenzar a desarrollar el proyecto. Si ya se ha creado anteriormente, todo el contenido será borrado. La estructura es:

- `app` : Aquí deben ir todos los módulos que se desarrollen para la aplicación. También debe contener el archivo `app_config.php` y `app_database.php` para los parámetros de configuración y conexión a base de datos, respectivamente

- `pub` : Carpeta destinada a guardar y contener ficheros de uso público, como hojas de estilo, código javascript, etc.

- `libs` : Si tu proyecto usa librerías de PHP y que son invocadas por muchos módulos, entonces es aquí donde debiesen ir

- `sql` : Si quieres guardar tus script de SQL, podrías usar este directorio para hacerlo. La verdad, es que sólo existe por un tema de orden

- `tmp` : Esta carpeta contiene los logs que se vayan generando durante la ejecución de la aplicación. Lo ideal, es que tenga permiso de escritura

- `pan` : Núcleo de Pandemolde. Si no está, no funciona.


### Crear Módulo
~~~
$ php migas module::NOMBRE_MODULO
~~~
Se crea un módulo con el nombre NOMBRE_MODULO, y una estructura de directorios como se visualiza:
~~~
app/
	NOMBRE_MODULO/
		assets/
			css/
			img/
			js/
			others/
		controllers/
		entities/
		libraries/
		views/
~~~

### Crear Controlador
~~~
$ php migas controller::NOMBRE_MODULO/NOMBRE_CONTROLADOR
~~~
Crea un controlador llamado NOMBRE_CONTROLADOR dentro del directorio controllers, en módulo NOMBRE_MODULO, 

### Crear Entidad
~~~
$ php migas entity::NOMBRE_MODULO/NOMBRE_ENTIDAD
~~~
Crea una entidad llamanda NOMBRE_ENTIDAD dentro del directorio entities, en módulo NOMBRE_MODULO


Cada uno de los comandos mencionados anteriormente, aceptan otros parámetros, que pueden revisarlo en la wiki