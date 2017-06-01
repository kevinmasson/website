from django.conf.urls import * 
from django.views.generic.list import ListView
from django.views.generic.detail import DetailView
from blog.models import Article
from blog.views import *

#urlpatterns = [
        #url(r'^$', views.home, name='home'),
        #url(r'^ajouter$', views.ajouterUrl, name="ajout"),
        #url(r'^(?P<code>[A-Za-z0-9]+)$', views.url, name='url'),
#        ]
urlpatterns = [
    url(r'^(?P<slug>[-\w]+)$', 
        DetailView.as_view(
            model=Article,
            template_name='blog_article.html'
        ),
        name='blog_article_detail'
        ),
    url(r'^$', 
        ListView.as_view(
            model=Article, 
            template_name='article_list.html'
        ),
        name='article_list'
        ),
]
