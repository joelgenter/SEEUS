describe("changeContent() should load content for", function() {
    var $contentContainer = setFixtures('<div></div>');

    var navigationObject = {
        existingPage: {
            url: 'specs/ajax_files/existing_page.html',
            displayFor: {
                authoritarian: true,
                user: true,
                guest: true
            }
        },
        pageWithWrongURL: {
            url: 'wrongURL',
            displayFor: {
                authoritarian: true,
                user: true,
                guest: true
            }
        }
    };

    describe('pages in the navigation object', function() {
        beforeEach(function(done) {
            $contentContainer.on("DOMSubtreeModified", function() {
                if ($contentContainer.text() != '') done();
            });
            changeContent($contentContainer, navigationObject, 'existingPage');
        });

        it('', function() {
            expect($contentContainer.text()).toEqual('existing_page is present');
        });  
    });
    
    describe('pages not in the navigation object', function() {
        beforeEach(function(done) {
            $contentContainer.on("DOMSubtreeModified", function() {
                if ($contentContainer.text() != '') done();
            });
            changeContent($contentContainer, navigationObject, 'nonExistentPage');
        });

        it('', function() {
            expect($contentContainer.text()).toEqual('Page not found');
        });  
    });

    describe('pages with a wrong url in the navigation object', function() {
        beforeEach(function(done) {
            changeContent($contentContainer, navigationObject, 'pageWithWrongURL');
            $contentContainer.on("DOMSubtreeModified", function() {
                if ($contentContainer.text() != '') done();
            });
        });

        it('', function() {
            expect($contentContainer.text()).toEqual('Page not found');
        });  
    });
});
