from django.contrib import admin
from django.db import models
from blog.models import Article
from blog.models import DescriptionField
from markdownx.widgets import AdminMarkdownxWidget
from markdownx.admin import MarkdownxModelAdmin
from django.forms import widgets

class ArticleAdmin(admin.ModelAdmin):
    date_hierarchy = 'created_on'
    exclude = ('created_on', 'slug', 'edited_on')
    formfield_overrides = {
        models.TextField: {'widget': AdminMarkdownxWidget},
        DescriptionField: {'widget': widgets.Textarea},
    }

admin.site.register(Article, ArticleAdmin)
