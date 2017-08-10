from django.shortcuts import render
from post.views import PostList, MarkdownPostDetail
from work.models import Work

class WorkList(PostList):

    model = Work
    template_name = "work/work_list.html"

class WorkDetail(MarkdownPostDetail):

    model = Work
    template_name = "work/work_detail.html"
