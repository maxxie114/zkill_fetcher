# This script fetch zkill and write it into an SQlite database
import urllib.request
import json
import time

f = open('db.txt',"a")

while 1:
    html = urllib.request.urlopen('https://redisq.zkillboard.com/listen.php?queueID=maxxie114&ttw=1').read()
    decoded_string = html.decode('utf-8')
    parsed = json.loads(decoded_string)
    formatted_json = json.dumps(parsed, indent=4)
    print(formatted_json)
    f.write(formatted_json)
    time.sleep(secs)

f.close()
