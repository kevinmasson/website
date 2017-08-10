from django.views.generic.list import ListView
from django.views.generic.detail import DetailView
from django.urls import reverse

from .models import Post

import markdown2

class PostList(ListView):

    model = Post
    template_name = 'post/post_list.html'

    def get_query_set(self):
        return self.model.published.all()


class MarkdownPostDetail(DetailView):

    model = Post
    template_name = 'post/post_detail.html'

    def get_queryset(self):
        return self.model.published.all()

    def get_context_data(self, **kwargs):
        context = super(MarkdownPostDetail, self).get_context_data(**kwargs)
        mark = markdown2.Markdown(extras=[
            "code-friendly", 
            "header-ids",
            "fenced-code-blocks"])
        markText = mark.convert(context['object'].text)
        context['object'].text = markText
        return context

