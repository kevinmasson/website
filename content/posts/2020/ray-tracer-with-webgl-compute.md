---
title: "Writting a ray tracer for the web"
date: 2020-01-01T18:50:00+01:00
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

The most important thing needed for a raytracer is probably the *Random Number Generator (RNG)*. It needs to be fast, pseudo random, must not have noticeable patterns and behave correctly in time. Unfortunately, it is not so easy.

The one I use is directly copied from [somewhere on internet](https://stackoverflow.com/questions/12964279/whats-the-origin-of-this-glsl-rand-one-liner) and is seed-based.

```glsl
float rand(inout float seed, vec2 pixel)
{
    float result = fract(sin(seed / 100.0f * dot(pixel, vec2(12.9898f, 78.233f))) * 43758.5453f);
    seed += 1.0f;
    return result;
}

vec2 rand2(inout float seed, vec2 pixel)
{
    return vec2(rand(seed, pixel), rand(seed, pixel));
}
```

The seed is a *uniform* that is being incremented each time I run the ray-tracing shader.

```glsl
uniform float uInitialSeed;

...

void main() {
    // gl_LocalInvocationId: local index of the worker in its group.
    // gl_WorkGroupId : index of the current working group.
    // gl_WorkGroupSize : local size of a work group. here it is 16x16x1.
    // gl_GlovalInvocationId : global exectuion index of the current worker.
    // gl_GlobalInvocationId = gl_WorkGroupID * gl_WorkGroupSize + gl_LocalInvocationID

    ivec2 storePos = ivec2(gl_GlobalInvocationID.xy);
    ivec2 imageSize = ivec2(gl_NumWorkGroups.xy * gl_WorkGroupSize.xy);
    vec2 uv = vec2(storePos) / vec2(imageSize);
    float seed = uInitialSeed;
    ...

    // Generate a random number.
    float n = rand(seed, uv);
}
```

This RNG could be better because the seed is sequential, we can notice some repetitions and patterns. Using a hash of the seed could be better.

There is a really nice shadertoy tool to compare different RNGs that you can find [here](https://www.shadertoy.com/view/wljXDz).





