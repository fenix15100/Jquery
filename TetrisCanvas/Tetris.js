const canvas=document.getElementById('Lienzo');
const context=canvas.getContext('2d');

context.scale(20,20);


//Tablero del juego
const windowsGame= crearMatriz(12,20);

//Objeto jugador {Pieza tetris+su posicion en tablero+Puntuacion}
const jugador ={
    pos:{x:0,y:0},
    matriz:null,
    puntos:0
};

//Array con colores para las piezas

const colores=[null,'#FFD700','#8A2BE2','#00FF7F','#FF1493','#FF0000','#00BFFF','#A52A2A'];

//Variables utilizadas por la funcion updateframe()
//Contador de caida de una pieza hacia abajo
let dropCounter=0;
//Segundos en el que cae una pieza hacia abajo
let dropInterval=1000;
let lasttime=0;


//Devuelve un array de 2 dimesiones inicializada a 0
function crearMatriz(w,h) {
    const matriz=[];
    while (h--){
        matriz.push(new Array(w).fill(0));
    }
    return matriz;

}

function crearPieza(tipo) {

    if(tipo==='T'){
        return [
            [0,0,0],
            [1,1,1],
            [0,1,0]

        ];
    }else if(tipo==='O'){
        return [
            [2,2],
            [2,2]
        ];
    }else if(tipo==='L'){
        return [
            [0,3,0],
            [0,3,0],
            [0,3,3]
        ];
    }else if(tipo==='J'){
        return [
            [0,4,0],
            [0,4,0],
            [4,4,0]
        ];
    }if(tipo==='I'){
        return [
            [0,5,0,0],
            [0,5,0,0],
            [0,5,0,0],
            [0,5,0,0]

        ];
    }else if(tipo==='S') {
        return [
            [0, 6, 6],
            [6, 6, 0],
            [0, 0, 0]
        ];
    }else if(tipo==='Z') {
        return [
            [7, 7, 0],
            [0, 7, 7],
            [0, 0, 0]
        ];
    }

    
}



//Dibuja en pantalla una Matriz en la posicion del canvas indicada
function dibujaMatriz(matriz,offset) {

    matriz.forEach(function (row,y) {

        row.forEach(function (col,x) {
            if(col!==0){
                context.fillStyle=colores[col];
                context.fillRect(x+offset.x,y+offset.y,1,1);
            }


        });
    });

}

//RotarMatriz=Transpose+Reverse
//Funcion que permite girar las piezas de tetris lo he tenido que buscar
//he implementar mi version (entiendo el concepto y cuando lo hace pero se me va un poco)
//Por mis falta de conocimiento de Mates XD
function rotarMatriz(pieza,direction) {

    //Transposicion
    for(y=0;y<pieza.length;++y){
        for(x=0;x<y;++x){
            [pieza[x][y],pieza[y][x]]=[pieza[y][x],pieza[x][y]];
        }
    }

    //Reverse

    if(direction>0){
        pieza.forEach(function (fila) {
           fila.reverse();
        });
    }else{
        pieza.reverse();
    }


}

//Funcion principal que se encarga de dibujar el canvas
function dibujar() {
    context.fillStyle='black';
    context.fillRect(0,0,canvas.width,canvas.height);
    //Dibuja tablero
    dibujaMatriz(windowsGame,{x:0,y:0});
    //Dibuja pieza
    dibujaMatriz(jugador.matriz,jugador.pos);
}




//Updatea las posiciones de gamewindows de 0 a 1 en las posiciones pasadas por la pieza dibujada
//A nivel de canvas ya se dibujan las piezas sobre el tablero pero se hace a nivel de Array para
//Poder calcular las colisiones con la funcion colisiones
function merge(windowsGame,jugador) {

    jugador.matriz.forEach(function (fila,y) {

        fila.forEach(function (col,x) {
           if(col!==0){
               windowsGame[y+jugador.pos.y][x+jugador.pos.x]=col;

           }

        });

    });


}

//Calcula las colisiones del juego, Copiado vilmente es una fumada XD
function colisiones(windowsGame,jugador) {

    const m=jugador.matriz;
    const o=jugador.pos;

    for(y=0;y<m.length;++y){
        for(x=0;x<m[y].length;++x){
            if(m[y][x]!==0 && (windowsGame[y+o.y]&& windowsGame[y+o.y][x+o.x])!==0){
                return true;
            }

        }
    }
    return false;


}


//Limpia row de tablero si esta esta llena  de elementos que no son 0 (Piezas) y baja lo que hubiera arriba
//Ademas actualiza la puntuacion del jugador

function limpiaLinea() {


    //Itera desde abajo la matriz del tablero en busca de Lineas completas
    externo: for(y= windowsGame.length -1; y>0;--y){
        for(x=0;x<windowsGame[y].length;++x){
            //Si una de las celdas de la row es 0 no hay linea completa
            //Dejo de iterar la fila y continuo con la siguiente
            if(windowsGame[y][x]===0){
                continue externo;
            }
        }

        //Si llego aqui significa que la fila esta completa
        //Creo una row vacia en la posicion iterada y se la meto al tablero
        const fila=windowsGame.splice(y,1)[0].fill(0);
        windowsGame.unshift(fila);
        //Bajo las piezas superiores
        ++y;

        //Controlo la puntuacion
        let filacount=1;
        //La puntuacion basica son 10 puntos
        jugador.puntos+=filacount*10;
        //Por cada fila borrada a la vez se multiplica por 2 la puntuacion
        filacount*=2;

    }

}



//Controla el movimiento de la pieza hacia abajo y su comportamiento al colisionar
function jugadorDrop() {
    jugador.pos.y++;
    //Si la pieza toca el final del canvas hacia abajo o colisiona, aparece una nueva por arriba
    //Ademas si hay una linea completa se elimina
    if(colisiones(windowsGame,jugador)){
        jugador.pos.y--;
        //Actualiza a nivel de array las cordenadas de jugador sobre tablero
        merge(windowsGame,jugador);
        //Nos da una nueva Pieza al colisionar
        jugadorReset();
        //Comprueba si hay lineas completas en el tablero
        limpiaLinea();

        //Updatea el score en pantalla
        punticos();

    }

    dropCounter=0;
}

//Elije y posiciona una nueva pieza despues de que la actual haya sufrido colision
//Ademas limpia la pantalla y la puntuacion(Pierdes) si una pieza colisiona con el borde superior de tablero

function jugadorReset() {
    const piezas='ILJOTSZ';
    jugador.matriz=crearPieza(piezas[piezas.length*Math.random()| 0]);
    jugador.pos.y=0;
    jugador.pos.x=(windowsGame[0].length/2|0)-(jugador.matriz[0].length/2|0);

    if(colisiones(windowsGame,jugador)){
        windowsGame.forEach(function (fila) {
           fila.fill(0);
           jugador.puntos=0;
           punticos();


        });
    }

}

//Controla el movimiento hacia los lados (Es llamada desde el catcher de eventos de abajo)
function jugadorMove(direction) {
    jugador.pos.x+=direction;
    if(colisiones(windowsGame,jugador)){
        jugador.pos.x-=direction;
    }
    
}

//Controla la rotacion de la pieza del jugador (Es llamada desde el catcher de eventos de abajo)

function jugadorRotate(direction) {
    rotarMatriz(jugador.matriz,direction);

    //Fumadita inspirada para evitar rotar la pieza fuera del tablero,
    // si pasa se desplaza en direcion contraria al borde
    const pos=jugador.pos.x;
    let offset=1;
    while(colisiones(windowsGame,jugador)){
        jugador.pos.x+=offset;
        //IF ternario
        offset= -(offset+(offset>0 ? 1: -1));
        if(offset>jugador.matriz[0].length){
            rotarMatriz(jugador.matriz,-direction);
            jugador.pos.x=pos;
            return;
        }



    }
    
}


//Bucle main del juego, estabiliza el framerate y utiliza esos calculos para que la pieza
//baje hacia abajo en cada Frame
function updateframe(time = 0) {
    const deltatime=time-lasttime;
    lasttime=time;
    dropCounter+=deltatime;
    //Hace caer la pieza en cada frame
    if(dropCounter>dropInterval){
        jugadorDrop();
    }
    //Dibuja el Canvas
    dibujar();
    //Funcion preparara para hacer bucles como set interval pero respetando el framerate del canvas
    requestAnimationFrame(updateframe);

}

//Autoexplicable XD
function punticos() {

    document.getElementById('Puntos').innerText=jugador.puntos;

}



//Control de eventos por teclado del juego
document.addEventListener('keydown', function (event) {

    if(event.keyCode===37){
        jugadorMove(-1);
    }else if (event.keyCode===39){
        jugadorMove(1);
    }else if (event.keyCode===40){
        jugadorDrop()
    }else if (event.keyCode===88){
        jugadorRotate(-1);
    }else if(event.keyCode===67){
        jugadorRotate(1);
    }


});

//Las ejecutamos para que nos de la primera pieza, y la puntuacion inicial despues se llama desde el bucle
jugadorReset();
punticos();
//Main Loop
updateframe();






