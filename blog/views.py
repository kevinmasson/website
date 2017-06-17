from django.shortcuts import render
from django.shortcuts import redirect, render_to_response, get_object_or_404
from django.views.generic.list import ListView
from .models import Article

class ArticleListView(ListView):
    template_name="article_list.html"
    queryset = Article.objects.order_by('-created_on')
