#include <stdio.h>
#include <string.h>
#include <errno.h>
#include <stdlib.h>
#include <unistd.h>
#include <wiringPi.h>


// What GPIO input are we using?
//      This is a wiringPi pin number

#define BUTTON_PIN      0

static volatile int globalCounter = 0 ;



void myInterrupt (void)
{
  ++globalCounter ;
}

void dowork(FILE* fp)
{
	system("php generText.php");
  printf (" work is done\n") ;
  fprintf (fp," work is done\n") ;
    fflush (fp) ;
}


int main (void)
{
	FILE* fp = fopen("./log.txt","a+");
  int myCounter = 0 ;

  if (wiringPiSetup () < 0)
  {
    fprintf (stderr, "Unable to setup wiringPi: %s\n", strerror (errno)) ;
    return 1 ;
  }

  if (wiringPiISR (BUTTON_PIN, INT_EDGE_FALLING, &myInterrupt) < 0)
  {
    fprintf (stderr, "Unable to setup ISR: %s\n", strerror (errno)) ;
    return 1 ;
  }


  for (;;)
  {
    printf ("Waiting ... ") ;
    //fflush (fp); 
    fflush (stdout) ;
  	fprintf (fp,"Waiting ... \n") ;
    fflush (fp) ;
  	
    while (myCounter == globalCounter)
      delay (100) ;

    printf (" Done. counter: %5d\n", globalCounter) ;
  	fprintf (fp," Done. counter: %5d\n", globalCounter) ;
    fflush (fp) ;
    dowork(fp);
    myCounter = globalCounter ;
  }

  return 0 ;
}
