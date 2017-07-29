from django.conf.urls import * 
from django.views.generic.list import ListView
from blog.models import Article
from .views import ArticleListView, ArticleDetail

#urlpatterns = [
        #url(r'^$', views.home, name='home'),
        #url(r'^ajouter$', views.ajouterUrl, name="ajout"),
        #url(r'^(?P<code>[A-Za-z0-9]+)$', views.url, name='url'),
#        ]
urlpatterns = [
    url(r'^(?P<slug>[-\w]+)$', 
        ArticleDetail.as_view(),
        name='blog_article_detail'
        ),
    url(r'^$', 
        ArticleListView.as_view(),
        name='article_list'
        ),
]
