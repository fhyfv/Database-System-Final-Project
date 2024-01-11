import json

with open('Stop_Of_Route_raw.json', 'r', encoding='utf-8') as f:
    data = json.load(f)

with open('Stop_Of_Route.json', 'w', encoding='utf-8') as f:
    f.write('')

for item in data:
    r_uid = item['RouteUID']
    sr_uid = item['SubRouteUID']
    d = item['Direction']
    stops = item['Stops']

    for stop in stops:
        s_uid = stop['StopUID']
        q = stop['StopSequence']

        new_item = {
            "RouteUID": r_uid,
            "SubRouteUID": sr_uid,
            "Direction" : d,
            "StopUID": s_uid,
            "StopSequence" : q
        }

        with open('Stop_Of_Route.json', 'a', encoding='utf-8') as f:
            json.dump(new_item, f, ensure_ascii=False)
            f.write('\n')
