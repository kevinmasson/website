from django.contrib import admin
from django.db import models
from blog.models import Article
from markdownx.widgets import AdminMarkdownxWidget
from markdownx.admin import MarkdownxModelAdmin

class ArticleAdmin(admin.ModelAdmin):
    date_hierarchy = 'created_on'
    exclude = ('created_on', 'slug')
    formfield_overrides = {
        models.TextField: {'widget': AdminMarkdownxWidget},
    }

admin.site.register(Article, ArticleAdmin)
