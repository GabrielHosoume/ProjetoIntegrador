
#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>


// Define a URL do HOST
#define HOST "univesppi.000webhostapp.com"    
#define WIFI_SSID "GTH"                               
#define WIFI_PASSWORD ""


// Variáveis que serão enviadas ao servidor
int corrente = 3;
int tensao = 127;
float  potencia = corrente*tensao;
String sendcorrente, sendtensao, sendpotencia, postData;


void setup() {

     
Serial.begin(115200); 
Serial.println("Comunicação iniciada \n\n");  
delay(1000);
Serial.println("pot = " + String(potencia));  

pinMode(LED_BUILTIN, OUTPUT);     // liga o led da placa
 


WiFi.mode(WIFI_STA);           
WiFi.begin(WIFI_SSID, WIFI_PASSWORD);                                     
Serial.print("Conectando a ");
Serial.print(WIFI_SSID);
while (WiFi.status() != WL_CONNECTED) 
{ Serial.print(".");
    delay(500); }

Serial.println();
Serial.print("Conectado a ");
Serial.println(WIFI_SSID);
Serial.print("IP: ");
Serial.println(WiFi.localIP()); 

delay(30);
}



void loop() { 

HTTPClient http; 


// Convertendo as variáveis int para string
sendcorrente = String(corrente);  
sendtensao = String(tensao);   
sendpotencia = String(potencia);
 
postData = "sendcorrente=" + sendcorrente + "&sendtensao=" + sendtensao + "&sendpotencia=" + sendpotencia;


// Atualizando a URL do Host  
WiFiClient clientt;
http.begin(clientt, "http://univesppi.000webhostapp.com/escreveBanco.php");              
http.addHeader("Content-Type", "application/x-www-form-urlencoded");     
  
 
int httpCode = http.POST(postData); 
Serial.println("Valores, sendcorrente = " + sendcorrente + " and sendtensao = "+sendtensao + "and sendpotencia = 0" + sendpotencia);


// Se a conexao for estabelecida
if (httpCode == 200) { 
  Serial.println("Upload realizado com sucesso."); Serial.println(httpCode); 
  String webpage = http.getString();  
  Serial.println(webpage + "\n"); 
}

// Se houve falha na conexao, retorna e reinicia
else { 
  Serial.println(httpCode); 
  Serial.println("Falha no upload. \n"); 
  http.end(); 
  return; }


delay(3000); 
digitalWrite(LED_BUILTIN, LOW);
delay(3000);
digitalWrite(LED_BUILTIN, HIGH);

}
