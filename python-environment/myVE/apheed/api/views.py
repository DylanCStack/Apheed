from django.shortcuts import render
# from .models import Target, Source

from django.http import HttpResponse
from MyFunctions import reddit

# Create your views here.
def index(request, arguments):
    return HttpResponse(reddit(arguments))
