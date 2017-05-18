from bs4 import BeautifulSoup

import urllib2, json
# import urllib.request
# import urllib.error

# class MyOpener(urllib2.request.FancyURLopener):
#     version = 'Mozilla/5.0 (Windows; U; Windows NT 5.1; it; rv:1.8.1.11 Gecko/20071127 Firefox/2.0.0.11'
# urlopen = MyOpener().open#              THIS BLOCK SPOOFS A BROWSER
# urlretrieve = MyOpener().retrieve

def scrape(post_json):
    myjson = ""
    calls = []
    for query in post_json:
        # print query.decode('string_escape')
        myjson = json.loads(query)
        # return queries
        queries = myjson['queries']
        for source in json.loads(queries):

            domain = source['domain']
            specificity = source['specificity']
            calls.append({"domain": domain, "specificity": specificity})
        # print (json.loads(queries)[0]['domain'])
        # for domain in json.loads(queries):
        #     print domain
            # print json.dumps(domain)

            # for source in json.loads(queries)[domain]:
            #
            #     myjson = myjson
                # print source

        #         print search

    output = []
    for call in calls:
        output.append(getHtml(call))

    # output += json.dumps(myjson)
    # return ''.join(map(str,output))
    return output

def getHtml(query):
    domain = query['domain']
    specificity = query['specificity']
    url = ''
    selector = ''
    if( domain == 'reddit.com'):
        return "<H1>REDDIT POSTS GO HERE<H1>"
        selector = 'thing'
        url = "http://" + domain + '/r/' + specificity
    if(domain == 'twitter.com'):
        selector = 'tweet'
        url = "http://" + domain + '/' + specificity

    content = urllib2.urlopen(url).read()
    soup = BeautifulSoup(content)

    output = []
    for post in soup.find_all("div", { "class" : selector }):
        for link in post.find_all('a'):
            link['href'] = domain + link['href']
        output += post
    return ''.join(map(str,output))

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
    print arg

    return ''.join(map(str,output))

def getType(arg):
    myjson = ""
    output = []

    for key in arg:
        myjson = json.loads(key)

    for key in myjson:
        output += key;
    # return output
    return json.dumps(myjson)
