![Logo Canvas](https://genially.blob.core.windows.net/genially/users/589bdaf9e3e75c0c6cc70002/58af4f0a85d4a01b901ed346/58af4f0a85d4a01b901ed347/2c04f548-f1d7-4a36-a358-f80849d5af8e.png)
# Guia de consumo de API Canvas (IU Digital)
Aquí podrás encontrar una guía practica de como hacer consumo del API de Canvas.
Desde el siguiente [link](https://iudigital.test.instructure.com/doc/api/live) podrás ver todas y cada una de las variables y su explicación que podremos consumir, cabe señalar que cada direccionamiento de la api tiene sus limites de información que puede ser procesada por esta, por lo que cierta información no es posible extraerla con una única dirección, y según perfil cambian algunas condicionales, que podrían ser causales de mensajes de solicitud errónea, <u>*por lo que antes de consumir con la aplicación se recomienda hacer una prueba de impresión con ``[Postman](https://www.postman.com/downloads/) o el plugin [Thunder Client](https://marketplace.visualstudio.com/items?itemName=rangav.vscode-thunder-client) de [VSCode](https://code.visualstudio.com/#alt-downloads).*</u>

> **ADVERTENCIA:** Recordar para hacer cualquier prueba estar solo bajo el [interfaz de pruebas de Canvas](https://iudigital.test.instructure.com/)

## Indice Tematico

 1. [Notas iniciales](#0)
 2. [Como crear API Key para consumo](#1)
 3. [Como crear Key de Desarrollo para que Canvas consuma nuestra API](#2)
 4. [Que diferencias nos podremos encontrar con una misma solicitud?](#3)
 5. [Como consumir la API Key](#4)
       -  [Configuración Inicial](#4A)
       -   [Consumo en PHP](#4B)
 6. [Fuentes de información](#5)

## Notas iniciales <a id="0">

Para poder proceder con la creación de la API Key, es necesario un acceso de administrador en la plataforma Canvas, en caso dado de no contar con este, seria solicitar a alguien con dicho perfil generar la API Key para poder proceder con el consumo de esta, por lo que se recomienda en el ambiente de implementación, creación de un perfil para dicha tarea o las debidas asignaciones.

## Como crear API Key para consumo <a id="1">

En el interfaz de Canvas para crear nuestra API key primero tendremos que ir a la `Cuenta > `[Configuraciones](https://iudigital.test.instructure.com/profile/settings). Aquí encontraremos una sección `Integraciones aprobadas` y le daremos de la opción `+ Nuevo token de acceso` ahí nos pedirá asignar una `fecha de expiración` (si se desea) y el `propósito`, seguido a esto nos dará nuestra API Key con la cual podremos consumir el API de Canvas.

> **ADVERTENCIA:** Una vez generada esta solo se mostrara una única vez completa por razones de seguridad, si esta no fue copiada en un lugar seguro, deberá de generarse una nueva API Key.

## Como crear Key de Desarrollo para que Canvas consuma nuestra API <a id="2">

En caso de que hemos generado un api que tenga un tipo de instrucciones diferentes de Canvas y requerimos que Canvas se encargue de consumirla, debemos seguir las siguientes instrucciones, en el menu `Admin > `[Claves del desarrollador](https://iudigital.test.instructure.com/accounts/1/developer_keys), podremos observar un interfaz en el cual podremos observar las API Key existentes de servicios remotos, estas no solo permite habilitarlas o deshabilitarlas, si no asignarle permisos y los diferentes condicionamientos según respuestas, y sus debidas key.
> **ADVERTENCIA 1:** Este proceso es exclusivamente para cuando se requiere que Canvas consuma ciertos procesos que son ajenos a su estructura api, ejemplo como es el chequeo de plagios de TurnItIn, para que pueda integrarlos, en caso de no ser necesarios, no es una obligación crear una clave de desarrollador.
> **ADVERTENCIA 2:** Estas key no sirven para solicitar informacion a Canvas, solo para que la Canvas pueda hacer las solicitudes a nuestra API, el usar las Key generadas en Claves de Desarrollador dara como resultado respuestas de Token Invalido.

## Que diferencias nos podremos encontrar con una misma solicitud? <a id="3">
Un ejemplo claro es si consumimos los usuarios de una clase `(/api/v1/courses/****/users)`, por usuarios tenemos no solo a los estudiantes, de igual forma ahí entran los profesores, observadores, y perfiles de prueba. Los estudiantes tienen un estado de inscripción al curso que se puede representar como activo, inactivo, invitado, rechazado, y completado, al igual que una nota. Perfiles como los profesores no cuentan con estas 2 variables, por lo cual en caso que se soliciten datos de usuario que incluya los 2 perfiles a la vez nos dará un error de solicitud, al encontrar dichos campos inexistentes. y porque no usar entonces solicitudes como `(/api/v1/courses/****/students)` que nos daría acceso a solo los estudiantes, es porque esta solo nos da una información limitada, que no incluye información de relevancia como su estado, su calificación, su ingreso, que hacen que dicha información sea muy escasa para lo que muchas veces se busca.

## Como consumir la API Key<a id="4">

### Configuración previa<a id="4A">

En nuestra configuración de solicitud, nos dispondremos a asignarle la información de solicitud de header con nuestra api key, como tipo de auth asignaremos el método Bearer seguida por la API Key que hemos generado Ejemplo `12345~ABCDEFGHIJKLMNOPQ`. Ya aquí procederemos a introducir nuestra dirección de API, y a especificar los parámetros a buscar según los requisitos de esta.

### Consumo en PHP<a id="4B">

Como primero procedemos a crear un ajuste de prueba inicial el cual nos dará mucha parte de nuestra información a imprimir en una interfaz visual

Para hacer mas practico el proceso, en este ejemplo estaremos consumiendo `api/v1/courses/****/users` y le daremos unos ajustes iniciales de solicitud el cual nos permitira recibir una informacion de estudiantes activos e inactivos `enrollment_state[]=active&enrollment_state[]=inactive`, y datos de sus estadísticas completas como su estado, calificación y fecha de ingreso en el curso `include[]=enrollments`, este por defecto seleccionara solo estudiantes por lo que no es necesario especificar el tipo de usuario a buscar. 

    <?php
	    $curl = curl_init();
	    $httpheader = ['Authorization: Bearer 12345~ABCDEFGHIJKLMNOPQ'];
	    
	    $url = "https://iudigital.test.instructure.com:443/api/v1/courses/****/users?include[]=enrollments&enrollment_state[]=active&enrollment_state[]=inactive";
    
	    curl_setopt($curl, CURLOPT_URL, $url);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
	    curl_setopt($curl, CURLOPT_HTTPHEADER,$httpheader);
	    $resul = curl_exec($curl);
	    $reg = json_decode($resul, true);
    ?>

Seguido de esto procederemos a crear unos cabezotes para las columnas de información que estamos a punto de buscar

    <table  class="table-auto">
	    <thead>
		    <tr>
			    <th>Nombre</th>
			    <th>Numero de ID</th>
			    <th>Correo Electronico</th>
			    <th>Estado Usuario</th>
			    <th>Calificacion</th>
		    </tr>
		</thead>
	    <tbody>

 Y ya aquí empezaremos a dar el formato que nos dará los resultados que queremos buscar, nuestras llaves de búsqueda sobre `api/v1/courses/****/users`serán `name`, `sis_user_id`, `login_id` y `enrollments` este ultimo es un array que anida mucha mas información, por lo que debemos invocar dicha información de una forma diferente, en caso de que usemos únicamente `enrollments` este arrojara un error de solicitud ya que no se especifica que parte del array se desea buscar, para este ejemplo iremos al nivel `0` y buscaremos la variable  `enrollment_state` y `grades`, pero como podemos ver `grades` a su vez es un array que incluye elementos como `final_score` ya que este es un array dentro de un array a su vez el sistema de Canvas no nos solicita especificar de nuevo la profundidad del array, solo concatenar la secuencia de lo que se busca específicamente dentro de `grades` que a su vez estaría dentro de `enrollments`

    <?php
	    foreach ($reg as $key => $value) {
		    echo  "<tr><th>";
		    echo  $value["name"];
		    echo  "</th><th>";
		    echo  $value["sis_user_id"];
		    echo  "</th><th>";
		    echo  $value["login_id"];
		    echo  "</th><th>";
		    echo  $value["enrollments"]["0"]["enrollment_state"];
		    echo  "</th><th>";
		    echo  $value["enrollments"]["0"]["grades"]["final_score"];
		    echo  "</th><th>";
		}
	    echo  "</tbody></table>";
	    curl_close($curl);
    ?>

con esto podríamos arrojar no solo el nombre del usuario, si no su documento de identidad, su correo, su estado de registro en el curso y su calificación final del curso. A su vez con este ejemplo pudimos aprender no solo como desplegar la información, si no a su vez entender como se debe hacer para proceder con esos datos anidados en arrays.

## Fuentes de Información<a id="5">
En caso de requerir fuentes confiables para poder investigar nuestra api de Canvas tenemos ciertos recursos

- [Ayuda de Usuario del API de Canvas](https://iudigital.test.instructure.com/doc/api/index.html)
- [Guía de Consultas del API de Canvas](https://iudigital.test.instructure.com/doc/api/live)
- [Foros de la comunidad de Canvas](https://community.canvaslms.com/)
- [Canal Oficial de YouTube de Canvas](https://www.youtube.com/user/CanvasLMS)
