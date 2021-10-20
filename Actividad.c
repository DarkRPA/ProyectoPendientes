#include <stdlib.h>
#include <stdio.h>
#include <unistd.h>

/**
 * @brief 
 * @author Daniel Caparrós Durán
 * 
 * Este programa lo que hace es demostrar el funcionamiento de los diferentes procesos iniciados y comprobar el como se comportan
 * a la hora de acceder a la misma información 
 */
void main(){
    int numero_inicial = 10;

    printf("El numero base es %d\n", numero_inicial);

    //Creamos el hijo
    pid_t hijo = fork();

    //Se ha creado bien el hijo
    if(hijo == 0){
        numero_inicial -= 6;

        printf("El hijo tiene un resultado de: %d\n", numero_inicial);
    }else if(hijo == -1){
        printf("No se pudo crear bien el hijo");
        exit(-1);
    }else{
        //Esperamos a que el hijo termine
        wait(NULL);

        numero_inicial += 4;

        printf("El padre tiene un resultado de: %d\n", numero_inicial);
    }
}