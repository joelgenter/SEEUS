//all urls are relative to index.html
var navigation = {
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
            authoritarian: true,
            user: true,
            guest: false
        }
    },
    user: {
        displayName: 'My Escorts',
        url: 'views/escorts/user.html',
        displayFor: {
            authoritarian: true,
            user: true,
            guest: false
        }
    },
    settings: {
        displayName: 'Settings',
        url: 'views/settings.html',
        displayFor: {
            authoritarian: true,
            user: true,
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
    }
};

var ajaxAddresses = {
    getUserType: "php/get_user_type.php"
}