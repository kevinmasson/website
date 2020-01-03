---
title: "Add comments to a static blog with Isso"
description: Install Isso on a debian server to self-host comments on your blog.
date: "2020-01-03"
draft: true
categories:
- Linux
- Debian
- Sysadmin
keywords:
- debian
- isso
- linux
- comments
- hugo
---

When adding comments onto your static blog, multiple choices are available. You can wether use a service like **Disqus**, which is really easy to use but cloud-based, or you can self-host them.

For my blog, I choosed a self-hosting option as I want my website to be compact, fast and without tracking.

Thankfully, [Isso](https://posativ.org/isso/) is here: an open source alternative to Disqus.

To setup Isso on my static **Hugo** website, I followed this [really great post](https://angristan.xyz/add-comments-to-your-blog-with-isso) written by Angrisan in 2018. But as I wasn't confortable with Isso and nginx, it took me some times. So I decided to detail a bit more the process in this post.

What you will need to follow this tutorial is a Debian server (here I'm under Debian `9.11`). If needed, you can check the [official Isso documentation](https://posativ.org/isso/docs/).

We will start by installing, running and testing Isso.

## Install and run Isso

```sh
# Installing dependencies
sudo apt-get install python-dev python-pip sqlite3 build-essential
# Installing isso
sudo pip install isso
```

We need to created a dedicated user on the server. We will use it to run Isso and send notification emails. Be sure to give it a Full Name that is relevant, as it will be the author of email notifications.

```sh
sudo adduser isso --disabled-login
```

Give it a strong password.

```sh
sudo passwd isso
```

We now need to create a configuration file for our blog. I placed mine under `/etc/isso.d/oktomus.cfg`.

```sh
[general]
name = oktomus
dbpath = /var/lib/isso/oktomus.comments.db
host = https://oktomus.com/
max-age = 15m
notify = smtp
log-file = /var/log/isso.log

[moderation]
enabled = false

[admin]
enabled = true
password = # A strong password.

[server]
listen = http://localhost:8080
reload = off
profile = off
public-endpoint = https://isso.oktomus.com

[guard]
enabled = true
ratelimit = 2
direct-reply = 3
reply-to-self = false
require-author = false
require-email = false

[smtp]
username = isso
password = # The password of the user isso
host = # smtp host (e.g. localhost, oktomus.com)
port = # smtp port
security = starttls
to = # my personal mail
from = isso@oktomus.com
timeout = 10
```

In my case, `https://oktomus.com` is pointing to a [GitHub pages repo](https://github.com/oktomus/oktomus.github.io) and `https://isso.oktomus.com` will point to the Debian server. Both can be on the same server.

All available options are detailled in the [server documentation](https://posativ.org/isso/docs/configuration/server/).

If you never configured a smtp service on your server, replace `smtp` by `stdout` for the `notify` setting and remove the `smtp` block.

You will need to create a `A` or `CNAME` record in your DNS to make `isso.oktomus.com` pointing to your server.

To make sure that our user have write and read permissions to the log and database files, run the following :

```sh
sudo touch /var/log/isso.log
sudo chown isso: /var/log/isso.log
sudo mkdir /var/lib/isso
sudo chown: isso /var/lib/isso
sudo touch /var/lib/isso/oktomus.comments.db
sudo chown isso: /var/lib/isso/oktomus.comments.db
```

To check if Isso is correctly configured, run it.

```sh
# Log as isso
su - isso
# Run it
/usr/local/bin/isso -c /etc/isso.d/oktomus.cfg run
```

If nothing is logged, everything should be fine. You can stop it with `CTRL+C`.

We can now create a service so that Isso is always running and start when your server boot. To do so, create the file `/etc/systemd/system/isso.service` with the following content:

```sh
[Unit]
Description=lightweight Disqus alternative

[Service]
User=isso
Environment="ISSO_SETTINGS=/etc/isso.d/oktomus.cfg"
ExecStart=/usr/local/bin/isso -c $ISSO_SETTINGS run

[Install]
WantedBy=multi-user.target
```

Enable it, run it and check that everything is ok.

```sh
sudo systemctl enable isso
sudo systemctl start isso
sudo systemctl status isso
```

You can make sure that isso is working by running the following, you should get an html document:

```sh
curl localhost:8080/admin
```

If everything is fine, we just need to configure nginx so that Isso can be accessed from outside your server.

## Configure nginx

Start by installing nginx and certbot. The later will be used to enable encryption on your website with a certificate from Let's Encrypt.

```sh
sudo apt-get install nginx certbot
```

Create a configuration file for isso under `/etc/nginx/site-available/isso.conf`.

```sh
server {
  server_name isso.oktomus.com;

  listen [::]:443 ssl http2;
  listen 443 ssl http2;

  access_log /var/log/nginx/isso-access.log;
  error_log  /var/log/nginx/isso-error.log;

  location / {
          proxy_set_header Host $http_host;
          proxy_set_header X-Real-IP $remote_addr;
          proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
          proxy_set_header X-Forwarded-Proto $scheme;
          proxy_pass http://localhost:8080;
  }
}

server {
  server_name isso.oktomus.com;

  listen [::]:80;
  listen 80;

  if ($host = isso.oktomus.com) {
    return 301 https://$host$request_uri;
  }

  return 404;
}
```

Enable it.

```sh
sudo ln -s /etc/nginx/site-available/isso.conf /etc/nginx/site-enabled/
```

We need to create a certificate for this website so that requests can be encrypted. The command is intereactive and may ask you some informations.

When asked to redirect HTTP to HTTPS, you can choose the redirect option. If this is the first certificate you ever install, consider to setup a crontab so that you can renew it automatically. Otherwise, your website will be considered unsecure in a few months.

```sh
sudo certbot
```

The content of the isso nginx file should have changed now and you can run it.

```sh
sudo systemctl enable nginx
sudo systemctl start nginx
sudo systemctl status nginx
```

You should now be able to acess the admin.

```sh
curl https://isso.oktomus.com/admin
```

If not, check content of the nginx and Isso log files.

Now that the Isso server runs correctly and can be accessed from outside, we just need to integrate it into our website.

## Integration

This is the simplest part. You just need to add the following snippet in your template:

```html
<div class="post-footer">
    <section id="isso-thread"></section>
    <script data-isso="https://isso.oktomus.com/" src="https://isso.oktomus.com/js/embed.min.js"></script>
</div>
```

In my case, for **Hugo**, I added it at the end of `themes/my-theme/layouts/_default/single.html`.

## Communicate

Tell me if you liked this post by adding a comment !
