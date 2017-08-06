from django.contrib.sitemaps import Sitemap
from work.models import Work

class WorkSitemap(Sitemap):
    changefreq = "never"
    priority = 0.5

    def items(self):
        return Work.objects.all()

    def lastmod(self, obj):
        return obj.edited_on
