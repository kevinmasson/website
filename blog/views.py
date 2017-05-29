from django.shortcuts import render
from django.shortcuts import redirect, render_to_response, get_object_or_404

from blog.models import Article

def view_article(request, slug):
    article = get_object_or_404(Article, slug=slug)

    return render_to_response('blog/blog_article.html',
            {
                'article': article,
            })

# Create your views here.
