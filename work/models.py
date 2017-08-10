from django.db import models
from django.template.defaultfilters import slugify
from django.contrib.sitemaps import ping_google
from django.utils import timezone
from post.models import Post, Status

class Work(Post):

    @models.permalink
    def get_absolute_url(self):
        return ('work_detail', (),
                {
                    'slug': self.slug,
                })
