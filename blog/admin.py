from django.contrib import admin
from django.db import models
from .models import Article
from post.admin import PostAdmin
from markdownx.widgets import AdminMarkdownxWidget

class ArticleAdmin(PostAdmin):

    formfield_overrides = {
        models.TextField: {'widget': AdminMarkdownxWidget},
    }

admin.site.register(Article, ArticleAdmin)
