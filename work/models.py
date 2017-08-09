from django.db import models
from django.template.defaultfilters import slugify
from django.contrib.sitemaps import ping_google
from django.utils import timezone

STATUS_PUBLIC = 'p'
STATUS_DRAFT = 'd'
STATUS_WITHDRAWN = 'w'

STATUS_CHOICES = (
    (STATUS_DRAFT, 'Draft'),
    (STATUS_PUBLIC, 'Published'),
    (STATUS_WITHDRAWN, 'Withdrawn'),
)

class Work(models.Model):
    title = models.CharField(max_length=100)
    slug = models.SlugField(unique=True)
    text = models.TextField()
    status = models.CharField(max_length=1, choices=STATUS_CHOICES, default=STATUS_DRAFT)
    thumbnail = models.ImageField(
            blank=False,
            upload_to="work/thumbnails/%Y/%m/")
    created_on = models.DateTimeField(auto_now_add=True)
    publish_date = models.DateTimeField(default=timezone.now)
    edited_on = models.DateTimeField(auto_now=True)

    def __unicode__(self):
        return unicode(self.__str__())

    def __str__(self):
        return self.title

    @models.permalink
    def get_absolute_url(self):
        return ('work_detail', (),
                {
                    'slug': self.slug,
                })

    def is_available(self):
        return (
                self.status == STATUS_PUBLIC and
                self.publish_date <= timezone.now()
                )

    def save(self, *args, **kwargs):
        if not self.slug:
            self.slug = slugify(self.title)
        super(Work, self).save(*args, **kwargs)
        try:
            ping_google()
        except Exception:
            pass
