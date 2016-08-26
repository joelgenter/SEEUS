var navigation = {
    home: {
        displayName: 'Home',
        url: 'home.php',
        displayFor: {
            authoritarian: true,
            user: true,
            guest: true
        }
    },
    login: {
        displayName: 'Login',
        url: 'login.php',
        displayFor: {
            authoritarian: false,
            user: false,
            guest: true
        }
    },
    register: {
        displayName: 'Register',
        url: 'register.php',
        displayFor: {
            authoritarian: false,
            user: false,
            guest: true
        }
    },
    dispatch: {
        displayName: 'Dispatch',
        url: 'dispatch.php',
        displayFor: {
            authoritarian: true,
            user: false,
            guest: false
        }
    },
    archive: {
        displayName: 'Archive',
        url: 'archive.php',
        displayFor: {
            authoritarian: true,
            user: false,
            guest: false
        }
    },
    request: {
        displayName: 'Request Escort',
        url: 'request.php',
        displayFor: {
            authoritarian: true,
            user: true,
            guest: false
        }
    },
    user: {
        displayName: 'My Escorts',
        url: 'home.php',
        displayFor: {
            authoritarian: true,
            user: true,
            guest: false
        }
    },
    settings: {
        displayName: 'Settings',
        url: 'settings.php',
        displayFor: {
            authoritarian: true,
            user: true,
            guest: false
        }
    },
    logout: {
        displayName: 'Logout',
        url: 'logout.php',
        displayFor: {
            authoritarian: true,
            user: true,
            guest: false
        }
    }
};