Feature: Cart quantity field only accepts multiples of 10
    In order to avoid invalid quantity input
    As a customer
    I want the cart quantity field to only accept multiples of 10

    Scenario: Add product to cart with valid quantity
        Given I am on the product page for "ocean-wave-jeans"
        When I add the product to the cart with quantity 10
        Then I should see the cart with "10" as the quantity

    Scenario: Add product to cart with invalid quantity
        Given I am on the product page for "ocean-wave-jeans"
        When I try to add the product to the cart with quantity 15
        Then I should see the cart with "10" as the quantity
        And I should see the message "The quantity must be a multiple of 10"

    Scenario: Update cart with valid quantity
        Given I have a product in the cart with quantity 10
        When I update the cart quantity to 20
        Then I should see the cart with "20" as the quantity

    Scenario: Update cart with invalid quantity
        Given I have a product in the cart with quantity 10
        When I update the cart quantity to 15
        Then I should see the cart with "10" as the quantity
        And I should see the message "The quantity must be a multiple of 10"
