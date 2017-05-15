from __future__ import unicode_literals

from django.db import models

# Create your models here.

class Target(models.Model):
    name = models.CharField(max_length=255)
    base_domain = models.CharField(max_length=255)
    selector = models.CharField(max_length=500)
    #sorting = multiple possible sorts
    #iterable = how to change call to retrieve more posts
    #iterations = how many times to iterate before giving up on retrieving new posts.

class Source(models.Model):
    target = models.ForeignKey(Target, onDelete=models.CASCADE)
    specificity = models.CharField(max_length=500)
    #filters = which sorts to inherit from Target
    #highlight = use other inherited sorts to change how response is formatted.
