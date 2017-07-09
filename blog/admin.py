from django.contrib import admin
from django.db import models
from blog.models import Article
from blog.models import DescriptionField
from markdownx.widgets import AdminMarkdownxWidget
from markdownx.admin import MarkdownxModelAdmin
from django.forms import widgets

def make_published(modeladmin, request, queryset):
    queryset.update(status='p')
make_published.short_description = "Mark selected articles as published"

class ArticleAdmin(admin.ModelAdmin):
    list_display = ['title', 'publish_date', 'status']
    actions = [make_published]
    date_hierarchy = 'publish_date'
    ordering = ['-publish_date', 'title']
    exclude = ('created_on', 'edited_on')
    formfield_overrides = {
        models.TextField: {'widget': AdminMarkdownxWidget},
        DescriptionField: {'widget': widgets.Textarea},
    }

    fieldsets = (
            ('General', {
                'classes': ['collapse',],
                'fields': ['title', 'status', 'slug', 'publish_date']
                }
            ),
            ('Content', {
                'classes': ['collapse',],
                'fields': ['description', 'thumbnail', 'text']
                }
            )

            )

admin.site.register(Article, ArticleAdmin)
