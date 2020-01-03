---
title: "Writting a ray tracer for the web"
date: 2010-01-01T18:50:00+01:00
draft: true
description: "Major issues involved in making a ray tracer using compute shaders for the web."
---

In 2019, *Khronos* announced and introduced [WebGL 2.0 Compute](https://www.khronos.org/registry/webgl/specs/latest/2.0-compute/), a new specification allowing to use the GPU for anything else than [Rasterisation](https://en.wikipedia.org/wiki/Rasterisation).

What it really means is that we will be able to use **compute shaders**. These shaders allow to do much more things than the classical *vertex, fragment and geometry shader* pipeline used for realtime 3D applicaitons.

*WebGL 2.0 Compute* is still a draft, but some browsers already have implemented it. For example, you can use this API on chrome if you enable some flags :

```
chrome --use-cmd-decoder=passthrough --use-angle=gl --enable-webgl2-compute-context
```

I really wanted to test this new API. So, I decided to write [a very simple ray tracer](https://oktomus.github.io/webgpu-toy-ray-tracer/). The goal wasn't to make something pretty or production-ready, but just to play with compute shaders and see what can be acheived with this.

The complete project can be found [on github](https://github.com/oktomus/webgpu-toy-ray-tracer).

--------------

There is another API called [Web GPU](https://gpuweb.github.io/gpuweb/) that can be used for the same thing. I will do the same project with this new API and let you know how things goes. If you don't want to miss it, follow me on [twitter](https://twitter.com/oktomus) !

--------------

## Random numbers

The most important thing needed for a raytracer is probably the *Random Number Generator (RNG)*.

We need a way to generate pseudo-random numbers that is fast, must not have noticeable patterns and behave correctly over time. Unfortunately, this is not as easy as it sounds.

The one I use is directly copied from [somewhere on internet](https://stackoverflow.com/questions/12964279/whats-the-origin-of-this-glsl-rand-one-liner) and is seed-based.

I created a simple demo showing the RNG result, so that you can easily understand how to use the WebGL 2.0 Compute API : [demo](https://oktomus.com/web-experiments/webgl-compute/rng/) / [code](https://github.com/oktomus/web-experiments/tree/master/webgl-compute/rng). Here is the shader:

```glsl
#version 310 es

layout (local_size_x = 16, local_size_y = 16, local_size_z = 1) in;

layout (rgba8, binding = 0) writeonly uniform highp image2D outputTex;

uniform float uSeed;

float rand(inout float seed, vec2 pixel)
{
    float result = fract(sin(seed / 100.0f * dot(pixel, vec2(12.9898f, 78.233f))) * 43758.5453f);
    seed += 1.0f;
    return result;
}

void main() {
    ivec2 storePos = ivec2(gl_GlobalInvocationID.xy);
    ivec2 imageSize = ivec2(gl_NumWorkGroups.xy * gl_WorkGroupSize.xy);
    vec2 uv = vec2(storePos) / vec2(imageSize);

    float seed = uSeed;

    float n = rand(seed, uv);
    vec4 color = vec4(n, n, n, 1.0);

    imageStore(outputTex, storePos, color);
}
```

This RNG could be much better as the seed is sequential and we can notice some repetitions and patterns. Using a hash of the seed could give better results.

There is a really nice shadertoy tool to compare different RNGs that you can find [here](https://www.shadertoy.com/view/wljXDz).

## Intersections

One of the first thing that you implement when making a ray tracer is the ability to compute interesction between a ray and a shape.

The interesection code is pretty much the same on GPU as on CPU. However, it is much complicated to debug GPU code since you can't attach a debugger or print things.

Also, don't expect your GPU code to fail and throw an error as it does the CPU. You won't get runtime shader execution errors printed out like *Array index out of bounds* or such.

Note that there is a lot of operations that are already implmented on the GPU like `cross` and `dot`.

Here is the interesection code I use for triangles:

```glsl
// Test intersection between a ray and a triangle using Möller–Trumbore algorithm.
bool hit_triangle_mt(Ray r, vec3 v0, vec3 v1, vec3 v2, out float t)
{
    vec3 e1 = v1 - v0;
    vec3 e2 = v2 - v0;
    vec3 h = cross(r.direction, e2);

    float a = dot(e1, h);

    if (a < EPSILON && a > EPSILON)
        return false;

    float f = 1.0 / a;
    vec3 s = r.origin - v0;

    float u = f * dot(s, h);

    if (u < 0.0 || u > 1.0)
        return false;

    vec3 q = cross(s, e1);
    float v = f * dot(r.direction, q);

    if (v < 0.0 || u + v > 1.0)
        return false;

    t = f * dot(e2, q);

    if (t > EPSILON)
    {
        return true;
    }

    return false;
}
```

## Shading

Coding the shading on the GPU is pretty close to coding it on the CPU except that:
- dynamic allocation isn't allowed and
- recursive functions are not a thing.

Regarding dynamic allocation, it's not really a problem because you should already be doing the same on CPU if you want your ray tracer to be fast.

For the recursive part, it's a bit annoying at the begining and it can make coding a bit more difficult. But in the end, you can acheive the same thing using a good old `while` loop with some adjustements in your code.

## Acessing triangles on the GPU

I'm really not an expert on this so I won't explain too much how this is working. But if you want to learn more, you can read about

memory layout

## Progressive and interactive rendering

To keep a realtime frame rate and interactive controls, I used progressive rendering. Many frames are computed over the time with low quality settings (*samples per pixel = 1*) and are accumulated together.

Like this, the render is instant and if you want a clean sharp render, you just have to wait.

The code for this is straightforward, you just need 2 textures. One for rendering a frame and one for accumulating and displaying the final result.

Here is a simple demo of accumulation over time using compute shaders that helped me to implement progressive rendering: [demo](https://oktomus.com/web-experiments/webgl-compute/progressive-steps/) / [code](https://github.com/oktomus/web-experiments/tree/master/webgl-compute/progressive-steps).

## Render !

If you are interested into rendering, casting some rays and make them bounce, here are some links that will help you getting started :
- Getting started with webgl: [WebGL fundamentals](https://webglfundamentals.org/)
- Getting started with compute shaders (web): [WebGL Compute shader collection](https://github.com/9ballsyndrome/WebGL_Compute_shader)
- Implementation and theory of raytracing: [Ray Tracing in One Weekend Book Series](https://github.com/RayTracing/raytracing.github.io), [Physically Based Rendering book](http://www.pbr-book.org/).

## What's next

This toy path tracer is just the begining. I want to make another toy paht tracer using the WebGPU API and i'm also considering writting a more complete tutorial on how to write a web ray tracer. Tell me if you are interested.
