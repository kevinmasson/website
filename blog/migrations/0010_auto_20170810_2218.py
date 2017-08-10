# -*- coding: utf-8 -*-
# Generated by Django 1.11.2 on 2017-08-10 20:18
from __future__ import unicode_literals

from django.db import migrations, models
import django.db.models.deletion

def switch_to_post(apps, schema_editor):
    OldBlog = apps.get_model('blog', 'OldBlog')
    NewBlog = apps.get_model('blog', 'NewBlog')

    for old_blog in OldBlog.objects.all():

        new_blog = NewBlog.objects.create(
                title=old_blog.title,
                slug=old_blog.slug,
                text=old_blog.text,
                status=old_blog.status,
                thumbnail=old_blog.thumbnail,
                created_on=old_blog.created_on,
                edited_on=old_blog.edited_on,
                publish_date=old_blog.publish_date,
                description=old_blog.description
                )

        old_blog.delete()

def switch_to_nopost(apps, schema_editor):
    OldBlog = apps.get_model('blog', 'OldBlog')
    NewBlog = apps.get_model('blog', 'NewBlog')

    for new_blog in NewBlog.objects.all():
        old_blog = OldBlog.objects.create(
                title=new_blog.title,
                slug=new_blog.slug,
                text=new_blog.text,
                status=new_blog.status,
                thumbnail=new_blog.thumbnail,
                created_on=new_blog.created_on,
                edited_on=new_blog.edited_on,
                publish_date=new_blog.publish_date,
                description=olb_blog.description
                )
        new_blog.delete()


class Migration(migrations.Migration):

    dependencies = [
        ('post', '0003_auto_20170810_1924'),
        ('blog', '0009_article_status'),
    ]

    operations = [
        migrations.RenameModel('Article', 'OldBlog'),
        migrations.CreateModel(
            name='NewBlog',
            fields=[
                ('post_ptr', models.OneToOneField(auto_created=True, on_delete=django.db.models.deletion.CASCADE, parent_link=True, primary_key=True, serialize=False, to='post.Post')),
            ],
            bases=('post.post',),
        ),
        migrations.AddField(
            model_name='NewBlog',
            name='description',
            field=models.CharField(default="Description de l'article", max_length=500),
            preserve_default=False,
        ),
        migrations.RunPython(switch_to_post, switch_to_nopost),
        migrations.DeleteModel('OldBlog'),
        migrations.RenameModel('NewBlog', 'Article')
    ]