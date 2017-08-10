from django.contrib import admin
from django.db import models
from .models import Post, Status
from django.forms import widgets

def make_published(modeladmin, request, queryset):
    queryset.update(status=Status.public)

make_published.short_description = "Mark selected items as published"

class PostAdmin(admin.ModelAdmin):
    list_display = ['title', 'publish_date', 'status']
    actions = [make_published]
    prepopulated_fields = {'slug': ('title', ), }
    date_hierarchy = 'publish_date'
    ordering = ['-publish_date', 'title']
    exclude = ('created_on', 'edited_on')

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

admin.site.register(Post, PostAdmin)
