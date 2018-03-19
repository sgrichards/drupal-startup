Feature: Content
  In order to test some basic Behat functionality
  As a website user
  I need to be able to see that the Drupal driver is working

  @api
  Scenario: Create many nodes
    Given "page" content:
      | title    |
      | Page one |
      | Page two |
    And "article" content:
      | title          |
      | First article  |
      | Second article |
    And I am logged in as a user with the "administrator" role
    When I go to "admin/content"
    Then I should see "Page one"
    And I should see "Page two"
    And I should see "First article"
    And I should see "Second article"
