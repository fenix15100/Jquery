

//WORKFLOW:

/*
 * Administrador programa n juegos a un paciente X dia, cada juego que asigne a un alumno
 * ara un INSERT en la tabla Partida en el que se le asignara una ID,el id del usuario,ID juego,
 * Tematica,Nivel(Los niveles seran programables por el administrador en otra tabla, no nos preocupa),
 * y el Timestamp de la programacion, todos los demas campos estaran a NULL.
 *
 * Tutor tiene asignados n alumnos e inicia sesion en la webapp, elije un alumno y ve los juegos que tiene programados para ese dia
 * (Lo que en realidad ve son las partidas disponibles de la tabla Partidas).
 *
 *
 * Elije un juego
 * (En este momento haremos una peticion al objeto partida que hemos selecionado y deberemos guardarlo en un objeto de  nuestra clase Partida()).
 *
 * Aparece pantalla de configuracionen en ella podra selecionar la tematica y el nivel en el caso que sea posible.
 * (Por defecto ya vendran selecionadas con las opciones de la partida programada, como por defecto).
 * Se debera poder elegir otras tematicas y niveles compatibles (para ello una petición ajax a la base de datos nos dara todos los nombre
 * de tematica disponibles i todos los niveles para este juego)
 * Si esto ocurre deberemos actualizar nuestro objeto partida con la nueva tematica y el nivel
 *
 * Una vez configurado el juego le daremos a jugar, en ese momento se cargaran desde el servidor los recursos multimedia deseados (Definidos por la tematica y nivel).
 * Para ello se enviara una peticion al backend enviado la tematica y el nivel y este nos contestara con un array de objetos Media
 * que guardaremos con nuestra clase Media()
 *
 * Al acabar la partida, se enviara nuestro objeto Partida y hara el update con el registro original de la tabla Partida
 * Tanto la recepcion como el envio de datos se hara por Ajax hacia el backend en formato de objeto JSON plano (Importante).
 *
 * Para poder gestionar las respuesta del servidor tenemos estas dos clases:
 * */


//Clase que permite Instanciar un Modelo que puede recojer los datos de una partida recibida por el servidor

//Recibe como parametro un Objeto JSON plano recibido por el servidor, este Objeto es una representacion en texto plano de nuestro Modelo Partida()

function Partida(ObjPartida) {

    this.id_partida=ObjPartida.id_partida;
    this.tiempoReaccion = ObjPartida.tiempoReaccion;
    this.tiempoTotal = ObjPartida.tiempoTotal;
    this.cliks = ObjPartida.cliks;
    this.fallos = ObjPartida.fallos;
    this.aciertos=ObjPartida.aciertos;
    this.tematica=ObjPartida.tematica;
    this.nivel=ObjPartida.nivel;
    this.velocidad=ObjPartida.velocidad;
    this.comentario=ObjPartida.comentario;
    this.numImgTotal=ObjPartida.numImgTotal;
    this.parejasValidas=ObjPartida.parejasValidas;
    this.imagenesDiferentes=ObjPartida.imagenesDiferentes;
    this.repeticionesSonido=ObjPartida.repeticionesSonido;
    this.numeroSonidos=ObjPartida.numeroSonidos;
    this.imagenesIniciales=ObjPartida.imagenesIniciales;
    this.imagenesFinales=ObjPartida.imagenesFinales;

    //METHODS CLASS Partida()
    //Obtiene todos los niveles y tematicas disponibles para esta partida desde el servidor, lo utilizaremos para rellenar el menu de configuracion inicial
    //Lo recibiremos en un Array de 2 dimesiones, en la primera dimesion estaran todos los niveles disponibles en la segunda todas las tematicas disponibles (Ojo las ID de estos).
    //dataS['niveles']['tematica]
    //          [1,2,3]   [1,2,3]

    //Recibe como parametro la Url de obtencion del array (Por Ejemplo /Partida/GetConfig/{tematica}/{nivel})
    //Tanto la tematica como el nivel recordar que lo tenemos en el objeto partida

    this.getAllAvailableConfig=function (url) {

        var data=[];
        var niveles=[];
        var tematicas=[];
        $.ajax({
            type: "GET",
            url: url,
            success: function(dataS) {
                dataS = JSON.parse(dataS);

                dataS.niveles.forEach(function (value) {

                    niveles.push(value);

                });

                dataS.tematicas.forEach(function (value) {
                    tematicas.push(value);

                });

                data.push(niveles);
                data.push(tematicas);

            }
        });
        return data;

    };

}




//Clase que permite instanciar un Modelo que puede recojer los datos de un objeto Media enviado por el servidor
//(Lo suyo sera hacer un array de objetos Media para poder recorrerla, tal como nos vendra en el servidor) (Metodo  estatico getLibraryMedia lo hace por usted)

//Recibe como parametro un Objeto JSON plano recibido por el servidor que es la reprensentacion en texto plano de nuestro modelo Media

function Media(ObjMedia){

    this.idMedia=ObjMedia.idMedia;
    this.url_img=ObjMedia.url_img;
    this.url_sonido_hablado=ObjMedia.url_sonido_hablado;
    this.url_sonido_escuchado=ObjMedia.url_sonido_escuchado;

}



//Funciones Estaticas del ModeloJuego.js

//Su funcion es facilitar la obtencion y envio de los datos hacia el servidor (Usarlas XD)

//Funcion que nos retornara nuestro objeto partida, recibe como parametro la url/{id]de la partida a obtener (esta url estara en un input hidden con la ID #IDPARTIDA en el DOM de la vista)
//(Pensar que al final los juegos seran entregados a traves de symfony via Twig)
function getPartida(url) {

    $.ajax({
        type: "GET",
        url: url,
        success: function(Objpartida) {
            partida = new Partida(JSON.parse(Objpartida));


        }
    });

    return partida;

}

//Funcion que enviara nuestro objeto partida, y sobreescribira el que esta en la tabla partida,
//recibe como parametro la url para editar la partida(Por ejemplo Partida/edit/{id}) la id de la partida la sacamos de nuestro objeto partida
//Como segundo parametro recibe nuestro objeto partida
function sendPartida(url,partida) {

    $.ajax({
        type: "PUT",
        url: url,
        data:JSON.stringify(partida),
        success: function(msg) {
            console.log(msg);

        }
    });

}

//Funcion que nos retornara un Array con todos los objetos Media() selecionados
//Recibe como parametro la Url de obtencion del array (Por Ejemplo /Media/{tematica}/{nivel})
//Tanto tematica como nivel las podemos obtener con las propiedades de nuestro objeto Partida
function getLibraryMedia(url) {

    var datamedia=[];
    $.ajax({
        type: "GET",
        url: url,
        success: function(LibraryMedia) {
            LibraryMedia=JSON.parse(LibraryMedia);

            LibraryMedia.forEach(function (value) {

                media=new Media(value);
                datamedia.push(media);

            });


        }
    });

    return datamedia;

}




