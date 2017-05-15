from bs4 import BeautifulSoup

import urllib2
# import urllib.request
# import urllib.error

# class MyOpener(urllib2.request.FancyURLopener):
#     version = 'Mozilla/5.0 (Windows; U; Windows NT 5.1; it; rv:1.8.1.11 Gecko/20071127 Firefox/2.0.0.11'
# urlopen = MyOpener().open#              THIS BLOCK SPOOFS A BROWSER
# urlretrieve = MyOpener().retrieve


def spoof():
    return {'User-Agent': 'Qd0aaiDRSQfYshjMjr-pRADmoOQ'}

def reddit(arg):
    domain = "https://reddit.com"
    target_page = "https://reddit.com/r/aww"
    domain = "https://twitter.com"
    target_page = "https://twitter.com/billmurray"
    content = urllib2.urlopen(target_page).read()
    soup = BeautifulSoup(content)

    output = []

    for post in soup.find_all("div", { "class" : "tweet" }):
        for link in post.find_all('a'):
            link['href'] = domain + link['href']
        output += post
    output += arg;

    return output
