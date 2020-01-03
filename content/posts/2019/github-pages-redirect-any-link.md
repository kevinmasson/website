---
title: "Redirect any link on a GitHub pages website"
date: 2019-12-22T18:50:00+01:00
draft: false
description: "Redirect broken HTML links on a static website hosted on GitHub pages."
---

I recently switched my website from *django* to *hugo*. All the links referencing to my website are now broken and I need to deal with this.

> *Tip:* You can see all your website links that matter to google for referencing by searching for `site:example.com` in your search engine.

When switching to *hugo*, I also decided to switch to *gh-pages*. While it's pretty nice for many reasons, it doesn't have any server-side configuration and we can't do proper [URL redirection](https://en.wikipedia.org/wiki/URL_redirection#Using_server-side_scripting_for_redirection).

Thankfully, there is a way to redirect the user to a correct link on a *GitHub pages* site.

To do so, we can create a special *html* page that will redirect the user to the correct link when loaded.

Let's say you want to make a redirection from `/blogs/2019/i-failed` to `/posts/2019/i-really-failed`: create an html file on your *gh-pages* repo at `/blogs/2019/i-failed/index.html` and complete it with this :

```html
<!DOCTYPE html>
<html>
    <head>
        <title>Redirection to https://oktomus.com/posts/2019/i-really-failed</title>
        <link rel="canonical" href="https://oktomus.com/posts/2019/i-really-failed"/>
        <meta name="robots" content="noindex">
        <meta charset="utf-8" />
        <meta http-equiv="refresh" content="0; url=https://oktomus.com/posts/2019/i-really-failed" />
    </head>
</html>
```

With this, the user will be redirected to `/posts/2019/i-really-failed` when going to `/blog/2019/i-failed`.

You can push these html redirection files directly on your repo.

> *Tip*: *hugo* can create all those html redirection pages automatically if you specify aliases in your posts. See the [aliases documentation](https://gohugo.io/content-management/urls/#aliases).

While this tip is useful to do some redirections, you may not want to do this if you have a lot of content to redirect.
