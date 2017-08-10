"""website URL Configuration

The `urlpatterns` list routes URLs to views. For more information please see:
    https://docs.djangoproject.com/en/1.11/topics/http/urls/
Examples:
Function views
    1. Add an import:  from my_app import views
    2. Add a URL to urlpatterns:  url(r'^$', views.home, name='home')
Class-based views
    1. Add an import:  from other_app.views import Home
    2. Add a URL to urlpatterns:  url(r'^$', Home.as_view(), name='home')
Including another URLconf
    1. Import the include() function: from django.conf.urls import url, include
    2. Add a URL to urlpatterns:  url(r'^blog/', include('blog.urls'))
"""
from django.conf.urls import url, include
from django.contrib import admin
from django.contrib.flatpages.sitemaps import FlatPageSitemap
from django.contrib.sitemaps.views import sitemap
from blog.sitemap import BlogSitemap
from work.sitemap import WorkSitemap
from django.contrib.flatpages import views
from django.conf import settings
from django.conf.urls.static import static
from django.views.generic.base import RedirectView
import os
from .sitemaps import StaticViewSitemap


sitemaps = {
        'blog': BlogSitemap,
        'work': WorkSitemap,
        'static': StaticViewSitemap
}

urlpatterns = [
    url(r'^admin/', admin.site.urls),
    url(r'^blog/', include('blog.urls', namespace="blog")),
    url(r'^work/', include('work.urls', namespace="work")),
    url(r'^sitemap\.xml', sitemap, {'sitemaps': sitemaps},
        name='sitemap'),
    url(r'^robots\.txt', include('robots.urls')),
    url(r'^markdownx/', include('markdownx.urls')),
    url(r'^$', views.flatpage, {'url': '/home/'}, name='home'),
    url(r'^about/$', views.flatpage, {'url': '/about/'}, name='about'),
]

# Permanent redirections from redirects.txt
file_path = os.path.abspath(os.path.join(
            os.path.dirname(__file__),
            "redirects.txt"
        )
)
if os.path.isfile(file_path):
    with open(file_path, "r") as buf:
        buf.readline() # Skip first line
        for line in buf:
            while line[-1] in [' ', '\n']:
                line = line [:-1]
            params = line.split(' ')
            source = params[0]
            destination = params[1]
            permanent = True if len(params) == 3 and params[2] == '1' else False
            urlpatterns.append(
                    url(source, RedirectView.as_view(url=destination,
                        permanent=permanent)
                    )
            )

urlpatterns += static(settings.MEDIA_URL, document_root=settings.MEDIA_ROOT)

handler400 = 'website.views.bad_request'
handler403 = 'website.views.denied'
handler404 = 'website.views.not_found'
handler500 = 'website.views.error'
