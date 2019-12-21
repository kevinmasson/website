---
title: "Swap escape and caps lock on Windows"
date: 2018-01-30T21:39:17+01:00
draft: true
---

So you want to switch the caps lock key with the escape key, but you don't want to edit the register. Don't worry ! This is fairly simple to do on windows, except that you will need to install a software if you want something that won't blow up. ¯\\\_(ツ)\_/¯

**Side note:** If you are a vim user, this tip will change your life. For real.

You will need to install **[AutoHotkey](https://www.autohotkey.com/)**, a lightweight application that allows you to make advanced modifications on your keyboard for specific application. We won't need all that fancy stuff.

Once you have installed it, create a file named `capsEscapeSwitch.ahk` wherever you want and place the following lines in it.

```c
Capslock::Esc
```

You can now open the file with *AutoHotkey*, and it should already work. If not, try to open the application and see the log if there is any, otherwise, `gl hf` – *Good luck, have fun* for the non-gamer readers among us.

Now, if you want to **make the changes permanent**, you just need to move this script to the *Windows Startup* folder. Place it in the first directory if you want this to work for **all your users**, and in the second one if you want this to work **only for you**.

- `C:\ProgramData\Microsoft\Windows\Start Menu\Programs\StartUp\`
- `C:\Users\\[USER]\AppData\Roaming\Microsoft\Windows\Start Menu\Programs\Startup\`

If the *AutoHotkey* script doesn't run on startup, be sure to give execution permissions to the user.

Your caps lock and escape keys should now be swapped !

**Blow up ?** Other solutions propose to edit the register, but this is not really safe because the changes you make may be overriden in future updates. Besides, I am not sure that you can swap them, I think you can only map escape to the caps lock key.
