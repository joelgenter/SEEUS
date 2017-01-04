describe("changeContent() should load content for", function() {
    var $viewContainer = setFixtures('');

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
        $viewContainer.empty();
    });

    describe('pages in the navigation object', function() {
        beforeEach(function(done) {
            pageName = 'existingPage';
            $viewContainer.on("DOMSubtreeModified", function() {
                if ($viewContainer.text() != '') done();
            });
            changeContent($viewContainer, navigationObject, pageName);
        });

        it('', function() {
            expect($viewContainer.text()).toEqual('existing_page is present');
        });  
    });
    
    describe('pages not in the navigation object', function() {
        beforeEach(function(done) {
            pageName = 'nonExistentPage';
            $viewContainer.on("DOMSubtreeModified", function() {
                if ($viewContainer.text() != '') done();
            });
            changeContent($viewContainer, navigationObject, pageName);
        });

        it('', function() {
            expect($viewContainer.text()).toEqual('Page not found');
        });  
    });

    describe('pages with a wrong url in the navigation object', function() {
        beforeEach(function(done) {
            pageName = 'pageWithWrongURL';
            $viewContainer.on("DOMSubtreeModified", function() {
                if ($viewContainer.text() != '') done();
            });
            changeContent($viewContainer, navigationObject, pageName);
        });

        it('', function() {
            expect($viewContainer.text()).toEqual('Page not found');
        });  
    });

});

describe('changeMenu() should', function() {
    var $menu = setFixtures('');
    
    var $viewContainer = setFixtures('');

    var navigationObject = {
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
        $menu.empty();
        $viewContainer.empty();
    });

    describe('load only guest menu items for "guest" user type', function() {
        //call changeMenu() with the guest user type
        beforeEach(function(done) {
            userType = 'guest';
            $menu.on("DOMSubtreeModified", function() {
                if ($menu.text() != '') done();
            });
            changeMenu($menu, navigationObject, userType, $viewContainer);
        });

        //simulate clicking 'Guest Page' li
        beforeEach(function(done) {
            $viewContainer.on("DOMSubtreeModified", function() {
                if ($viewContainer.text() != '') done();
            });
            $menu.children().trigger('click');
        });

        it('', function() {
            expect($viewContainer.text()).toBe('guest_page is present');
            expect($menu.html()).toContain('<li>Guest Page</li>');
            expect($menu.children().length).toBe(1);
        }); 
    });

    describe('load only user menu items for "user" user type', function() {
        //call changeMenu() with the user user type
        beforeEach(function(done) {
            userType = 'user';
            $menu.on("DOMSubtreeModified", function() {
                if ($menu.text() != '') done();
            });
            changeMenu($menu, navigationObject, userType, $viewContainer);
        });

        //simulate clicking 'User Page' li
        beforeEach(function(done) {
            $viewContainer.on("DOMSubtreeModified", function() {
                if ($viewContainer.text() != '') done();
            });
            $menu.children().trigger('click');
        });

        it('', function() {
            expect($viewContainer.text()).toBe('user_page is present');
            expect($menu.html()).toContain('<li>User Page</li>');
            expect($menu.children().length).toBe(1);
        }); 
    });
    
    describe('load only authoritarian menu items for "authoritarian" user type', function() {
        //call changeMenu() with the authoritarian user type
        beforeEach(function(done) {
            userType = 'authoritarian';
            $menu.on("DOMSubtreeModified", function() {
                if ($menu.text() != '') done();
            });
            changeMenu($menu, navigationObject, userType, $viewContainer);
        });

        //simulate clicking 'Authoritarian Page' li
        beforeEach(function(done) {
            $viewContainer.on("DOMSubtreeModified", function() {
                if ($viewContainer.text() != '') done();
            });
            $menu.children().trigger('click');
        });

        it('', function() {
            expect($viewContainer.text()).toBe('authoritarian_page is present');
            expect($menu.html()).toContain('<li>Authoritarian Page</li>');
            expect($menu.children().length).toBe(1);
        }); 
    });

    describe('load only guest menu items for unrecognized user types', function() {
        //call changeMenu() with an unknown user type
        beforeEach(function(done) {
            userType = 'unrecognizedUserType';
            $menu.on("DOMSubtreeModified", function() {
                if ($menu.text() != '') done();
            });
            changeMenu($menu, navigationObject, userType, $viewContainer);
        });

        //simulate clicking 'Guest Page' li
        beforeEach(function(done) {
            $viewContainer.on("DOMSubtreeModified", function() {
                if ($viewContainer.text() != '') done();
            });
            $menu.children().trigger('click');
        });

        it('', function() {
            expect($viewContainer.text()).toBe('guest_page is present');
            expect($menu.html()).toContain('<li>Guest Page</li>');
            expect($menu.children().length).toBe(1);
        }); 
    }); 

});

describe('getUserType() should return', function() {
    var userType;
    var ajaxAddresses;
    var checkVarInterval;

    beforeEach(function() {
        userType = undefined;
    });

    describe('"guest" userType when the ajax in the function fails', function() {
        beforeEach(function(done) {
            ajaxAddresses = {
                getUserType: 'specs/ajax_files/nonExistentPage.php'
            };
            getUserType(ajaxAddresses, function(data){userType = data});
            checkVarInterval = setInterval(function() {
                if (userType != undefined) {
                    clearInterval(checkVarInterval);
                    done();
                }
            }, 5);
        });

        it('', function() {
            expect(userType).toEqual('guest');
        });
    });

    describe('a userType when the ajax in the function is successful', function() {
        beforeEach(function(done) {
            ajaxAddresses = {
                getUserType: 'specs/ajax_files/existing_file.php'
            };
            getUserType(ajaxAddresses, function(data){userType = data});
            checkVarInterval = setInterval(function() {
                if (userType != undefined) {
                    clearInterval(checkVarInterval);
                    done();
                }
            }, 5);
        })

        it('', function() {
            expect(userType).toEqual('authoritarian');
        });
    });
});