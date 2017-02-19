var UserInterface = function($contentElement, $menuElement, $statusElement) {
    //jquery vars instantiated at construction
    this.$contentElement = $contentElement;
    this.$menuElement = $menuElement;
    this.$statusElement = $statusElement;

    this.refreshTimer;
    this.updateStatusDisplayTimer;


    //object holding menu data
    this.navigation = {
        home: {
            displayName: 'Home',
            url: 'views/home.html',
            displayFor: {
                authoritarian: false,
                user: false,
                guest: true
            }
        },
        login: {
            displayName: 'Login',
            url: 'views/login.html',
            displayFor: {
                authoritarian: false,
                user: false,
                guest: true
            }
        },
        register: {
            displayName: 'Register',
            url: 'views/register.html',
            displayFor: {
                authoritarian: false,
                user: false,
                guest: true
            }
        },
        request: {
            displayName: 'Request Escort',
            url: 'views/escorts/request.html',
            displayFor: {
                authoritarian: false,
                user: true,
                guest: false
            }
        },
        view_escorts: {
            displayName: 'View Escorts',
            url: 'views/escorts/view_escorts.html',
            displayFor: {
                authoritarian: true,
                user: true,
                guest: false
            }
        },
        accountSettings: {
            displayName: 'Account Settings',
            url: 'views/account_settings.html',
            displayFor: {
                authoritarian: true,
                user: true,
                guest: false
            }
        },
        systemSettings: {
            displayName: 'System Settings',
            url: 'views/system_settings.html',
            displayFor: {
                authoritarian: true,
                user: false,
                guest: false
            }
        },
        logout: {
            displayName: 'Logout',
            url: 'views/logout.html',
            displayFor: {
                authoritarian: true,
                user: true,
                guest: false
            }
        },
        email_verification: {
            url: 'views/email_verification.html',
            displayFor: {
                authoritarian: false,
                user: false,
                guest: false
            }
        },
        forgotPassword: {
            url: 'views/forgot_password.html',
            displayFor: {
                authoritarian: false,
                user: false,
                guest: false
            }
        }
    };
}

UserInterface.prototype.loadContent = function(pageName) {
    if (pageName in this.navigation) {
        this.$contentElement.load(this.navigation[pageName].url);
        this.$menuElement.children("li").removeAttr("class");
        this.$menuElement.find("#" + pageName).attr("class", "active");
    } else
        $contentElement.html('Page not found');
}

UserInterface.prototype.getUserType = function(callback) {
    $.get('php/Get_User_Type.php')
    .done(function(data) {
        callback(data);
    })
    .fail(function() {
        callback('guest');
    })
}

UserInterface.prototype.populateSelectOptions = function($selectElement, arrayOfOptions) {
    var $newElement;
    for (var i = 0; i < arrayOfOptions.length; i++) {
        $newElement = $('<option>' + arrayOfOptions[i] + '</option>');
        $selectElement.append($newElement);
    }
}

UserInterface.prototype.getLocationsDestinations = function(callback) {
    $.get('php/Get_Locations_Destinations.php')
    .done(function(locationDestinationList) {
        callback(locationDestinationList);
    })
}

UserInterface.prototype.refreshMenu = function() {
    this.$menuElement.empty();
    var prototype = this;
    this.getUserType(function(userType) {
        //To address unrecognized user types
        if (userType != 'authoritarian' && userType != 'user')
            userType = 'guest';
        var $newElement;
        for (pageName in prototype.navigation) {
            if (prototype.navigation[pageName]['displayFor'][userType]) {
                (function(pageName) {
                    $newElement = $('<li id="' + pageName + '">' + prototype.navigation[pageName]['displayName'] + '</li>');
                    $newElement.on('click', function() {
                        prototype.loadContent(pageName)
                    });
                    prototype.$menuElement.append($newElement);  //improve performance by moving the final append outside of loop
                })(pageName);
            }
        }
    })
}

UserInterface.prototype.updateStatusDisplay = function() {
    var prototype = this;
    $.post('php/Get_Status.php')
    .done(function(isOnline) {
        // prototype.$statusElement.html(isOnline);            //testing
        // console.log(isOnline);                              //testing
        // if (isOnline == 0)
        //     isOnline = false;
        // else 
        //     isOnline = true;
        
        // if (isOnline)
        //     prototype.$statusElement.html('Status: <span class="success">Online</span>');
        // else
        //     prototype.$statusElement.html('Status: <span class="error">Offline</span>');
    });
}

UserInterface.prototype.arrayToHTML = function(arrayOfStrings) {
    var html = "";
    for (var i = 0; i < arrayOfStrings.length; i++) {
        html += arrayOfStrings[i] + '<br>';
    }
    return html;
}

UserInterface.prototype.writeErrorResponse = function($responseElement, message) {
    $responseElement.removeAttr("class");
    $responseElement.attr("class", "error");
    $responseElement.html(message);
}

UserInterface.prototype.writeSuccessResponse = function($responseElement, message) {
    $responseElement.removeAttr("class");
    $responseElement.attr("class", "success");
    $responseElement.html(message);
}