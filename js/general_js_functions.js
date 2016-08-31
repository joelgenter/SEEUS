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
    $menuContainer.empty();
    var $newElement;
    //To address unrecognized user types
    if (userType != 'authoritarian' & userType != 'user')
        userType = 'guest';
    for (page in navigationObject) {
        if (navigationObject[page]['displayFor'][userType]) {
            (function(page) {
                $newElement = $('<li>' + navigationObject[page]['displayName'] + '</li>');
                $newElement.on('click', function() {
                    changeContent($contentContainer, navigationObject, page);
                });
                $menuContainer.append($newElement);
            })(page);
        }
    }
}

function getUserType(ajaxAddresses, callback) {
        $.get(ajaxAddresses['getUserType'])
            .done(function(data) {
                console.log('it was successful');
                callback(data);
            })
            .fail(function( jqXHR, textStatus, errorThrown) {
                console.log('it failed');
                for (item in jqXHR) {
                    console.log(item + ' ' + jqXHR[item]);
                }
                console.log(textStatus + ' ' + errorThrown);
                callback('guest');
            })
}