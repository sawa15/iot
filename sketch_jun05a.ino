void setup()
{
  pinMode(A0, INPUT);
  pinMode(13, OUTPUT);
  Serial.begin(115200);
}

void loop()
{
  /*Адрес устройства*/
  String addr = "01";
  /*С какого момента включать насос*/
  int limit = 300;
  
  int moisture = analogRead(A0);

  /*Симуляция отправки данных на сервер*/
  Serial.print("addr=");
  Serial.print(addr);
  Serial.print("&moisture=");
  Serial.println(moisture);

  /*Управление клапаном капельного полива (симуляция)*/
  if (moisture < 200)
  {
    digitalWrite(13, HIGH);
  }
  else if (moisture > 800)
  {
    digitalWrite(13, LOW);
  }
  random(10, 20);
  delay(24*60*60*1000);
}
