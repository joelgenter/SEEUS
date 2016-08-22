describe("changeContent() should load content for", function() {
    var $contentContainer = setFixtures('');

    var navigationObject = {
        existingPage: {
            displayName: 'Existing Page',
            url: 'specs/ajax_files/existing_page.html',
            displayFor: {
                authoritarian: true,
                user: true,
                guest: true
            }
        },
        pageWithWrongURL: {
            displayName: 'Page with Wrong URL',
            url: 'wrongURL',
            displayFor: {
                authoritarian: true,
                user: true,
                guest: true
            }
        }
    };

    var pageName;

    beforeEach(function(){
        $contentContainer.empty();
    });

    describe('pages in the navigation object', function() {
        beforeEach(function(done) {
            pageName = 'existingPage';
            $contentContainer.on("DOMSubtreeModified", function() {
                if ($contentContainer.text() != '') done();
            });
            changeContent($contentContainer, navigationObject, pageName);
        });

        it('', function() {
            expect($contentContainer.text()).toEqual('existing_page is present');
        });  
    });
    
    describe('pages not in the navigation object', function() {
        beforeEach(function(done) {
            pageName = 'nonExistentPage';
            $contentContainer.on("DOMSubtreeModified", function() {
                if ($contentContainer.text() != '') done();
            });
            changeContent($contentContainer, navigationObject, pageName);
        });

        it('', function() {
            expect($contentContainer.text()).toEqual('Page not found');
        });  
    });

    describe('pages with a wrong url in the navigation object', function() {
        beforeEach(function(done) {
            pageName = 'pageWithWrongURL';
            $contentContainer.on("DOMSubtreeModified", function() {
                if ($contentContainer.text() != '') done();
            });
            changeContent($contentContainer, navigationObject, pageName);
        });

        it('', function() {
            expect($contentContainer.text()).toEqual('Page not found');
        });  
    });

});

describe('changeMenu() should', function() {
    var $menuContainer = setFixtures('');
    
    var $contentContainer = setFixtures('');

    var navigationObject = {
        pageWithWrongURL: {
            displayName: 'Page with Wrong URL',
            url: 'wrongURL',
            displayFor: {
                authoritarian: true,
                user: true,
                guest: true
            }
        },
        pageForGuests: {
            displayName: 'Guest Page',
            url: 'specs/ajax_files/guest_page.html',
            displayFor: {
                authoritarian: false,
                user: false,
                guest: true
            }
        },
        pageForUsers: {
            displayName: 'User Page',
            url: 'specs/ajax_files/user_page.html',
            displayFor: {
                authoritarian: false,
                user: true,
                guest: false
            }
        },
        pageForAuthoritarians: {
            displayName: 'Authoritarian Page',
            url: 'specs/ajax_files/authoritarian_page.html',
            displayFor: {
                authoritarian: true,
                user: false,
                guest: false
            }
        }
    };

    var userType;

    beforeEach(function(){
        $menuContainer.empty();
        $contentContainer.empty();
    });

    describe('load guest menu items for "guest" user type', function() {
        //call changeMenu() with the guest user type
        beforeEach(function(done) {
            userType = 'guest';
            $menuContainer.on("DOMSubtreeModified", function() {
                if ($menuContainer.text() != '') done();
            });
            changeMenu($menuContainer, navigationObject, userType, $contentContainer);
        });

        //simulate clicking 'Guest Page' li
        beforeEach(function(done) {
            $contentContainer.on("DOMSubtreeModified", function() {
                if ($contentContainer.text() != '') done();
            });
            $menuContainer.children().trigger('click');
        });

        it('', function() {
            expect($contentContainer.text()).toBe('guest_page is present');
            expect($menuContainer.html()).toContain('<li>Guest Page</li>');
        }); 
    });

    describe('load user menu items for "user" user type', function() {
        //call changeMenu() with the user user type
        beforeEach(function(done) {
            userType = 'user';
            $menuContainer.on("DOMSubtreeModified", function() {
                if ($menuContainer.text() != '') done();
            });
            changeMenu($menuContainer, navigationObject, userType, $contentContainer);
        });

        //simulate clicking 'User Page' li
        beforeEach(function(done) {
            $contentContainer.on("DOMSubtreeModified", function() {
                if ($contentContainer.text() != '') done();
            });
            $menuContainer.children().trigger('click');
        });

        it('', function() {
            expect($contentContainer.text()).toBe('user_page is present');
            expect($menuContainer.html()).toContain('<li>User Page</li>');
        }); 
    });
    
    describe('load authoritarian menu items for "authoritarian" user type', function() {
        //call changeMenu() with the authoritarian user type
        beforeEach(function(done) {
            userType = 'authoritarian';
            $menuContainer.on("DOMSubtreeModified", function() {
                if ($menuContainer.text() != '') done();
            });
            changeMenu($menuContainer, navigationObject, userType, $contentContainer);
        });

        //simulate clicking 'Authoritarian Page' li
        beforeEach(function(done) {
            $contentContainer.on("DOMSubtreeModified", function() {
                if ($contentContainer.text() != '') done();
            });
            $menuContainer.children().trigger('click');
        });

        it('', function() {
            expect($contentContainer.text()).toBe('authoritarian_page is present');
            expect($menuContainer.html()).toContain('<li>Authoritarian Page</li>');
        }); 
    });

    describe('load guest menu items for unrecognized user types', function() {
        //call changeMenu() with an unknown user type
        beforeEach(function(done) {
            userType = 'unrecognizedUserType';
            $menuContainer.on("DOMSubtreeModified", function() {
                if ($menuContainer.text() != '') done();
            });
            changeMenu($menuContainer, navigationObject, userType, $contentContainer);
        });

        //simulate clicking 'Guest Page' li
        beforeEach(function(done) {
            $contentContainer.on("DOMSubtreeModified", function() {
                if ($contentContainer.text() != '') done();
            });
            $menuContainer.children().trigger('click');
        });

        it('', function() {
            expect($contentContainer.text()).toBe('guest_page is present');
            expect($menuContainer.html()).toContain('<li>Guest Page</li>');
        }); 
    }); 

    describe('not load menu items if it has a wrong url', function() {
        //call changeMenu() with the guest user type
        beforeEach(function(done) {
            userType = 'guest';
            $menuContainer.on("DOMSubtreeModified", function() {
                if ($menuContainer.text() != '') done();
            });
            changeMenu($menuContainer, navigationObject, userType, $contentContainer);
        });

        it('', function() {
            expect($menuContainer.html()).not.toContain('<li>Page with Wrong URL</li>');
        }); 
    });
});