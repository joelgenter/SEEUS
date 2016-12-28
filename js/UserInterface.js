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
                authoritarian: true,
                user: true,
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
        dispatch: {
            displayName: 'Dispatch',
            url: 'views/escorts/dispatch.html',
            displayFor: {
                authoritarian: true,
                user: false,
                guest: false
            }
        },
        archive: {
            displayName: 'Archive',
            url: 'views/escorts/archive.html',
            displayFor: {
                authoritarian: true,
                user: false,
                guest: false
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
        escorts: {
            displayName: 'Escorts',
            url: 'views/escorts/user.html',
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
    if (pageName in this.navigation)
        this.$contentElement.load(this.navigation[pageName].url);
    else
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
                    $newElement = $('<li>' + prototype.navigation[pageName]['displayName'] + '</li>');
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
        if (isOnline == 0) 
            isOnline = false;
        else 
            isOnline = true;
        
        if (isOnline)
            prototype.$statusElement.html('Status: Online');
        else
            prototype.$statusElement.html('Status: Offline');
    });
}