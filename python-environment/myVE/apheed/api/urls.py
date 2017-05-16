from rest_framework.urlpatterns import format_suffix_patterns
# from companies import views

from django.contrib import admin

from django.conf.urls import url
from . import views
from api.views import MyView

urlpatterns = [
    url(r'^[\S]+', MyView.as_view(), name='index'),
    # url(r'^(?P<arguments>[\S]+)', views.index, name='index'),
]
