from django.contrib.sitemaps import Sitemap
from blog.models import Article

class BlogSitemap(Sitemap):
    changefreq = "never"
    priority = 0.5
    i18n = True
    protocol = 'https'

    def items(self):
        return Article.objects.all()

    def lastmod(self, obj):
        return obj.edited_on
