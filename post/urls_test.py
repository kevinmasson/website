from django.conf.urls import * 
from .views import PostList, MarkdownPostDetail


testpatterns = [
    url(r'^(?P<slug>[-\w]+)$', 
        MarkdownPostDetail.as_view(),
        name='post_detail'
        ),
    url(r'^$', 
        PostList.as_view(),
        name='list'
        ),
]
urlpatterns = [
    url(r'^post/', include(testpatterns, namespace="post")),
]
