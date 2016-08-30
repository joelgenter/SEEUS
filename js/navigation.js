var navigation = {
    home: {
        displayName: 'Home',
        url: 'views/home.php',
        displayFor: {
            authoritarian: true,
            user: true,
            guest: true
        }
    },
    login: {
        displayName: 'Login',
        url: 'views/login.php',
        displayFor: {
            authoritarian: false,
            user: false,
            guest: true
        }
    },
    register: {
        displayName: 'Register',
        url: 'views/register.php',
        displayFor: {
            authoritarian: false,
            user: false,
            guest: true
        }
    },
    dispatch: {
        displayName: 'Dispatch',
        url: 'views/escorts/dispatch.php',
        displayFor: {
            authoritarian: true,
            user: false,
            guest: false
        }
    },
    archive: {
        displayName: 'Archive',
        url: 'views/escorts/archive.php',
        displayFor: {
            authoritarian: true,
            user: false,
            guest: false
        }
    },
    request: {
        displayName: 'Request Escort',
        url: 'views/escorts/request.php',
        displayFor: {
            authoritarian: true,
            user: true,
            guest: false
        }
    },
    user: {
        displayName: 'My Escorts',
        url: 'views/escorts/user.php',
        displayFor: {
            authoritarian: true,
            user: true,
            guest: false
        }
    },
    settings: {
        displayName: 'Settings',
        url: 'views/settings.php',
        displayFor: {
            authoritarian: true,
            user: true,
            guest: false
        }
    },
    logout: {
        displayName: 'Logout',
        url: 'views/logout.php',
        displayFor: {
            authoritarian: true,
            user: true,
            guest: false
        }
    }
};