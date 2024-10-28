describe('Open eusedstore website', () => {
  it('should load the homepage', () => {
    cy.visit('http://localhost/eusedstore');
    cy.url().should('include', '/eusedstore');
  
     cy.visit('http://localhost/eusedstore');

    // Enter email and password
      cy.get('input#email').type('test2@test.com');
    cy.get('input#pass').type('qwerty');

    // Submit the login form
    cy.get('button[type="submit"]').click();

    // Verify successful login
    cy.url().should('include', '/eusedstore');

     // Accept the cookies
    cy.get('#cookieConsent').should('be.visible'); // Check if the modal is visible
    cy.get('#acceptCookies').click(); // Click the "Accept" button

    cy.get('a.btn.btn-dark').contains('Add Product').click();

    // Verify navigation to the add product page
    cy.url().should('include', '/create.php'); 
  });
});