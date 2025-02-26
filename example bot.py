import requests
import json
import time
from g4f.client import Client
client = Client()
def send_message(message): # Mesaj gönderme fonksiyonu
    requests.get('http://localhost/api/send?token=67b89f860e381&msg=' + message)
    return

def get_message(context): # Mesaj alma fonksiyonu

    if context['msg'].startswith("/ai"):
        print('AI komutu algılandı: ' + context['msg'][4:])
        response = client.chat.completions.create(
            model="gpt-4o",
            messages=[
                {
                "role": "user", "content": context['msg'][4:] 
                }
            ],
        )
        
        send_message(response.choices[0].message.content)
    return


print('Bot başlatıldı. Mesajları kontrol ediliyor...')
while True:
    x = requests.get('http://localhost/api/get?token=67b89f860e381')
    time.sleep(5)
    y = requests.get('http://localhost/api/get?token=67b89f860e381')
    if x.text != y.text:
        print('Yeni mesaj: ' + y.text)
        data = json.loads(y.text)
        get_message(data)
    
