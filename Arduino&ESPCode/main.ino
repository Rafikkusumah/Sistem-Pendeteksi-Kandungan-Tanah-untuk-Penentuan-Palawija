#include <OneWire.h>
#include <DallasTemperature.h>

const int soilMoisturePin = A1;     // Sensor Soil Moisture Berada di Pin A1
const int pHMeterPin = A2;          // Sensor PH Meter Berada di Pin A2
const float temperaturePin = 7;     // Sensor DS18B20 Berada di Pin Digital Nomor 7

int soilMoistureValue = 0;          // Digunakan untuk menampung data dari Soil Moisture Sensor
int pHMeterValue = 0;               // Digunakan untuk menampung data dari Sensor PH Meter

// Melakukan Inisialisasi Menggunakan Library oneWire Untuk Sensor DS18B20 (Sensor Suhu)
OneWire oneWire(temperaturePin);
DallasTemperature sensors(&oneWire);

void setup() {
  Serial.begin(115200);               // Memulai Inisialisasi Serial pada Baudrate 115200
  sensors.begin();                    // Mamulai / Menyalakan Sensor DS18B20
}

void loop() {
  // Soil Moisture Sensor
  soilMoistureValue = analogRead(soilMoisturePin);                // Membaca Data dari Soil Moisture Sensor 
  int soilMoisturePercent = (soilMoistureValue / 1023.0) * 100;   // Mengubah Data yang Didapatkan dari Sensor Menjadi Persen (%)

  // pH meter value
  float pHMeterValue = analogRead(pHMeterPin)* 5.0 / 1024;        // Membaca Data dari PH Meter Dan melakukan Kalibrasi Data

  // Temperature value
  sensors.requestTemperatures();                                  // Melakukan/Meminta untuk Pembacaan Sensor
  float temperature = sensors.getTempCByIndex(0);

  String datakirim = String (temperature) + "#" + String(soilMoisturePercent) + "#" + String(pHMeterValue);
  Serial.println(datakirim);
}
