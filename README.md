# **ImInList** - Tu aplicación de listas desde dentro

**I'm In List** es una aplicación la cual se ha desarrollado para facilitar la gestión y organización de todos los usuarios, creando una aplicación sencilla y amigable para que todo el publico pueda hacer uso de ella.

Desarrollada por alumnos de **2ºDAW** para el proyecto final integrador _2019-2020_ con un plazo de 3 semanas lectivas de desarrollo.

En esta parte veremos el funcionamiento interno de la api, y como se ha desarrollado el backEnd, como se controlan las listas, los usuarios y la funcionalidad del administrador

---

## **API** 🔩

El proyecto actuara con la *API* desde un front hecho por dos integrantes del proyecto integrador. Revisa la [documentación del Front](https://github.com/Josee9988/Im-In-List-FrontEnd)

Constara de varios controladores: 

 - Gestión de usuarios:
Únicamente el admin será el único que podrá interactuar con los usuarios ya que estará gestionado por un middleware, (excepto una ruta especifica de edición de usuarios).

 - Gestión de listas:
Esta es la más amplia ya que puede interactuar todo el mundo incluso sin estar registrado, dependiendo del tipo del usuario tendrá unas opciones al crear la lista por ejemplo:

    - **No registrados:**
Solo podrán crear una agregando titulo, descripción y elementos de la lista, se creara una url random para acceder.
 
    - **Registrados:**
Podrán crear listas igual que los no registrados, pero la url será diferente ya que sé coger el nombre del usuario más un random.

    - **Premium:**
Podrán poner contraseñas a las listas y personalizar la url con el titulo de la lista.

Habrá una ruta de contacto donde se podrá enviar un email al administrador por si algún usuario tiene que realizar cualquier pregunta



#### **Recursos**
La versión de laravel con la cual se ha desarrollado la api es `"laravel/framework": "^6.2"`

Para la autenticación de usuarios mediante token, se ha utilizado un cifrado [jwt-auth](https://jwt-auth.readthedocs.io/en/develop/) mediante el cual define una forma compacta y autónoma para transmitir información de forma segura entre las partes como un objeto JSON.
Al ser laravel 6 la versión mas compatible actualmente es `"tymon/jwt-auth": "dev-develop"`ya que versiones anteriores estaban anticuadas a la versión actual de laravel.

Para realizar consultas a la api externamente se ha instalado un componente `"fruitcake/laravel-cors": "^1.0"` que actuara como middleware donde permitirá las peticiones externas.
 - Componente e mas información:
 > [CORS](https://github.com/fruitcake/laravel-cors) 

---

## **Servidor de desarrollo** 🚀

#### **Entorno de trabajo**

Tenemos que tener preparado un entorno de desarrollo, en la documentación oficial de laravel explica como crearlo `https://laravel.com/docs/6.x#installing-laravel` pero aquí te dejo una guía con Homestead mas fácil de seguir:`https://styde.net/instalacion-y-configuracion-de-laravel-homestead/`

#### **Codigo**

Al ya tener el entorno de trabajo, se habrá de clonar el repositorio y realizar `composer update` para instalar las dependencias, habrá que apuntar a la ruta especificada en `Homestead.yaml` -> sites. Realizaremos `vagrant up` para hacer funcionar el servidor.

---

## **Despliegue**

Se ha realizado el despliegue utilizando la herramienta [deployer](https://deployer.org/) que consiste en un archivo php que contiene definiciones de tareas, la tarea puede requerir otras tareas y ampliar o anular la funcionalidad.

Mediante ssh se conectara a nuestro servidor en staging o en producción dependiendo de la ip especificada, el usuario **back** será el cual permitirá desplegar en nuestro servidor en la ruta `/var/www/html/ImInList-back` a partir de este repositorio.

### Información servidores:
 - #### Servidor staging:
>IP: 54.243.26.179

>URL: iminlist.back.staging.grupo04.ddaw.site

>Usuario: back


 - #### Servidor producción:
>IP: 54.165.254.46

>URL: iminlist.back.grupo04.ddaw.site

>Usuario: back

---

## **Requisitos para poder ejecutar el entorno de desarrollo** 📋

Deberá de tener todas las dependencias para poder realizar el entorno de desarrollo. Para obtenerlos, se debe ejecutar `composer update` y automáticamente se instalarán todas las dependencias necesarias.

---

## **Wiki** 📖

La principal fuente de información ha sido obtenida de la documentación oficial de [Laravel](https://laravel.com/docs/6.x).

---

## **Contacto** ✒️

Esta aplicación ha sido desarrollado por:

- Alejandro Ortega → <alexoh500@gmail.com>
- Jose Gracia → <jgracia9988@gmail.com>
- Borja Pérez → <multibalcoy@gmail.com>

---

*Hecho por **[@alexoh500](https://github.com/alexoh500)***