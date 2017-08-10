from django.shortcuts import render
from post.views import PostList, MarkdownPostDetail
from blog.models import Article

class ArticleList(PostList):

    model = Article
    template_name = "blog/article_list.html"

class ArticleDetail(MarkdownPostDetail):

    model = Article
    template_name = "blog/article_detail.html"

