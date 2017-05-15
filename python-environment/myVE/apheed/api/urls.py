from django.contrib import admin

from django.conf.urls import url
from . import views

urlpatterns = [
    url(r'^(?P<arguments>[\S]+)', views.index, name='index'),
]
