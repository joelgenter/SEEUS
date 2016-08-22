function changeContent($element, navigationObject, pageName) {
    if (pageName in navigationObject)
        $element.load(navigationObject[pageName].url, function(response, status) {
            if (status == 'error') {
                $element.html('Page not found');
            }
        });
    else
        $element.html('Page not found');
}