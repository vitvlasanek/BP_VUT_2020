//Volání příslušných knihoven
#include <WiFi.h>
#include <HTTPClient.h>
#include <Wiegand.h>
WIEGAND wg;
HTTPClient http;

//definice pinů DATA0 a DATA1 pro wiegand
const int PIN_D0 = 32;
const int PIN_D1 = 33;
const int beeper = 14;
const int led_gr = 26;
const int lvlchanger_power = 25;
const int relay = 27;
const int door = 16;
const int tamper = 34;

//nastavení času v sekundáchs
const int waiting_time = 10;
const int open_time = 5;
const int alarm_time = 30;
const int admin_time = 120;

//definice dalších informací
String server_pwd = "44ff56";
String doorLocation = "TEST";
String adminTag = "0";

//proměnné síťového připojení
const char* ssid     = "nazev_site";
const char* password = "heslo";
String serverName = "http://192.168.1.26/";
String serverPost = serverName + "post.php";
String serverGet = serverName + "get.php?door=" + doorLocation;

//inicializace programu
void setup() {
  
  //Nastavení pinů I/O
  pinMode(beeper, INPUT);
  pinMode(led_gr, INPUT);
  pinMode(lvlchanger1_power, OUTPUT);
  pinMode(door, INPUT);
  pinMode(relay, OUTPUT);
  pinMode(tamper, INPUT);

  //nastavení hodnot na pinech
  digitalWrite(lvlchanger_power,HIGH);
  digitalWrite(relay, LOW);
  
  //nastavení seriového monitoru
  Serial.begin(115200);
  Serial.println("\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n");
  wg.begin(PIN_D0,PIN_D1);
  delay(500); 
  
  //Připojení k bezdrátové síti
  WiFi.begin(ssid, password);  
  while (WiFi.status() != WL_CONNECTED) {
    delay(2500);
    Serial.print("Připojování k WiFi... ");
  }
  Serial.print("\nWiFi připojena, IP: \t");
  Serial.println(WiFi.localIP());
  Serial.println("Systém připraven");

}

//cyklus programu
void loop() {
  //Spuštění alarmu v případě otevřených dveří
  if (digitalRead(door) == HIGH) {
    delay(500);
  while(digitalRead(door) == HIGH) {
    
    //zapsání informací o alarmu do databáze
    http.begin(serverPost);
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");
    String httpRequestData = "api_key=" + server_pwd + "&rfid=ALARM&door=" +doorLocation+ "";
    Serial.print("Server post: ");
    Serial.println(httpRequestData);
    int httpCodePost = http.POST(httpRequestData);
    
    //cyklus for alarmu
    for (int i=0; i<alarm_time; i++ ) {
      Serial.print("ALARM!... ");
      pinMode(led_gr, OUTPUT);
      pinMode(beeper, OUTPUT);
      delay(500);
      pinMode(led_gr, INPUT);
      pinMode(beeper, INPUT);
      delay(500);
      if((wg.available())&&(String(wg.getCode()) == adminTag)){
        break;
      }
    }
  }
  }

  //detekce manipulace čtečky
  if (digitalRead(tamper) == LOW){
    delay(500);
    if (digitalRead(tamper) == LOW){
      http.begin(serverPost);
      pinMode(beeper, OUTPUT);
      http.addHeader("Content-Type", "application/x-www-form-urlencoded");
      String httpRequestData = "api_key=" + server_pwd + "&rfid=ALARM&door=" +doorLocation+ "";
      Serial.print("Server post: ");
      Serial.println(httpRequestData);
      Serial.println("Tamper alarm...");
      int httpCodePost = http.POST(httpRequestData);
      while (1){
        if((wg.available())&&(String(wg.getCode()) == adminTag)){
          break;
        }
      }
    }
  }

    pinMode(beeper, INPUT);
 
    //Cyklus při přiložení RFID tagu
    if(wg.available()){
     Serial.println("\nWiegand... ");
     Serial.println("Typ = \t\t\t\t" + String(wg.getWiegandType()) + "");
     Serial.println("Binární = \t\t\t" + String(wg.getCode(),BIN) + "");
     Serial.println("Decimální = \t\t\t" + String(wg.getCode()) + "");
     
     //cyklus pro admin tag (bez připojení)
     if (String(wg.getCode()) == adminTag){
      digitalWrite(relay, HIGH);
      pinMode(led_gr, OUTPUT);
        for (int i=0; i<admin_time; i++ ) {
                if(digitalRead(door) == LOW) {
                  Serial.print("Čekání na operaci administrátora... ");
                  delay(1000);
                 }
                 while(digitalRead(door) == HIGH) {
                  delay(1000);
                 }
                 while (digitalRead(tamper) == HIGH){
                  delay(10000);
                 }
                 
      delay(100);
      digitalWrite(relay, LOW);
      pinMode(led_gr, INPUT);
      }
    }
    
    //cyklus pro ostatní tagy
    else {
     if(WiFi.status()== WL_CONNECTED) {
      
      //připojení k adrese serveru
      http.begin(serverPost);
      http.addHeader("Content-Type", "application/x-www-form-urlencoded");
      Serial.println("\nOdesílání informace o tagu... ");
      
      //http.POST
      String httpRequestData = "api_key=" + server_pwd + "&rfid=" + String(wg.getCode()) + "&door=" +doorLocation+ "";
      Serial.print("Server post: \t\t");
      Serial.println(httpRequestData);
      int httpCodePost = http.POST(httpRequestData);
        if (httpCodePost>0) {
          Serial.print("http odpověď:\t\t");
          Serial.println(httpCodePost);
        }
        else {
          Serial.print("http chyba:\t\t");
          Serial.println(httpCodePost);
        }
        http.end();
        
        //Odpověď serveru
        http.begin(serverGet);
        Serial.println("");
        Serial.println("Získávání informací o přístupu... ");
        int httpCodeGet = http.GET();      
        if (httpCodeGet > 0) {
          String acc_status = http.getString();
          Serial.print("HTTP odpověď:\t\t");
          Serial.println(httpCodeGet);
          Serial.println("Ověřuji přístup... "); 
          Serial.print("Přístup:\t\t\t");   
               
          //otevření dveří při kladné odpovědi
          if (acc_status == "1 ") {
            pinMode(led_gr, OUTPUT);
            Serial.println("Povolen");
            Serial.println("\nDveře:");
            digitalWrite(relay, HIGH);
            
              //čekání na otevření dveří
              for (int i=0; i<waiting_time; i++ ) {
                if(digitalRead(door) == LOW) {
                  Serial.print("Čekání na vstup... ");
                  delay(1000);
                }
              }
            delay(100);
              if(digitalRead(door) == HIGH) {
                Serial.println("\nDveře otevřeny");
                digitalWrite(relay, LOW);
                
                //čekání na zavření dveří
                for (int i=0; i<open_time; i++ ) {
                    Serial.print("Vstupování... ");
                    delay(1000);
                    if(digitalRead(door) == LOW) {
                      Serial.println("\nDveře zavřeny");
                      break;
                    }
                }
                Serial.print("\n");

                //zvukový signál,upozorňující na otevřené dveře
                while(digitalRead(door) == HIGH) {
                  delay(1000);
                  Serial.print("Zavřete dveře... ");
                  pinMode(beeper, OUTPUT);
                }
                delay(100);
              }
              else {
                Serial.println("Čas na vstup vypršel");
                digitalWrite(relay, LOW);
                pinMode(beeper, OUTPUT);
                delay(500);
                pinMode(beeper, INPUT);
              }
              pinMode(beeper, INPUT);
              pinMode(led_gr, INPUT);
              
          }

          //zamítnutí přístupu
          else {
          Serial.println("Zamítnut"); 
          delay(50);
          }
        http.end();
        }
      else {
        Serial.println("HTTP chyba:\t\t(" + String(httpCodeGet) + ")");
      }
      Serial.println("\n");
     }    
    else {
      Serial.println("WiFi odpojena");
    }
  }
  }
}
