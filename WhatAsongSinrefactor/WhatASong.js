

//Globals
var assets="./assets/Tematicas/Granja/";

//Variable que contiene la ID del sonido a acertar
var elecion=null;

//Objetos que se deberian obtener por ajax con los metodos de ModelJuego.js
var partida=null;
var dataLibrary=[];

//Bucle Interval utilizado por timers()
var x=null;

//Carga manual del objeto partida
var ObjPartida={};
ObjPartida.id_partida=1;
ObjPartida.tiempoReaccion=0;
ObjPartida.tiempoTotal=0;
ObjPartida.cliks=0;
ObjPartida.fallos=0;
ObjPartida.aciertos=0;
ObjPartida.tematica=1;
ObjPartida.nivel=1;
ObjPartida.velocidad=null;
ObjPartida.comentario="";
ObjPartida.numImgTotal=null;
ObjPartida.parejasValidas=null;
ObjPartida.imagenesDiferentes=null;
ObjPartida.repeticionesSonido=0;
ObjPartida.numeroSonidos=null;
ObjPartida.imagenesIniciales=null;
ObjPartida.imagenesFinales=null;

partida=new Partida(ObjPartida);



//Carga manual de la libreria de Assets
ObjMedia1={};
ObjMedia1.idMedia=1;
ObjMedia1.url_img=assets+"Caballo/Caballo.png";
ObjMedia1.url_sonido_escuchado=assets+"Caballo/Caballo.ogg";
ObjMedia1.url_sonido_hablado=assets+"Caballo/CaballoT.ogg";

ObjMedia2={};
ObjMedia2.idMedia=2;
ObjMedia2.url_img=assets+"Cerdo/Cerdo.png";
ObjMedia2.url_sonido_escuchado=assets+"Cerdo/Cerdo.ogg";
ObjMedia2.url_sonido_hablado=assets+"Cerdo/CerdoT.ogg";


ObjMedia3={};
ObjMedia3.idMedia=3;
ObjMedia3.url_img=assets+"Gallo/Gallo.png";
ObjMedia3.url_sonido_escuchado=assets+"Gallo/Gallo.ogg";
ObjMedia3.url_sonido_hablado=assets+"Gallo/GalloT.ogg";


ObjMedia4={};
ObjMedia4.idMedia=4;
ObjMedia4.url_img=assets+"Vaca/Vaca.png";
ObjMedia4.url_sonido_escuchado=assets+"Vaca/Vaca.ogg";
ObjMedia4.url_sonido_hablado=assets+"Vaca/VacaT.ogg";

dataLibrary.push(new Media(ObjMedia1));
dataLibrary.push(new Media(ObjMedia2));
dataLibrary.push(new Media(ObjMedia3));
dataLibrary.push(new Media(ObjMedia4));


//Indica la ronda (Maximo 10 rondas)
var rondas=10;

//Main
$(document).ready(function () {
    //Imprimo contenedor principal
    drawcontainer();
    //Dibujo la ventana de configuracion;
    configGameWindows();
    //Imprimo ventana de debug
    debug();

    //Evento que iniciara el juego
    $("#start").click(function () {
        //Seteo el objeto partida con el Nivel y tematica selecionados
        partida.nivel=$("#Nivel").val();
        partida.tematica=$("#Tematica").val();
        //Inicio el Juego
        start();
        //Lanzo mi cazador de eventos
        stadistics();

    });


    

});


function drawcontainer() {
    //Creo mi contenedor (Tanto si es DIV como CANVAS) y lo añado al body
    var container=document.createElement("div");
    container.id="container";
    $(container).css("width", "800");
    $(container).css("height", "600");
    $(container).css("border","5px gray dotted");
    $(container).css("margin-left","auto");
    $(container).css("margin-right","auto");
    document.body.appendChild(container);

}


function configGameWindows() {

    //Dibujo en pantalla ventana de configuracion del juego
    var config=document.createElement("div");
    config.id="config";
    $(config).css("width", "400");
    $(config).css("height", "300");
    $(config).css("background-color","#B8B8B8");
    $(config).css("margin-left","auto");
    $(config).css("margin-right","auto");
    $(config).css("margin-top","120px");
    $(config).css("text-aling","center");

    //Se cargara dinamicamente con datos del servidor
    $(config).html('<center><label>Nivel</label><br><select id="Nivel"><option value="1">Nivel 1</option></select><br><label>Tematica</label><br><select id="Tematica"><option value="1">Granja</option></select><br><br><br><button id="start">Comenzar</button></center>');
    $(config).appendTo("#container");

}

function debug() {
    //Imprime un Div monitorizando las variables de la partida
    var debug=document.createElement("div");
    debug.id="debug";
    $(debug).css("width", "300");
    $(debug).css("height", "300");
    $(debug).css("border","5px gray dotted");
    $(debug).css("margin-left","auto");
    $(debug).css("margin-right","auto");
    document.body.appendChild(debug);
}
function stadistics() {
    //Controla las estadisticas, escuchando los eventos del raton y el teclado
    mouseEvent();
    keyboardEvent();
}


function mouseEvent() {

    //Handle global evento click() para las imagenes
    $(document).click(function(event) {
        
        $(event.target).closest("img").each(function() {

            //Control Clicks y tiempo de reacion
            if(partida.cliks==0) partida.tiempoReaccion=partida.tiempoTotal;
            partida.cliks++;

            //Control de repeticiones de sonido

            if(this.className=="sonido")partida.repeticionesSonido++;


            //Control aciertos y fallos

            if(this.className!="sonido"){
                var id_sonido=$(".sonido").get(0).id.split("_");
                id_sonido=id_sonido[1];



                if(id_sonido==this.id){
                    partida.aciertos++;
                    rondas--;
                    clearInterval(x);
                    start();
                }
                else partida.fallos++;

            }



        });
    });
}

function keyboardEvent() {


    //HAcer que vaya por teclado XD


}

function start() {
    if(rondas<=0){
        fin();
    }else {
        //Mezclo los assets
        dataLibrary=shuffle(dataLibrary);
        //Saco 3 elementos
        round=dataLibrary.slice(0,3);

        //Los imprimo
        imprimirAssets(round);
        //Controlo el tiempo
        timers();
    }


}

function fin() {
    $("#container").empty();

    var fin=document.createElement("div");
    fin.id="fin";
    $(fin).css("width", "400");
    $(fin).css("height", "300");
    $(fin).css("background-color","#B8B8B8");
    $(fin).css("margin-left","auto");
    $(fin).css("margin-right","auto");
    $(fin).css("margin-top","120px");
    $(fin).css("text-aling","center");

    //Faltaria un evento que controlase el boton e envie el objeto partida al servidor
    $(fin).html('<center></center><h1>Partida finalizada</h1><br><br><button>Enviar datos</button></center>');
    $(fin).appendTo("#container");

}

function imprimirAssets(round) {

    //Borro la pantalla
    $(container).empty();

    //Recorro el array y dibujo los assets y los controles adicionales
    round.forEach(function (value,key) {


        var img=document.createElement("img");
        img.src=value.url_img;
        img.setAttribute("id", key);
        $(img).css("display","block");
        $(img).css("float","left");
        $(img).css("padding-left","80px");
        $(img).css("padding-top","120px");
        container.appendChild(img);

        if(value.url_sonido_escuchado!=null){
            var audio1=document.createElement("audio");
            audio1.canPlayType("audio/ogg");
            audio1.setAttribute("src",value.url_sonido_escuchado);
            audio1.setAttribute("id", key+"S");
            container.appendChild(audio1);

        }


        if(value.url_sonido_hablado!=null){
            var audio2=document.createElement("audio");
            audio2.canPlayType("audio/ogg");
            audio2.setAttribute("src",value.url_sonido_hablado);
            audio2.setAttribute("id", key+"T");
            container.appendChild(audio2);
        }




    });

    //Elijo el sonido a acertar y genero el boton
    elecion=getRandomArbitrary(0,2);

    var playicon=document.createElement("img");
    playicon.src="./assets/Generals/play.png";
    playicon.id="play_"+elecion;

    $(playicon).addClass("sonido");
    $(playicon).css("margin-left","auto");
    $(playicon).css("margin-right","auto");

    container.appendChild(playicon);

    $("#play_"+elecion).click(function () {

        $("#"+elecion+"S").get(0).play()


    });

}






function timers() {

    //Contador de tiempo
    x = setInterval( function(){

        partida.tiempoTotal++;
        $("#debug").html("<span>Tiempo Total:"+partida.tiempoTotal+"</span><br><span>Tiempo Reacion:"+partida.tiempoReaccion+"</span><br><span>Clicks:"+partida.cliks+"</span><br><span>RepeticionesSonido:"+partida.repeticionesSonido+"</span><br><span>Aciertos:"+partida.aciertos+"</span><br><span>Fallos:"+partida.fallos+"</span>");

    },1000);



}




//Tipycall random int
function getRandomArbitrary(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

//Funcion de un pavo porque la mierda de JS no tiene un puto shuffle
function shuffle(arra1) {
    var ctr = arra1.length, temp, index;

// While there are elements in the array
    while (ctr > 0) {
// Pick a random index
        index = Math.floor(Math.random() * ctr);
// Decrease ctr by 1
        ctr--;
// And swap the last element with it
        temp = arra1[ctr];
        arra1[ctr] = arra1[index];
        arra1[index] = temp;
    }
    return arra1;
}








