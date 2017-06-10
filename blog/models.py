from django.db import models
from django.template.defaultfilters import slugify
from django.contrib.sitemaps import ping_google

class Article(models.Model):
    title = models.CharField(max_length=100)
    slug = models.SlugField(unique=True)
    text = models.TextField()
    description = models.CharField(max_length=500)
    thumbnail = models.ImageField(
            blank=True,
            upload_to="blog/thumbnails/%Y/%m/")
    created_on = models.DateTimeField(auto_now_add=True)

    def __unicode__(self):
        return self.title

    def __str__(self):
        return self.title

    @models.permalink
    def get_absolute_url(self):
        return ('blog_article_detail', (),
                {
                    'slug': self.slug,
                })


    def save(self, *args, **kwargs):
        if not self.slug:
            self.slug = slugify(self.title)
        super(Article, self).save(*args, **kwargs)
        try:
            ping_google()
        except Exception:
            pass
