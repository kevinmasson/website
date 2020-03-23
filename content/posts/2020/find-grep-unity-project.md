---
title: "Find what you want on a Unity project with grep"
date: 2020-03-29
draft: true
description: "With time, your Unity project will bigger. And the bigger it will get, the more it will be difficult to know which asset is used or where this UI event is used."
contribute:
    url: "https://github.com/oktomus/website/blob/master/content/posts/2020/find-grep-unity-project.md"
    count: 1
---

With time, your Unity project will bigger. And the bigger it will get, the more it will be difficult to know which asset is used or where this UI event is used.

I'm going to share with you two tips that I use on a daily basis as a developer. Both of these are using the `grep` command, a very powerful text search tool.

## Find which UI or Event Trigger is using a method

Coming accross code that you have no idea where it is used happens a lot. Finding references in the source code is easy, but finding where your code is used in your unity project (say on a button *OnClick*) is much more complicated if you don't have the tools.

Run the following from a shell in the `Assets` folder. You will then get as a result all the scenes and prefabs where the given method is used (including unity scenes and prefabs).

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

## Find where a specific asset in Unity

It's really easy to create new assets in Unity. At some point, you end up with assets that you don't even know where they are used anymore.

The following command helps you to find where any kind of asset (code, exture, mat, ...) is reference in your project (scene, prefabs, scriptable objects, ...).

```sh
$ grep -rn `grep guid some_asset.meta | cut -d':' -d' ' -f2`
Scenes/Levels/Level42.unity:1201    m_Sprite: [some_guid]
Prefabs/UI/OpenButton.prefab:458    m_Sprite: [some_guid]
```

What is command does is first extracting the `guid` of the asset and then look for it other files.

To make things easier, you can create a function for this command. See the next section.

## grep on Windows

I personally use Git Bash and always keep a terminal opened on my Unity project. Like this, I can quickly run `grep` or any custom functions that I previsouly added in my `~/.bash_profile` file.

Here is mine for example:

```sh
# ~/.bash_profile
unity_asset_usage() {
    grep -rn `grep guid "$1" | cut -d':' -d' ' -f2`;
}
```

With that, I can directly run `unity_asset_usage some_meta_file` from the shell.

## Final words

`grep` is a really powerful and yet very simple tool. Knowing how to use it is a great skill that will boost your productivity for sure.

When it comes to Unity, you can imagine much more things that can easily be done with `grep`:
- detect unused code or asset in your CI system
- automatically create tasks in your todo list when you push some code with `todo` inside
- find entities with broken `SerializeField`
- the list goes on

If you think this tip was useful or if you have another tip to share, please leave a comment !
