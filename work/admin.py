from django.contrib import admin
from django.db import models
from .models import Work
from post.admin import PostAdmin
from markdownx.widgets import AdminMarkdownxWidget

class WorkAdmin(PostAdmin):

    formfield_overrides = {
        models.TextField: {'widget': AdminMarkdownxWidget},
    }

admin.site.register(Work, WorkAdmin)
