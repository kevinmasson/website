from django.conf.urls import * 
from blog.models import Article
from blog.views import *

#urlpatterns = [
        #url(r'^$', views.home, name='home'),
        #url(r'^ajouter$', views.ajouterUrl, name="ajout"),
        #url(r'^(?P<code>[A-Za-z0-9]+)$', views.url, name='url'),
#        ]
urlpatterns = [
    url(r'^(?P<slug>[-\w]+)$', 
        view_article,
        name='blog_article_detail'
        ),
]
