//La idea es que recibiremos del servidor una SuperArray like DataBag[] por ajax i cada indice de esta contendra un Array que almacenara
//Bloques comunes de informacion.

//DataBag["Parameters"] Contendra los datos necesarios para crear un objeto Parameters (Es decir los datos estadisticos de la partida)
//DataBag[1] Contendra un Array de Objetos Media(Array de dos Strings con las rutas de la imagen y su sonido), cada objeto Media
//Seran almacenado en una Array Global que llamaremos LibraryMedia para poder acceder a las imagenes mas comodamente


//Constructores de los objetos que usuaremos en el juego



//Clase que permite Instanciar un Modelo que puede recojer los datos de una partida, e
function Parameters(id_partida,clics,time_reaction,total_time,fails,aciertos,comentario,num_img_total,parejas_validas,nivel,tematica,imagenes_dif,repeticiones_sonido,num_sonidos,imagenes_ini,imagenes_finales,velocidad) {
    this.id_partida=id_partida;
    this.clics = clics;
    this.time_reaction = time_reaction;
    this.total_time = total_time;
    this.fails = fails;
    this.aciertos=aciertos;
    this.comentario=comentario;
    this.num_img_total=num_img_total;
    this.parejas_validas=parejas_validas;



    //el resto de variables
}

function Media(img,song){

    this.img=img;
    this.song=song;

}



parametros=new Parameters();

//La idea es que recibiremos del servidor una SuperArray like DataBag[] i uno de sus in
//
// [[Object Media{img,song}],[Object Media{img,song}]...etc]









window.onload = function(){

    var ctx=getCanvas("mycanvas");

    if(ctx){
        ctx.fillStyle='#6666FF';
        ctx.fillRect(0,0,100,100);
        ctx.fillStyle='yellow';
        ctx.fillRect(50,50,100,100);





    }else{
        alert("No obtuve el canvas");
    }




};

function getCanvas(identificador) {

    var lienzo = document.getElementById(identificador);
    if(lienzo && lienzo.getContext("2d")){
        var ctx=lienzo.getContext("2d");
        if(ctx)return ctx;
    }else return false;

}
