from django.shortcuts import render
from django.shortcuts import redirect, render_to_response, get_object_or_404
from django.views.generic.list import ListView
from django.views.generic.detail import DetailView
from django.utils import timezone
from .models import Work
import markdown2

class WorkList(ListView):
    template_name="work/work_list.html"
    queryset = Work.objects.published()

class WorkDetail(DetailView):
    model = Work
    template_name = "work/work_detail.html"

    def get_context_data(self, **kwargs):
        context = super(WorkDetail, self).get_context_data(**kwargs)
        mark = markdown2.Markdown(extras=[
            "code-friendly", 
            "header-ids",
            "fenced-code-blocks"])
        markText = mark.convert(context['work'].text)
        context['work'].text = markText
        return context

