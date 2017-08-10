from django.db import models
from post.models import Post

class DescriptionField(models.CharField):
    pass

class Article(Post):
    description = DescriptionField(max_length=500)

