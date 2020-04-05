---
title: "TODO"
date: 2020-02-25
draft: true
description: "todo"
contribute:
    url: "https://github.com/oktomus/website/blob/master/content/posts/2020/unity-box-collider-intersect.md"
    count: 1
images:
- "/2020/whats-wrong-with-box-colliders-cover.png"
---

You want to check if a point is inside a box ? Or check if two boxes are intersecting ? You will probably use `BoxCollider.Bounds.Intersect` and `BoxCollder.Bounds.Contains`. Although, your results are wrong and behave like the following :

![The problem with box bolliders](/2020/the-problem-with-box-collider.gif)

Here is the code (attached on the moving point):

```csharp
[SerializeField] BoxCollider BoxCollider;

private void OnDrawGizmosSelected()
{
    bool isPointInside = BoxCollider.bounds.Contains(transform.position);

    Gizmos.color = isPointInside ? Color.green : Color.red;
    Gizmos.DrawSphere(transform.position, 0.1f);
}
```

I will try to explain here as clearly as possible what's hapenning and how to fix it.

## What's hapenning ?

First of all, you may have noticed that the results are wrong only when the box is rotated. Here is the same code running on a box with rotation `0, 0, 0`:

![Non rotated box](/2020/non-rotated-box.gif)

The reason is that the [bounds of the box collider are *axis-aligned*](https://docs.unity3d.com/ScriptReference/Bounds.html). This mean that they can't be rotated and so they won't take correctly into account your box correction.

It can be really confusing, especially when you see this that green wireframe following the box closely when rotating it:

![Rotated bounds](/2020/rotated-bounds.png)

## How to fix it ?

A way to fix it is to place the point in the box space. By doing so, the rotation is correctly taken into account and the results are correct. Althoug, it is a more expensive call as you have to transform points.

```csharp
// Place the point in box space.
Vector3 pointBoxSpace = BoxCollider.transform.InverseTransformPoint(transform.position);

// Compute the real bounds, not incorrectly affected by the rotation.
Bounds correctBounds = new Bounds(BoxCollider.center, BoxCollider.size);

bool isPointInside = correctBounds.Contains(pointBoxSpace);
```

![Point inside fixed](/2020/point-inside-fixed.gif)

Regarding box intersection test, the process is the same. Both boxes have to be in the same space.


