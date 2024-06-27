# API REST

## ENDPOINTS
## DESCRIPCION, EJEMPLOS Y COMO SE USAN
### $router->addRoute("songs", "GET", "songsApiController", "getSongs");


Este endpoint llama a la funcion getSongs(), y se encarga de pedir la colección entera de canciones a la base de datos, tambien se encarga de ordenar y filtrar estas canciones a través de los query params.

   Si colocamos este link: http://127.0.0.1/web/apirest-canciones/api/songs?orderBy=id&orderDir=ASC 
   
	NOTA: USAMOS EL METODO GET, LOS PARAMETROS orderBy Y orderDir SON OBLIGATORIOS.
 	LOS PARAMETROS PARA orderBy pueden ser: id; nombre; artista; id_album.
	LOS PARAMETROS PARA orderDir pueden ser: ASC; DESC.
 
   La lista de canciones será mostrada por ID en orden ascendente:



    {
        "id": 1,
        "nombre": "Nobody Can Save Me",
        "artista": "Linkin Park",
        "id_album": 1
    },

    {
        "id": 2,
        "nombre": "Good Goodbye (Ft. Pusha T & Stormzy)",
        "artista": "Linkin Park",
        "id_album": 1
    },
        "id": 3,
        "nombre": "Talking to Myself",
        "artista": "Linkin Park",
        "id_album": 1
    },...
____

Caso contrario, mostrará el mensaje "ERROR: No hay canciones o faltan parámetros" con el código 404.

En el caso de no conectar con el servidor mostrará el siguiente mensaje: "Error de servidor" con el código 500.
____
### $router->addRoute("songs/:ID", "GET", "songsApiController", "getSongByid");

Este endpoint llama a la funcion getSongByid(), y se encarga de pedir la cancion con el id, que le pasas por parametro.

Por ejemplo:

 Si colocamos este link: http://127.0.0.1/web/apirest-canciones/api/songs/3 
 
 	NOTA: USAMOS EL METODO GET, EL ID PASADO POR HTML ES OBLIGATORIO.
 
 Lo que me mostrara va a ser la cancion con el id 3.
  
	{

    "id": "3",
    "nombre": "Talking to Myself",
    "artista": "Linkin Park",
    "id_album": "1"
		
	}

____

En el caso de no existir la cancion con el id, mostrará el siguiente mensaje: "ERROR la cancion con ID: {$id} no existe o no pudo ser encontrada" con el código 404.

En el caso de no conectar con el servidor mostrará el siguiente mensaje: "Error de servidor" con el código 500.
____
### $router->addRoute("songs/:ID", "DELETE", "songsApiController", "deleteSong");

Este endpoint llama a la funcion deleteSong(), y se encarga de eleminar una cancion especificada por parametro.
Por ejemplo:

Si colocamos este link: http://127.0.0.1/web/apirest-canciones/api/songs/34

	NOTA: USAMOS EL METODO DELETE, EL ID PASADO POR HTML ES OBLIGATORIO.
____

La cancion con ID:34 será eliminada mostrando el mensaje "La cancion ha sido eliminada con éxito" con el código 200.

En el caso de no existir la cancion con el id pasado por parametro, mostrará el siguiente mensaje: "ERROR la cancion con ID: {$id} no existe o no pudo ser encontrada" con el código 404.

En el caso de no conectar con el servidor mostrará el siguiente mensaje: "Error de servidor" con el código 500.

_____
### $router->addRoute("songs", "POST", "songsApiController", "addSong");
Este endpoint llama a la funcion addSong(), y se encarga de agregar una cancion nueva con todos sus registros.

Por Ejemplo:

Si colocamos este link: http://127.0.0.1/web/apirest-canciones/api/songs 

	NOTA: USAMOS EL METODO POST, PARAMETROS "nombre", "artista", "id_album" SON OBLIGATORIOS.

ingresamos los datos de la nueva cancion que queremos agregar (con la sección body del postman por ejemplo):

	{

    "nombre": "Pintao",
    "artista": "Duki",
    "id_album": 1
		
	}
____

	La id es autoIncremental, a esta nueva cancion se le pondra la ultimaId + 1, es decir, en caso de que la última canción tenga por id 30, la agregada será id 31.
	En caso de faltar algun parametro, o error en el model, se imprimira el siguiente mensaje "ERROR la cancion no ha sido agregada." con el codigo 400.
 	En caso de error de servidor se imprimirá el mensaje "Error de servidor" con el codigo 500.

_____
### $router->addRoute("songs/:ID", "PUT", "songsApiController", "editSong");

Este endpoint llama a la funcion editSong(), y se encarga de editar una cancion, la cancion que vamos a editar es la que nosotros le pasemos por id en la url.

Por ejemplo:

Si colocamos este link: http://127.0.0.1/web/apirest-canciones/api/songs/34 

	NOTA: USAMOS EL METODO PUT, EL ID PASADO POR HTML ES OBLIGATORIO.

La cancion con ID:34 será la cancion a editar, una vez editada arrojará el siguiente mensaje "La cancion ha sido modificada con éxito." con el código 201.
En caso contrario se mostrará el mensaje "ERROR la cancion no existe o no puede ser modificada." con el código 404.
Si hubiera un error con el servidor se imprimirá el siguiente mensaje "Error de servidor" con el código 500.
____
## ALBUM
### $router->addRoute("album", "POST", "albumApiController", "addAlbum");

Este endpoint llama a la funcion addAlbum(), se encarga de agregar un album vacío con los parametros pasados.

Por ejemplo:

Si colocamos este link: http://127.0.0.1/web/apirest-canciones/api/album/

	NOTA: USAMOS EL METODO POST, LOS PARAMETROS PASADOS POR EL BODY EXCEPTUANDO LA IMAGEN SON OBLIGATORIOS.

____

	{
	   "album": "One more light",
	   "imagen": "(dirección del archivo almacenado en la computadora)"
 	}
____

En caso de que el album haya sido agregado con éxito, se mostrará dicho album con el código 200.
Caso contrario se imprimirá el mensaje "ERROR el album no pudo ser insertado." con el código 400.
____

## Para el resto del album controller es básicamente lo mismo (cambiando *songs* por *album* en el link html), para ahorrar tiempo de lectura será omitido el paso a paso de sus respectivos endpoints.
______
## TOKEN 

### IMPORTANTE

**SIEMPRE QUE QUERRAMOS MODIFICAR O AGREGAR, ES DECIR USAR LOS METODOS PUT O POST, TENDREMOS QUE AUTENTICARNOS CON EL SIGUIENTE TOKEN:**

	eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c3VhcmlvIjoiYWRtaW4iLCJjbGF2ZSI6IndlYmFkbWluIn0.yYaJUjREUHvvlm17Z8YGZ0fZE5zilaW4vpdSXuSFALs


