function changeContent($element, navigationObject, pageName) {
    if (pageName in navigationObject)
        $element.load(navigationObject[pageName].url, function(response, status) {
            if (status == 'error') {
                $element.html('Page not found');
                console.log('there was an error');
                console.log('the content of the element is ' + $element.text());
            }
        });
    else
        $element.html('Page not found');
    
}