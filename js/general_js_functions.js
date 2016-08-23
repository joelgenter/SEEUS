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

function changeMenu($menuContainer, navigationObject, userType, $contentContainer) {
    var $newElement;
    //To address unrecognized user types
    if (userType != 'authoritarian' & userType != 'user')
        userType = 'guest';
    for (page in navigationObject) {
        if (navigationObject[page]['displayFor'][userType]) {
            // load(navigationObject[page]['url'], function() { //See if there's a better way to check if a url is correct
            //     // if (status == 'error')
            //     //     continue;
                $newElement = $('<li>' + navigationObject[page]['displayName'] + '</li>');
                $newElement.click(changeContent($contentContainer, navigationObject, page));
                $menuContainer.append($newElement);
            //});
            
        }
    }
}