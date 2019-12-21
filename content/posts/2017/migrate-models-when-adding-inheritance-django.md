---
title: "Migrate models when adding inheritance in Django"
date: 2017-09-17T21:28:15+01:00
draft: false
---

When you have one or more models that you are already using in your application and you want to change the parent class, the Django migration tool doesn't know what to do with the fields that will be transferred into the parent class values. By default, Django will erase existing fields and create new ones.

Here is a scheme a what you may want to do.

![Django class diagram](/2017/django/migrate-models-diagram.png)

Changing the parent class is useful when you want to share some attributes and operations throughout multiple models. For example on my website, I use it to share a Manager, Views and AdminModels throughout blog posts and work posts.

If you try to migrate from version 1 to version 2, Django will ask for a default value for the field title and it will erase what you already have.

To deal with it, you can write your own migration step. Be sure to **make a backup** before migrating to be sure to don't lose your data.

---------

**Edit**:

As CKreuzberger mentioned on my [reddit post](https://www.reddit.com/r/django/comments/70mew2/article_migrate_models_when_adding_inheritance_in/dn4ay1s/), you can add `abstract = True` in the meta of the Post class which will prevent the creation of a database for Posts so you won't have to do anything when executing migration. See the [documentation](https://docs.djangoproject.com/en/1.11/topics/db/models/#abstract-base-classes) for more details.

But if you want more than just shared fields, you shouldn't use the abstract meta.

---------


Before making any change on your child classes, you must have created and migrated your parent class. Also, be aware that shared fields have to be exactly the same. If you want to modify them (length, default value, ...), do it after you have migrated your child classes.

## 1. Create the default migration step

After having modified your child class (changing the parent and removing the common fields), you can start the process.

```
$ python manage.py makemigrations
You are trying to add a non-nullable field 'post_ptr' to blog without a default; we can't do that (the database needs something to populate existing rows).
Please select a fix:
1) Provide a one-off default now (will be set on all existing rows with a null value for this column)
    2) Quit, and let me add a default in models.py
    Select an option: 1 # <- Choose One
    Please enter the default value now, as valid Python
    The datetime and Django.utils.timezone modules are available, so you can do e.g. timezone.now
    Type 'exit' to exit this prompt
    >>> 0 # <- Add a default value
    Migrations for 'blog':
    blog/migrations/0002_auto_20170916_1247.py
    - Remove field id from blog
    - Remove field title from blog
    - Add field post_ptr to blog
```

You can specify whatever you want for the default value since we will add our own script.

## 2. Modify the migration operations

Open the migration file located in your application

```sh
vim blog/migrations/0002_auto_20170916_1247.py
```

We can now change the operations with our own.

```python
# New operations

operations = [
    migrations.RenameModel('Blog', 'OldBlog'),
    migrations.CreateModel(
        name='NewBlog',
        fields=[
            ('post_ptr', models.OneToOneField(auto_created=True, on_delete=Django.db.models.deletion.CASCADE, parent_link=True, primary_key=True, serialize=False, to='post.Post')),
            ('blog_only_field', models.TextField()), # DON'T FORGET NON COMMON FIELDS
        ],
        bases=('post.post',),
    ),
    migrations.RunPython(switch_to_post, switch_to_nopost),
    migrations.DeleteModel('OldBlog'),
    migrations.RenameModel('NewBlog', 'Blog')
]

""" Original operations

migrations.RemoveField(
    model_name='blog',
    name='id',
),
migrations.RemoveField(
    model_name='blog',
    name='title',
),
migrations.AddField(
    model_name='blog',
    name='post_ptr',
    field=models.OneToOneField(auto_created=True, default=0, on_delete=Django.db.models.deletion.CASCADE, parent_link=True, primary_key=True, serialize=False, to='post.Post'),
    preserve_default=False,
),

"""
 ```

As you can see, the original operations were supposed to remove the fields, which will erase all the entries' fields you have in your database.

**Very important**, don't forget in the CreateModel operation to add fields that are not shared with the parent class. To know what to add, check out the previous migration files of your model.

Here is what the new operations do:
- We first rename our model so we can create a new one based on the existing one
- We then create a new model with a pointer to the parent class and all non shared fields
    All inherited fields must be only in the parent class (e.g. you can't have a field title in the Blog model and in the Post model), otherwise the migration won't work.
- Then we call *switch_to_post* (we will define it after) to migrate all our database entries to the new model. We also specify a reverse function that will be called if we want to rollback.
- Since the entires were transferred, we can now delete the old model.
- And finally rename the new model.

Now we need to define the two functions required to transfer the entries of our model to the new model.

## 3. Create transfer functions

These functions have to be defined outside the *Migration* class.

```python
def switch_to_post(apps, schema_editor):
    """ From non inehirtance to post inheritance """
    OldBlog = apps.get_model('blog', 'OldBlog')
    NewBlog = apps.get_model('blog', 'NewBlog')
    for blog in OldBlog.objects.all():
        new_post_blog = NewBlog.objects.create(title=blog.title)
        blog.delete()

def switch_to_nopost(apps, schema_editor):
    """ Rollback """
    OldBlog = apps.get_model('blog', 'OldBlog')
    NewBlog = apps.get_model('blog', 'NewBlog')

    for blog in NewBlog.objects.all():
        new_blog = OldBlog.objects.create(title=blog.title)
        blog.delete()
```

*switch_to_post* create a new model for each old model, and *switch_to_nopost* revert new models to old ones.

We have to do it this way because all shared fields' data have to be transferred to the parent model in the database. If we don't provide our own operations, Django will just erase old fields and create new ones with default values.


## 4. Migrate!

```
$ python manage.py migrate
Operations to perform:
    Apply all migrations: admin, auth, blog, contenttypes, post, sessions
Running migrations:
    Applying blog.0002_auto_20170916_1247... OK
```

And now, your application is still working with all the entires you had before.

You can now do the same for all the models you want to change parent class.
