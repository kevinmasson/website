---
title: "Set up a red light alarm to check your website status with python, cron and the Philips hue API"
date: 2017-07-29T21:18:57+01:00
draft: false
---

Just to let you know, there are much better ways to monitor your services. But I found this quite funny to make and it's a first step on creating incredibly useful Hue apps \o/.

## The result


<video mute preload controls autoplay>
    <source src="/2017/hue-web-alarm-demo.webm" type='video/webm;codecs="vp8"'><p>It seems that your browser doesn't support native HTML5 videos..</p>
</video>


A cron tab is set on the NAS which run my python script every minutes. The script then check for the website and if it's down, it makes the lamps blink. 

## Play with the Philips hue API

Before diving in the code, I suggest to you to read the official [hue beginner's guide](https://www.developers.meethue.com/documentation/getting-started) if you never have used a REST application before.

## Write your script

For the script, I choosed to use Python because it's really easy to get started. 

Before working on the module which would have helped me interface the Hue API, I have made some researches and I came across with [phue](https://github.com/studioimaginaire/phue), a lightweight Python library for the Philips Hue system. It's even easier to manage your lights.

### Getting started with phue

To install it, just run `pip install phue`. If you have pip but it's not available in your path or you want to use a sepcific version of Python, use this instead: `python -m pip install phue`.

Then create your file for your script using your favorite editor.
`vim webCheck.py`

We now need to connect to the Bridge which will then provides us all the required functions to play with our lights.

```python

#!/usr/bin/python

from phue import Bridge

b = Bridge('192.168.0.12') # You should know your bridge's ip if you had read Phillips' guide

b.connect()
```

Now run the script using `python webCheck.py` and you should get **an exception** telling you that you haven't any API key. This is `b.connect()` that actually fails, you have to press the button on your Bridge and re-run the script. 

*phue* will then create a file in your user directory containing the API key, this will prevent you to press the button each time you want to run the script. But I suggest you to **specify a key file**, because when you will deploy your script, you won't have to press the button again and if you use a system user to run your script (**highly recommended**), it will still work.

So let's define this key file based on our script path.

```python
...
import os
from phue import Bridge

SCRIPT_PATH = os.path.dirname(__file__) # Directory of the current file
KEY_FILE = os.path.join(SCRIPT_PATH, ".python_hue") # Path to hidden key file

b = Bridge(IP_ADDRESS, config_file_path=KEY_FILE)
b.connect()
```

You should have to press the button again or copy the file `.python_hue` from your user or documents directory into your script's directory.

You can now easily play with your lights, just modify your script and run it again.

```python
...
b.set_light(1,'on', False)
```

Checkout the [*phue* GitHub page](https://github.com/studioimaginaire/phue) to see what you can do with it.

### Red alarm animation

We will create a function for this, it's basically turning the light on and off multiple times with a defined animation time.

```python

from time import sleep
...
def alarm(bridge, light_id, tr_time, blink_count):

    animIn = {'transitiontime': tr_time,
        'on': True,
        'bri':254, # Full luminosity
        'sat': 254, # Full saturation
        'hue': 65535 # Red
    }
    
    animOut = {'transitiontime': tr_time,
        'on': True,
        'bri':5, # Almost off
        'sat': 70, # Less saturation
        'hue': 65535 # Still red
    }
    
    sleep_time = float(tr_time + 1) / 10.0
    
    
    for i in range(0, blink_count):
        b.set_light(light_id, animIn)
        sleep(sleep_time)
        b.set_light(light_id, animOut)
        sleep(sleep_time)
```

This will turn the light red then *on* and *off* *blink_count* times with a transition time of *tr_time*. The unit time used by the Philips hue API is 1/100 seconds, so you have to set it to 10 if you want a transition of 1 seconds -- which is very long, I personally use 5 for 500ms. 

Each time you send an animation to the lamp, you have to wait the end of the animation before starting another, this is what `sleep` does. But `sleep` requires seconds, if you give 1 to it, it will sleep for 1 second. So divide it by 10 to get the same time as the light animation. I use a float conversion before dividing to avoid weird results that you can get when mixing integers and floats ([which is totally normal by the way](https://stackoverflow.com/questions/2958684/python-division)).

This is not enough, this script won't set our light to it's initial state after the alarm ends. To do this, we must get the light state before and reset it after the animation.

```python
def alarm(bridge, light_id, tr_time, blink_count):

    default = b.get_light(light_id) # Default state

    ....

    animOut = {
        'on': default['state']['on'],
        'sat': default['state']['sat'],
        'hue': default['state']['hue'],
        'bri': default['state']['bri'],
    }

    b.set_light(light_id, animOut)  # Reset to default 
```

You can test your animation by running your function at the end of your script and running your python file.

```python
...
alarm(b, 1, 5, 10)
```

### Detect if your website is down

Simply sending a request and looking the response code is enough to determine if the website is ok or not. A response code above or equal to 400 on our main page (`/`) is when we suppose that the site is down.

```python
from requests import get

...

site_down = False

try:
    r = get("http://yourwbesite.tld/")

    if r.status_code >= 400:
        site_down = True

except Exception:
    site_down = True
```

Then silmply call the function if the site is down.

```python
if site_down:
    alarm(b, 1, 5, 10)
```

That's it. Let met show the [full script](https://gist.github.com/oktomus/1928ee05353e573ad0410bcff6cd46af) before going further.

```python
#!/usr/bin/python

"""
Set a red alarm on a given light when the specified website is down

"""
    
import os
from phue import Bridge
from time import sleep
from requests import get
import sys
    
SCRIPT_PATH = os.path.dirname(__file__) # Directory of the current file
KEY_FILE = os.path.join(SCRIPT_PATH, ".python_hue") # Path to hidden key file
    
def alarm(bridge, light_id, tr_time, blink_count):
    default = b.get_light(light_id) # Default state

    animIn = {'transitiontime': tr_time,
        'on': True,
        'bri':254, # Full luminosity
        'sat': 254, # Full saturation
        'hue': 65535 # Red
    }

    animOut = {'transitiontime': tr_time,
        'on': True,
        'bri':5, # Almost off
        'sat': 70, # Less saturation
        'hue': 65535 # Still red
    }

    sleep_time = float(tr_time + 1) / 10.0


    for i in range(0, blink_count):
        b.set_light(light_id, animIn)
        sleep(sleep_time)
        b.set_light(light_id, animOut)
        sleep(sleep_time)

    animOut = {
        'on': default['state']['on'],
        'sat': default['state']['sat'],
        'hue': default['state']['hue'],
        'bri': default['state']['bri'],
    }

    b.set_light(light_id, animOut)  # Reset to default state

if __name__ == "__main__":
    
    b = Bridge(IP_ADDRESS, config_file_path=KEY_FILE)
    b.connect()
    
    site_down = False
    
    try:
        r = get("http://yourwbesite.tld/")  # Or you can use sys.argv to specifiy the url when calling the script

        if r.status_code >= 400:
            site_down = True

    except Exception:
        site_down = True

    if site_down:
        alarm(b, 1, 5, 10)
        
    sys.exit(0)
```

## Use cron to call your script every minutes

You can install cron on your personal machine or on your server to run your scripts every minutes to check your website. Of course, this will only work if your computer is in the same network as the light. If you have a NAS, you should have a **Scheduled Tasks** program which allow you to execute something whenever you want; This is generally cron with a GUI.

Copy the script on your server, and then edit your cron configuration. And don't forget to install python, pip, phue and cron on the server.

```bash
crontab -e
```

This will open your cron configuration with your pre-configured (or not) editor.
At the end of it, add a line like the following:

```bash
* * * * * /usr/bin/python[3/2.7/...] /home/login/path/to/the/script/webCheck.py > /dev/null
```

That should call the given command every minute of every hour of every day of the current month for every months and for every days in the current week.Just that :)

If you want to run it every 15 minutes, just change the first star by `*/15`.

`> /dev/null` allow you to ignore standard outputs, which has the effect to only send you mails if your script fails (if you have a mail service configured).

## Credits

Thanks to [Lucas](http://lucasehlinger.com/) who owns these lights and the NAS on which I made this stuff.
