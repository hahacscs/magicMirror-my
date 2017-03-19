#include <stdio.h>
#include <string.h>
#include <errno.h>
#include <stdlib.h>
#include <unistd.h>
#include <wiringPi.h>

#include <unistd.h>
#include "iostream"
#include <opencv2/core/core.hpp>
#include <opencv2/highgui/highgui.hpp>
#include <opencv2/imgproc/imgproc.hpp>
using namespace std;
using namespace cv;

// What GPIO input are we using?
//      This is a wiringPi pin number

#define BUTTON_PIN      0

static volatile int globalCounter = 0 ;

Mat image(3,3,CV_32F);

char* filename = "./log.txt";
char* fomat = "a+";

FILE* fp = fopen(filename,fomat);
int intflg = 0;

void myInterrupt (void)
{
  printf (" work is begin\n") ;
  fprintf (fp," work is begin\n") ;
  ++globalCounter ;
  
  pinMode (0, INPUT) ;
  int read = digitalRead (0) ;      // On
  printf("%d\r\n",read);
	fprintf (fp,"%d\r\n",read) ;
	if(read == intflg){return ;}
	intflg = read;
    
  imwrite("/var/www/html/workspace/test/controller/currentImg.jpg",image);
  sleep(0.5);
	system("php /var/www/html/workspace/test/controller/generText.php >> /var/www/html/workspace/test/controller/generlog.txt 2>&1");
  printf (" work is done\n") ;
  fprintf (fp," work is done\n") ;
  fflush (fp) ;
}

void dowork(FILE* fp,Mat image)
{
  imwrite("./currentImg.jpg",image);
  sleep(0.5);
	system("php generText.php");
  printf (" work is done\n") ;
  fprintf (fp," work is done\n") ;
    fflush (fp) ;
}


int main (void)
{
	//FILE* fp = fopen("./log.txt","a+");
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

/*
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
*/

 
    Mat frame;
    //Mat edges;
		
		sleep(6.5);
    VideoCapture cap(0);
    if (!cap.isOpened())//检测是否打开
    {
        return -1;
    }
    bool stop = false;
    namedWindow("当前视频",0);
    cvMoveWindow("当前视频",0,0);


    cvResizeWindow("当前视频",300,300);
    while (!stop)
    {
        cap >> frame;
        //edges = frame;
				//imwrite("./currentImg.jpg",edges);
        //cvtColor(frame, edges, CV_BGR2GRAY);
        //GaussianBlur(edges, edges, Size(7, 7), 1.5, 1.5);
        //Canny(edges, edges, 0, 30, 3);
        flip(frame,image,0);
        imshow("当前视频", image);

		    if (myCounter != globalCounter){
		    printf (" Done. counter: %5d\n", globalCounter) ;
		  	fprintf (fp," Done. counter: %5d\n", globalCounter) ;
		    fflush (fp) ;
		    //cap.release();
		    //dowork(fp,frame);
		    //cap.open(0);
		    myCounter = globalCounter ;
		  }

        if (waitKey(30) >= 0)
            stop = false;
    }
    
  return 0 ;
}
