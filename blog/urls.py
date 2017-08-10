from django.conf.urls import * 
from .views import ArticleList, ArticleDetail

urlpatterns = [
    url(r'^(?P<slug>[-\w]+)$', 
        ArticleDetail.as_view(),
        name='article_detail'
        ),
    url(r'^$', 
        ArticleList.as_view(),
        name='article_list'
        ),
]
