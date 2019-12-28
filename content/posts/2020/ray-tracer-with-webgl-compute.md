---
title: "Ray tracing with WebGL 2.0 Compute"
date: 2019-12-23T18:50:00+01:00
draft: true
---

In 2019, *Khronos* announced and introduced [WebGL 2.0 Compute](https://www.khronos.org/registry/webgl/specs/latest/2.0-compute/), a new specification allowing to use the GPU for anything else than [Rasterisation](https://en.wikipedia.org/wiki/Rasterisation).

What it really means, is that we will be able to use **compute shaders**. These shaders allow to do much more things than the classical *vertex, fragment and geometry shader* pipeline.

*WebGL 2.0 Compute* is still a draft for now, but few browsers already have implemented it. For example, you can use this API on chrome if you start it like this :

```
chrome --use-cmd-decoder=passthrough --use-angle=gl --enable-webgl2-compute-context
```

--------------

[Demo](https://oktomus.github.io/webgpu-toy-ray-tracer/).

I won't go over all the details for implementing a ray traced. To do so, I strongly suggest reading about the [Ray Tracing in One Weekend Book Series](https://github.com/RayTracing/raytracing.github.io) or for much more details and maths, [Physically Based Rendering](http://www.pbr-book.org/).

Here, I will only talk about the *WebGL 2.0 Compute* part.

The project can be found on github : [a toy ray tracer made using WebGL 2.0 Compute](https://github.com/oktomus/webgpu-toy-ray-tracer).

--------------
