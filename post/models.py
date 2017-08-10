from django.db.models.signals import post_init, post_save
from django.dispatch import receiver
from django.db import models
from django.urls import reverse
from django.template.defaultfilters import slugify
from django.contrib.sitemaps import ping_google
from django.utils import timezone

STATUS_PUBLIC = 'p'
STATUS_DRAFT = 'd'
STATUS_WITHDRAWN = 'w'

class Status:
    public = STATUS_PUBLIC
    draft = STATUS_DRAFT
    withdrawn = STATUS_WITHDRAWN

STATUS_CHOICES = (
    (STATUS_DRAFT, 'Draft'),
    (STATUS_PUBLIC, 'Published'),
    (STATUS_WITHDRAWN, 'Withdrawn'),
)

class PublishedPostManager(models.Manager):

    def all(self):
        """
        Return published posts only
        """
        return self.model.objects.filter(
                status=Status.public, 
                publish_date__lte=timezone.now()
                ).order_by("-publish_date")

def post_thumbnail_path(instance, filename):
    filename =  "%s_%s" % (instance.title, filename)
    return "{0}/thumbnails/{1}/{2}/{3}".format(
            instance.__class__.__name__.lower(), 
            timezone.now().year,
            timezone.now().month,
            filename)

class Post(models.Model):
    title = models.CharField(max_length=100)
    slug = models.SlugField(unique=True)
    text = models.TextField()
    status = models.CharField(max_length=1, choices=STATUS_CHOICES, default=STATUS_DRAFT)
    thumbnail = models.ImageField(
            blank=True,
            upload_to=post_thumbnail_path)
    created_on = models.DateTimeField(auto_now_add=True)
    publish_date = models.DateTimeField(default=timezone.now)
    edited_on = models.DateTimeField(auto_now=True)

    objects = models.Manager()
    published = PublishedPostManager()

    def __unicode__(self):
        return unicode(self.__str__())

    def __str__(self):
        return self.title

    def is_available(self):
        return (
                self.status == STATUS_PUBLIC and
                self.publish_date <= timezone.now()
                )

    def save(self, *args, **kwargs):
        if not self.slug:
            self.slug = slugify(self.title)
        super(Post, self).save(*args, **kwargs)
        try:
            ping_google()
        except Exception:
            pass

    def absolute_url(self):
        return reverse(
                "%s:%s" % (self.__class__.__name__.lower(), "detail")
                , args=[self.slug])
        
@receiver(post_init, sender=Post)
def backup_image_path(sender, instance, **kwargs):
    instance._current_thumb_file = instance.thumbnail


@receiver(post_save, sender=Post)
def delete_old_image(sender, instance, **kwargs):
    if hasattr(instance, '_current_thumb_file'):
        if instance._current_thumb_file.path != instance.thumbnail.path:
            instance._current_thumb_file.delete(save=False)
