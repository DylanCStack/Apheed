from django.shortcuts import get_object_or_404
from rest_framework.views import APIView
from rest_framework.response import Response
from rest_framework import status



from django.shortcuts import render
# from .models import Target, Source

from django.http import HttpResponse
from MyFunctions import scrape

from django.views.generic import View


import urllib2, json


class MyView(View):
    def get(self, request, *args, **kwargs):
        return HttpResponse(scrape(request))

    def post(self, request, *args, **kwargs):
        return HttpResponse(scrape(request))
        # return HttpResponse(str(type(request)))
        # return HttpResponse(reddit(request))

# Create your views here.
# def index(request, arguments):
#     return HttpResponse(reddit(arguments))
