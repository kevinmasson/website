---
title: "What's wrong with Unity box colliders ?"
date: 2020-04-05
draft: false
description: "What's hapenning when testing if a point is inside a box, and how to do it correctly."
contribute:
    url: "https://github.com/oktomus/website/blob/master/content/posts/2020/unity-box-collider-intersect.md"
    count: 1
images:
- "/2020/whats-wrong-with-box-colliders-cover.png"
---

To check if a point is inside a box in Unity, you will probably use `BoxCollder.Bounds.Contains`. Although, the results you get can be really confusing, like the following:

![The problem with box bolliders](/2020/the-problem-with-box-collider.gif)

The code running for the above gif is this one (attached on the moving point):

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

First of all, you may have noticed that the results are wrong only when the box is rotated or scaled. Here is the same code running on a box with rotation `0, 0, 0`:

![Non rotated box](/2020/non-rotated-box.gif)

The reason is that the [bounds of the box collider is *axis-aligned*](https://docs.unity3d.com/ScriptReference/Bounds.html). This mean that it can't be rotated and so it won't take into account your box rotation.

It can be really confusing, especially when you see this that green wireframe following the box closely when rotating it:

![Rotated bounds](/2020/rotated-bounds.png)

Moreover, the bounds attached to the box collider are closely following the space occupied by the mesh. Which means that the bounds size is changing as the object is rotating ! That's because bounds can't be rotated, the only way it has to surround the mesh is to change its size. See how the bounds of the box **really** look like in blue:

![The actual box bounds in blue](/2020/debuging-bounds.gif)

The code used for the above gif is the following:

```csharp
[SerializeField] BoxCollider BoxCollider;

private void OnDrawGizmosSelected()
{
    Gizmos.color = new Color(0.1f, 0.2f, 0.8f, 0.5f);
    Gizmos.DrawCube(BoxCollider.bounds.center, BoxCollider.bounds.size);
}
```

## How to fix it ?

A way to fix it is to place the point in the box space. By doing so, the rotation is correctly taken into account and the results are correct. Althoug, it is a more expensive call as you have to transform points. The bounds is also re-created to make sure the size is correct.

```csharp
// Place the point in box space.
Vector3 pointBoxSpace = BoxCollider.transform.InverseTransformPoint(transform.position);

// Compute the real bounds, not incorrectly affected by the rotation.
Bounds correctBounds = new Bounds(BoxCollider.center, BoxCollider.size);

bool isPointInside = correctBounds.Contains(pointBoxSpace);
```

![Point inside fixed](/2020/point-inside-fixed.gif)

## What about box intersection ?

Testing intersection between multiple boxes using `BoxCollider.Bounds.Intersect` is easy, as long as the boxes are in the same space. But if one of the boxes doesn't have uniform rotation (0, 90, 180, 270), then there is no easy and working way to test for intersection.

You would need to create a oriented box (*OBB* as opposed to *AABB*) from the box collider and then write an intersection test for these boxes. More info [here](https://www.gamasutra.com/view/feature/131790/simple_intersection_tests_for_games.php) in the *An Oriented Bounding Box (OBB) Intersection Test* section.
