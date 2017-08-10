from django.contrib import admin
from django.db import models
from .models import Work
from post.admin import PostAdmin
from markdownx.widgets import AdminMarkdownxWidget
from markdownx.admin import MarkdownxModelAdmin
from django.forms import widgets

class WorkAdmin(PostAdmin):

    formfield_overrides = {
        models.TextField: {'widget': AdminMarkdownxWidget},
    }

admin.site.register(Work, WorkAdmin)
