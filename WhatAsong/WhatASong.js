

//Globals
var partida=null;
var dataLibrary=null;

//Chivato para parar el juego
var finpartida=false;




//Main
$(document).ready(function () {

    //Creo mi contenedor (Tanto si es DIV como CANVAS) y lo añado al body
    var container=document.createElement("div");
    container.id="container";
    $(container).css("width", "800");
    $(container).css("height", "600");
    //Aplicar el CSS que veais necesario, sin mucha excentricidad XD
    document.body.appendChild(container);
    

    //Obtengo del DOM la id de la partida (esta estara ya dibujada en el DOM leer textaco del archivo ModeloJuego.js)


    var url_getPartida=$("#IDPARTIDA").val();

    //Obtengo el objeto partida
    partida=getPartida(url_getPartida);

    //Dibujo la ventana de configuracion;
    configGameWindows();
    //Evento que iniciara el juego
    $("#start").click(function () {
        start();
        
    });
    

});







function configGameWindows() {

    //TODO Dibujar en el DOM Ventana de configuracion, permite selecionar nivel y tematica Rellenar los dos menus con los datos recibidos del metodo Partida.getAllAvailableConfig(url)
    //Por defecto vendra ya seteado con la tematica y nivel del objeto partida
    //TODO Se ejecutara como primera instrucion del document ready del script, el script debera parar la ejecucion hasta que se clicque en el boton aceptar(Controlar con evento, el id del boton sera "start")
    //TODO si se cambia el nivel y tematica por defecto deberemos setear esos canvios en nuestro objeto partida

}


function start() {
    //TODO Main del juego, lo primero que hara sera obtener la array dataLibrary con el metodo estatico getLibraryMedia(url) del JS ModelJuego.js
    //Mas detalles sobre el array obtenido en la definicion del metodo.
    
    //TODO Teniendo ya todos los assest programar el juego en si. El tema del control de variables estaticas del objeto partida sera controlado por la funcion StatisticsPartida()
    //y debera ser llamado por esta funcion una vez el juego se haya dibujado.

    //TODO Las variables de tiempo del objeto partida seran controladas por la funcion timers() y tambien debera ser llamada desde esta funcion.

    //TODO acabar el juego de alguna forma (por ejemplo con la variable que he dejado en el apartado Globals) y enviar el objeto partida al servidor con
    //el metodo estatico sendPartida(url) del JS ModeloJuego.js

    

}


function statisticsPartida() {

    //TODO es un funcion de la que aun no tengo el codigo, la esta haciendo Albert basicamente sera un Catcher de los eventos del juego y se encargara de gestionarlo
    //osea updateara las propiedades del objeto partida (Menos las de tiempo que seran controladas por timers())


}


function timers() {

    //TODO Como su nombre indica sera un temporizador del tiempo
    //Updateara las variables con referencia al tiempo del objeto partida
    //Implementarlo como querais (Set interval... etc)
    //Pero la salida de las variables deben estar en milisegundos "ms"

}



