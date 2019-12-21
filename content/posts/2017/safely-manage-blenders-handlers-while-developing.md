---
title: "Safely manage Blender's handlers while developing"
date: 2017-07-14T21:06:12+01:00
draft: false
---

## What is a handler ?

Handlers are basically **callbacks** that you create to execute a specific function every time something happens. Blender's API currently provide [some handlers](https://docs.blender.org/api/blender_python_api_2_60_6/bpy.app.handlers.html), `frame_change_pre` will be used in this article. Each handler is a **list of functions**, in this case, every function in `frame_change_pre` will be executed before a switch of frame.

## The problem

Let's say that you are working on your callback function, everytime you change your function you will have to add it in the handler list to be able to use it. But you also have to remove the old one, otherwise, both functions would be executed. However, you can't be 100% sure which one is your function in the handler list. 

## Can't I just clear the handler list ?
    
Take this script, run it, modify the process function and run it again.

```python
from bpy.app.handlers import frame_change_pre

def process(scene):
    print("Hello!")
        
frame_change_pre.append(process)

```

Now, check the handler list.

```python
>>> bpy.app.handlers.frame_change_pre
[<function my_func at 0x7f50e1087c80>, <function process at 0x7f50e0a6d510>, <function process at 0x7f50e0a6d598>]
```

Every versions of your function will be executed on the handler event. So you have to remove old versions before adding a new one, but how can you be sure on which one you should delete ? The simpliest way it to clear the list before you add your function.

```python
...
bpy.app.handlers.frame_change_pre.clear()
frame_change_pre.append(process)
```

But if you are using multiple handlers, or if one of your addon does, you will also get rid of them. Thus, to be sure to don't break anything, you should delete from the list only the function you add in the current script. To do that, you need to store the function you have added. 

## Use the driver namespace

[bpy.app.driver_namespace](https://docs.blender.org/api/blender_python_api_2_77_1/bpy.app.html#bpy.app.driver_namespace) is a global dictionary. It means that you can store anything you want, and take it back the next time you execute the script.

We will store the function in this dictionnary to be able to check if the function is in the handler list before we modify it.

1. Import the driver namespace

    ```python
    from bpy.app import driver_namespace
    ```

2. Create a specific key for your callback

    ```python
    handler_key = "DEV_FUNC_01"
    ```
    This key has to be unique, to be sure to don't mess with what is already in the driver namespace.

3. Remove the callback if it is already there

    ```python
        if handler_key in driver_namespace:
            if driver_namespace[handler_key] in frame_change_pre:
                frame_change_pre.remove(driver_namespace[handler_key])

            del driver_namespace[handler_key]
    ```

4. Add the modified function in the driver namespace

    ```python
        driver_namespace[handler_key] = process
    ```

This way, you can be sure that old functions aren't in the handler list and only the newest one is present. Here is the full script.

```python

from bpy.app.handlers import frame_change_pre
from bpy.app import driver_namespace


handler_key = "DEV_FUNC_01"

if handler_key in driver_namespace:
if driver_namespace[handler_key] in frame_change_pre:
    frame_change_pre.remove(driver_namespace[handler_key])

del driver_namespace[handler_key]

def process(scene):
print("Hello 2!")


frame_change_pre.append(process)
driver_namespace[handler_key] = process
```

```python
You can run the script and check in the console that your function is here.

>>> bpy.app.driver_namespace["DEV_FUNC_01"]
<function process at 0x7f50e0a6d598>
```

And now, if you modify the process function and run the script, only the new callback will be executed.

## Going further, use a class

If you want, you can do something more developed and for example, use a class. Like this, you will also be able to share attributes and create multiple callbacks with different parameters easily.

```python
from bpy.app.handlers import frame_change_pre
from bpy.app import driver_namespace

handler_key = "DEV_HAND_01"

class ProcessHandler():

def __init__(self, p_name):
    self.name = p_name
    
def process(self, scene):
    print(self.name)

def remove_handler(self):
    if self.process in frame_change_pre:
	frame_change_pre.remove(self.process)

def add_handler(self):
    frame_change_pre.append(self.process)
    

if handler_key in driver_namespace:
driver_namespace[handler_key].remove_handler()

driver_namespace[handler_key] = ProcessHandler("joseph")
driver_namespace[handler_key].add_handler()
```

When you work on an addon, you won't do this that way, it's better to remove your callbacks in the unregister function. But while you are programming or if you don't wish to make an addon, this technique can be really usefull.

## Why these snippets doesn't work ?

### The memory address has changed

```python
    ...
    if process in frame_change_pre:
        frame_change_pre.remove(process)

    frame_change_pre.append(process)
```

Here, you already have modified the function, so its memory address won't be the same and you won't be able to find the old function in the list.

### Remove it before modifying it

```python
...
if process in frame_change_pre:
frame_change_pre.remove(process)
...
def process():
...
frame_change_pre.append(process)
```

You can't do this, because at this level, the function doesn't exists yet. This is why we store it to be able to get it when we run the script.

### Insert at a specific index instead of appending

If so, imagine that you enable an addon or that you have another script which does the same, you can't be sure that your function will always be at the same index. And it's a list, its size isn't deterministic.

