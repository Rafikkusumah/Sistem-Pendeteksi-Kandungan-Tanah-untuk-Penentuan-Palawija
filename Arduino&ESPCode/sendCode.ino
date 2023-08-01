#include <SoftwareSerial.h>
#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>

// Replace with your network credentials
const char* ssid = "Your SSID";
const char* password = "YourPasswordSSID";
SoftwareSerial espSerial(2,3); // Pin 2 digunakan sebagai RX, Pin 3 sebagai TX

void setup() {
  espSerial.begin(115200);
  Serial.begin(115200);

  // Connect to WiFi
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println("Connecting to WiFi...");
  }
  Serial.println("Connected to WiFi");
}

void loop() {
  if (espSerial.available()){
    String data = espSerial.readStringUntil('\n');
    int index = data.indexOf("#");
    float temperature = data.substring(0, index).toFloat();
    data.remove(0, index + 1);
    index = data.indexOf("#");
    int soilMoisture = data.substring(0, index).toInt();
    float pHMeter = data.substring(index + 1).toFloat();
    Serial.print("temperature :");
    Serial.println(temperature);
    Serial.print("soilMoisture :");
    Serial.println(soilMoisture);
    Serial.print("pHMeter :");
    Serial.println(pHMeter);
    delay(2000);

    //=======================================
  
  if(temperature == 0){
   Serial.print("temperature error");
  }else{
    if ((WiFi.status() == WL_CONNECTED)) {
    WiFiClient client;
    HTTPClient http;
    
    String address;

    address ="http://monitoringpalawija.my.id/monitoring/webapi/api/create.php?suhu=";
    address += String(temperature);
    address += "&kelembaban="; 
    address += String(soilMoisture);
    address += "&ph="; 
    address += String(pHMeter) ;
      
    http.begin(client,address);  //Specify request destination
    int httpCode = http.GET();//Send the request
    String payload;  
    if (httpCode > 0) { //Check the returning code    
        payload = http.getString();   //Get the request response payload
        payload.trim();
        if( payload.length() > 0 ){
           Serial.println(payload + "\n");
        }
    }
    
    http.end();   //Close connection
  }else{
    Serial.print("Not connected to wifi ");Serial.println(ssid);
  }
  }
  delay(2000); //interval 60s
   }
}
