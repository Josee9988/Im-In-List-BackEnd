# **ImInList** - Tu aplicación de listas desde dentro

**I'm In List** es una aplicación la cual se ha desarrollado para facilitar la gestión y organización de todos los usuarios, creando una aplicación sencilla y amigable para que todo el publico pueda hacer uso de ella.

Desarrollada por alumnos de **2ºDAW** para el proyecto final integrador _2019-2020_ con un plazo de 3 semanas lectivas de desarrollo.

En esta parte veremos el funcionamiento interno de la api, y como se ha desarrollado el backEnd, como se controlan las listas, los usuarios y la funcionalidad del administrador

---

## **API** 🔩

El proyecto actuara con la *API* desde un front hecho por dos integrantes del proyecto integrador. Revisa la [documentación del Front](https://github.com/Josee9988/Im-In-List-FrontEnd)

Constara de varios controladores: gestión de usuarios, donde solo el admin sera el único que podrá interactuar con los usuarios ya que estará gestionado por un middleware, (excepto una ruta especifica de edición de usuarios).
Gestión de listas, esta es la más amplia ya que puede interactuar todo el mundo incluso sin estar registrado, dependiendo del tipo del usuario tendrá unas opciones al crear la lista por ejemplo:
 - No registrados: solo podrán crear una agregando titulo,descripción y elementos de la lista, se creara una url random para acceder
- Registrados: podrán crear listas igual que los no registrados, pero la url sera diferente ya que sé coger el nombre del usuario más un random

- Premium: podrán poner contraseñas a las listas y personalizar la url con el titulo de la lista
Habrá una ruta de contacto donde se podrá enviar un email al administrador por si algún usuario tiene que realizar cualquier pregunta

---

## **Servidor de desarrollo** 🚀

#### **Entorno de trabajo**

Tenemos que tener preparado un entorno de desarrollo, en la documentación oficial de laravel explica como crearlo `https://laravel.com/docs/6.x#installing-laravel` pero aquí te dejo una guía con Homestead mas fácil de seguir:`https://styde.net/instalacion-y-configuracion-de-laravel-homestead/`

#### **Codigo**

Al ya tener el entorno de trabajo, se habrá de clonar el repositorio y realizar `composer update` para instalar las dependencias, habrá que apuntar a la ruta especificada en `Homestead.yaml` -> sites. Realizaremos `vagrant up` para hacer funcionar el servidor.

---

## **Requisitos para poder ejecutar el entorno de desarrollo** 📋

Deberá de tener todas las dependencias para poder realizar el entorno de desarrollo. Para obtenerlos, se debe ejecutar `composer update` y automáticamente se instalarán todas las dependencias necesarias.

---

## **Wiki** 📖

La principal fuente de información ha sido obtenida de la documentación oficial de [Laravel](https://laravel.com/docs/6.x).

---

## **Contacto** ✒️

Esta aplicación ha sido desarrollado por:

-   Alejandro Ortega → <alexoh500@gmail.com>

---

*Hecho por **[@alexoh500](https://github.com/alexoh500)***