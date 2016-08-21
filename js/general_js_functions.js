function changeContent($element, navigationObject, pageName) {
    if (pageName in navigationObject)
        $element.load(navigationObject[pageName].url);
    else
        $element.html('Page not found');
}