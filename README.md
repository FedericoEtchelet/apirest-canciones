# API REST

## ENDPOINTS
## DESCRIPCION, EJEMPLOS Y COMO SE USAN
### $router->addRoute("songs", "GET", "songsApiController", "getSongs");


Este endpoint llama a la funcion getSongs(), y se encarga de pedir la coleccion entera de canciones a la base de datos, tambien se encarga de ordenar y filtrar estas canciones a traves de los query params.

   Si colocamos este link: http://127.0.0.1/web/apirest-canciones/api/songs?orderBy=id&orderDir=ASC
	 USAMOS EL METODO GET

   La lista de canciones sera mostrada por ID en orden ascendente:



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
### $router->addRoute("songs/:ID", "GET", "songsApiController", "getSongByid");

Este endpoint llama a la funcion getSongByid(), y se encarga de pedir la cancion con el id, que le pasas por parametro.

Por ejemplo:

 Si colocamos este link: http://127.0.0.1/web/apirest-canciones/api/songs/3 USAMOS EL METODO GET
 
 Lo que me mostrara va a ser la cancion con el id 3.
  
{

    "id": "3",
    "nombre": "Talking to Myself",
    "artista": "Linkin Park",
    "id_album": "1"
		
}

_____
### $router->addRoute("songs/:ID", "DELETE", "songsApiController", "deleteSong");

Este endpoint llama a la funcion deleteSong(), y se encarga de eleminar una cancion especificada por parametro.
Por ejemplo:

Si colocamos este link: http://127.0.0.1/web/apirest-canciones/api/songs/34

USAMOS EL METODO DELETE

La cancion con ID:34 será eliminada (en caso de que existiera).


_____
### $router->addRoute("songs", "POST", "songsApiController", "addSong");
Este endpoint llama a la funcion addSong(), y se encarga de agregar una cancion nueva con todos sus registros.

Por Ejemplo:

Si colocamos este link: http://127.0.0.1/web/apirest-canciones/api/songs 

USAMOS EL METODO POST

ingresamos los datos de la nueva cancion que queremos agregar:

{

    "nombre": "Pintao",
    "artista": "Duki",
    "id_album": 1
		
}

La id es autoIncremental, a esta nueva cancion se le pondra la ultimaId+1 o sea si la ultima cancion tiene id 30, esta tendra 31.



_____
### $router->addRoute("songs/:ID", "PUT", "songsApiController", "editSong");

Este endpoint llama a la funcion editSong(), y se encarga de editar una cancion, la cancion que vamos a editar es la que nosotros le pasemos por id en la url.

Por ejemplo:

Si colocamos este link: http://127.0.0.1/web/apirest-canciones/api/songs/34 USAMOS EL METODO PUT

La cancion con ID:34 será la cancion a editar (en caso de que existiera).
____
## TOKEN 

### IMPORTANTE

SIEMPRE QUE QUERRAMOS MODIFICAR O AGREGAR, OSEA USAR LOS METODOS PUT O POST, TENDREMOS QUE AUTENTICARNOS CON EL SIGUIENTE TOKEN:
eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c3VhcmlvIjoiYWRtaW4iLCJjbGF2ZSI6IndlYmFkbWluIn0.yYaJUjREUHvvlm17Z8YGZ0fZE5zilaW4vpdSXuSFALs

