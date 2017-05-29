from django import forms
from forms import ModelForm
from blog.models import Article

class ArticleForm(ModelForm):
    body = forms.CharField(widget=forms.TextArea, label='Entry')
    class Meta:
        model = Article 
