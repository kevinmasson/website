from django.shortcuts import render
from django.shortcuts import redirect, render_to_response, get_object_or_404
from django.views.generic.list import ListView
from django.views.generic.detail import DetailView
from django.utils import timezone
from .models import Article
import markdown2

class ArticleListView(ListView):
    template_name="blog/article_list.html"
    queryset = Article.objects \
            .filter(status='p') \
            .filter(publish_date__lt=timezone.now()) \
            .order_by('-publish_date')

class ArticleDetail(DetailView):
    model = Article
    template_name = "blog/article_detail.html"

    def get_context_data(self, **kwargs):
        context = super(ArticleDetail, self).get_context_data(**kwargs)
        print(context)
        mark = markdown2.Markdown(extras=[
            "code-friendly", 
            "header-ids",
            "fenced-code-blocks"])
        markText = mark.convert(context['article'].text)
        context['article'].text = markText
        return context
