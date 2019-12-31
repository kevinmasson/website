---
title: "Writting a ray tracer for the web"
date: 2010-01-01T18:50:00+01:00
draft: true
---

In 2019, *Khronos* announced and introduced [WebGL 2.0 Compute](https://www.khronos.org/registry/webgl/specs/latest/2.0-compute/), a new specification allowing to use the GPU for anything else than [Rasterisation](https://en.wikipedia.org/wiki/Rasterisation).

What it really means is that we will be able to use **compute shaders**. These shaders allow to do much more things than the classical *vertex, fragment and geometry shader* pipeline used for realtime 3D applicaitons.

*WebGL 2.0 Compute* is still a draft, but few browsers already have implemented it. For example, you can use this API on chrome when you run it like this :

```
chrome --use-cmd-decoder=passthrough --use-angle=gl --enable-webgl2-compute-context
```

I really wanted to test this new API. So, I decided to write [a very simple ray tracer](https://oktomus.github.io/webgpu-toy-ray-tracer/). The goal wasn't to make something pretty or production-ready, but just to demonstrate what will be soon possible on most web-browsers and web applications.

The complete project can be found [on github](https://github.com/oktomus/webgpu-toy-ray-tracer).

> Note: There is another API called [Web GPU](https://gpuweb.github.io/gpuweb/) that can be used for the same thing. I will do the same project with this new API and let you know how things goes. If you don't want to miss it, follow me on [twitter](https://twitter.com/oktomus) !

If you never used *WebGL* and you want to learn how to use it, take a look at [WebGL fundamentals](https://webglfundamentals.org/). And for simple *web compute shader* examples, take a look at [this WebGL Compute shader collection](https://github.com/9ballsyndrome/WebGL_Compute_shader). Finally, if you want to learn more about ray tracing, I strongly suggest the [Ray Tracing in One Weekend Book Series](https://github.com/RayTracing/raytracing.github.io) or for much more details and maths, the [Physically Based Rendering book](http://www.pbr-book.org/).

--------------

## Random numbers

The most important thing needed for a raytracer is probably the *Random Number Generator (RNG)*.
Most physically-based renderers use the Monte-Carlo approach, which is all about randomness.

We need a way to generate number that is fast, pseudo random, must not have noticeable patterns and behave correctly in time. Unfortunately, it is not as easy as it sounds.

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

This RNG could be much better. The seed is sequential, we can notice some repetitions and patterns. Using a hash of the seed could give better results.

There is a really nice shadertoy tool to compare different RNGs that you can find [here](https://www.shadertoy.com/view/wljXDz).

## Shading

Coding the shading on the GPU is pretty close to coding it on the CPU except that:
- dynamic allocation isn't allowed and
- recursive functions are not a thing.

Regarding dynamic allocation, it's not really a problem because you should already be doing the same on CPU if you want your raytracer to be fast.

For the recursive part, it's a bit annoying at the begining and it can make coding a bit more difficult. But in the end, you can acheive the same thing using `while` loops and some adjustements in your calculations.

So you can pretty much copy-paste your CPU code into a shader.

## Computing ray triangle intersections

This one is pretty easy since the GPU code can almost be copied as-is from the CPU. Here is the one I use that doesn't cull backfaces:

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

There is a lot of operations that are already implmented like `cross` and `dot`.

## Acessing triangles on the GPU

I'm really not an expert on this so I won't explain too much how this is working. But if you want to learn more, you can read about

memory layout

## Progressive and interactive rendering

Accumulation example.


