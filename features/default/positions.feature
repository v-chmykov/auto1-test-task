Feature: Positions end-point

  Scenario: Check that end-point returning all positions
    When I am on "/v1/positions/"
    Then the response status code should be 200
    And the response is JSON
    And the response contains at least 1 elements

  Scenario: Check that end-point returning positions filtered by country
    When I am on "/v1/positions/?country=DE"
    Then the response status code should be 200
    And the response is JSON
    And the response contains at least 1 elements
    And every position in response has a field country with value DE

  Scenario: Check that end-point returning positions filtered by city
    When I am on "/v1/positions/?city=Berlin"
    Then the response status code should be 200
    And the response is JSON
    And the response contains at least 1 elements
    And every position in response has a field city with value Berlin

  Scenario: Check that end-point returning position by ID
    When I am on "/v1/positions/1"
    Then the response status code should be 200
    And the response is JSON
    And the response contains id equals 1

  Scenario: Check that end-point with wrong ID returning 404
    When I am on "/v1/positions/987654321987654321"
    Then the response status code should be 404
    And the response is JSON

  Scenario: Check that end-point with no skills returning 400
    When I am on "/v1/positions/most_interesting"
    Then the response status code should be 400
    And the response is JSON

  Scenario: Check that end-point with empty skills returning 400
    When I am on "/v1/positions/most_interesting?skills"
    Then the response status code should be 400
    And the response is JSON

  Scenario: Check that end-point with invalid skills returning 404
    When I am on "/v1/positions/most_interesting?skills=brainfuck"
    Then the response status code should be 404
    And the response is JSON

  Scenario: Check that end-point with PHP skills returning positions that contains 'php' skill
    When I am on "/v1/positions/most_interesting?skills=PHP,MySQL"
    Then the response status code should be 200
    And the response is JSON
    And the response contains at least 1 elements
    And every position in response has skill PHP,MySQL
