---
title: "Using grep on a Unity project to find your way"
date: 2020-03-29
draft: true
description: "With time, your Unity project will get bigger. Looking for something in the different prefabs and scenes can be very time consuming, especially for someone new to the project. Using grep can help you find your way in a project much faster."
contribute:
    url: "https://github.com/oktomus/website/blob/master/content/posts/2020/find-grep-unity-project.md"
    count: 1
---

With time, your Unity project will get bigger. Looking for something in the different prefabs and scenes can be very time consuming, especially for someone new to the project.

I'm going to share with you two tips that I use on a daily basis as a developer to find my way in a Unity project **faster**. Both of these are using the `grep` command, a very powerful text search tool.

## Find which UI or Event Trigger is calling a method

Coming accross code that you have no idea where it is used happens a lot. Finding references in the source code is easy, but finding where your code is used in your unity project (say on a button *OnClick*) is much more complicated if you don't have the tools.

Run the following command from a shell in the `Assets` folder to find where a method is used. You will get as a result all the scenes and prefabs where the given method is attached.

```sh
$ grep -rn "OnButtonClicked"
Scenes/Levels/Level12.unity:6501    m_methodName: OnButtonClicked
```

You can even find which game object is involved by opening the `Level12.unity` file with a text editor and looking above line `6501`. You should find something like:

```txt
GameObject:
    m_Name: "Popup back button"
    ...
```

## Find where a specific asset is used

It's really easy to create new assets in Unity. At some point, you end up with so many assets that you don't even know where they are used anymore.

The following command helps you find where any kind of asset (code, exture, mat, ...) is referenced in your project (scene, prefabs, scriptable objects, ...).

```sh
$ grep -rn `grep guid some_asset.png.meta | cut -d':' -d' ' -f2`
Scenes/Levels/Level42.unity:1201    m_Sprite: [some_guid]
Prefabs/UI/OpenButton.prefab:458    m_Sprite: [some_guid]
```

What is command does is first extracting the `guid` of the asset and then look for it other files.

To make things easier, you can create a function for this command. See the next section.

## grep on Windows

I use Git Bash and always keep a terminal opened on my Unity project. Like this, I can quickly run `grep` or any custom functions that I previsouly added in my `~/.bash_profile` file.

Here is mine for example:

```sh
# ~/.bash_profile
unity_asset_usage() {
    grep -rn `grep guid "$1" | cut -d':' -d' ' -f2`;
}
```

With that, I can directly run `unity_asset_usage some_meta_file` from the shell to find an asset is used.

## Final words

`grep` is a really powerful and yet very simple tool. Knowing how to use it is a great skill that will boost your efficiency.

When it comes to Unity, you can imagine much more things that can easily be done with `grep`:
- detect unused code or asset in your CI system
- automatically create tasks in your todo list when you push some code with `todo` inside
- find entities with broken `SerializeField`
- the list goes on

If you think this tip was useful or if you have another tip to share, please leave a comment !
