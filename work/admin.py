from django.contrib import admin
from django.db import models
from work.models import Work
from markdownx.widgets import AdminMarkdownxWidget
from markdownx.admin import MarkdownxModelAdmin
from django.forms import widgets

def make_published(modeladmin, request, queryset):
    queryset.update(status='p')

make_published.short_description = "Mark selected items as published"

class WorkAdmin(admin.ModelAdmin):
    list_display = ['title', 'publish_date', 'status']
    actions = [make_published]
    prepopulated_fields = {'slug': ('title', ), }
    date_hierarchy = 'publish_date'
    ordering = ['-publish_date', 'title']
    exclude = ('created_on', 'edited_on')
    formfield_overrides = {
        models.TextField: {'widget': AdminMarkdownxWidget},
    }

    fieldsets = (
            ('General', {
                'classes': ('wide', 'extrapretty',),
                'fields': ['title', 'status', 'slug', 'publish_date']
                }
            ),
            ('Content', {
                'classes': ['collapse',],
                'fields': ['thumbnail', 'text']
                }
            )

            )

admin.site.register(Work, WorkAdmin)
