import requests
from pprint import pprint
import json

app_id = 'yangzonghao910904.en10-c2d256a0-46c7-439f'
app_key = '5e5ad39d-2f65-4dff-8e2c-10de5b3af97b'

auth_url = "https://tdx.transportdata.tw/auth/realms/TDXConnect/protocol/openid-connect/token"
url = "https://tdx.transportdata.tw/api/basic/v2/Bus/EstimatedTimeOfArrival/City/Hsinchu?%24format=JSON"

# Route url : https://tdx.transportdata.tw/api/basic/v2/Bus/Route/City/Hsinchu?%24format=JSON
# Stop Of Route url : https://tdx.transportdata.tw/api/basic/v2/Bus/StopOfRoute/City/Hsinchu?%24format=JSON
# Stop url : https://tdx.transportdata.tw/api/basic/v2/Bus/Stop/City/Hsinchu?%24format=JSON
# Staion url : https://tdx.transportdata.tw/api/basic/v2/Bus/Station/City/Hsinchu?%24format=JSON
# Estimate Arrival Time url : https://tdx.transportdata.tw/api/basic/v2/Bus/EstimatedTimeOfArrival/City/Hsinchu?%24format=JSON

class Auth():

    def __init__(self, app_id, app_key):
        self.app_id = app_id
        self.app_key = app_key

    def get_auth_header(self):
        content_type = 'application/x-www-form-urlencoded'
        grant_type = 'client_credentials'

        return{
            'content-type' : content_type,
            'grant_type' : grant_type,
            'client_id' : self.app_id,
            'client_secret' : self.app_key
        }

class data():

    def __init__(self, app_id, app_key, auth_response):
        self.app_id = app_id
        self.app_key = app_key
        self.auth_response = auth_response

    def get_data_header(self):
        auth_JSON = json.loads(self.auth_response.text)
        access_token = auth_JSON.get('access_token')

        return{
            'authorization':'Bearer '+access_token
        }

if __name__ == '__main__':

    try:
        d = data(app_id, app_key, auth_response)
        data_response = requests.get(url, headers = d.get_data_header())
    except:
        a = Auth(app_id, app_key)
        auth_response = requests.post(auth_url, a.get_auth_header())
        d = data(app_id, app_key, auth_response)
        data_response = requests.get(url, headers = d.get_data_header())    

    with open('Estimate_Arrival_Time_raw.json', 'w') as file:
        file.write(json.dumps(json.loads(data_response.text), indent = 4, ensure_ascii = False))

with open('Estimate_Arrival_Time_raw.json', 'r', encoding='utf-8') as f:
    data = json.load(f)

with open('Estimate_Arrival_Time.json', 'w', encoding='utf-8') as f:
    f.write('')

for item in data:
    new_item = {
        "PlateNumb": item["PlateNumb"],
        "StopUID": item["StopUID"],
        "RouteUID": item["RouteUID"],
        "SubRouteUID": item["SubRouteUID"],
        "Direction": item["Direction"],
        "StopStatus": item["StopStatus"],
        "IsLastBus": item['IsLastBus']
    }
    if 'EstimateTime' in item:
        new_item['EstimateTime'] = item['EstimateTime']
    else:
        new_item['EstimateTime'] = -1

    with open('Estimate_Arrival_Time.json', 'a', encoding='utf-8') as f:
        json.dump(new_item, f, ensure_ascii=False)
        f.write('\n')  # 加入換行符號，使每個物件在檔案中獨自存在一行