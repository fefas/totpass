@register
Feature: Register new time-based one-time password
  In order to register a new time-based one-time password
  As an user
  I want to provide the name, the secret and, optionaly, the algorithm and the lentgh

  Scenario: Try to register without providing a name and a secret
    When I run the command "totpass register"
    Then the exit status should be "1"
    And the following output should be seen:
      """


        [Symfony\Component\Console\Exception\RuntimeException]
        Not enough arguments (missing: "name, secret").


      register [--refresh-period [REFRESH-PERIOD]] [--] <name> <secret>

      """

  Scenario: Try to register without providing a name and a secret
    When I run the command "totpass register sample.name"
    Then the exit status should be "1"
    And the following output should be seen:
      """


        [Symfony\Component\Console\Exception\RuntimeException]
        Not enough arguments (missing: "secret").


      register [--refresh-period [REFRESH-PERIOD]] [--] <name> <secret>

      """

  Scenario: Register providing the only the required arguments (name and secret)
    When I run the command "totpass register google.fefas JDDK4U6G3BJLEZ7Y"
    Then the exit status should be "0"
    And the following output should be seen:
      """
      The new TOT password with name 'google.fefas' was successfully registered.
      """
    And the following time-based one-time passwords should be registered:
      | TOT Password | Secret           | Refresh Period |
      | google.fefas | JDDK4U6G3BJLEZ7Y | 30             |

  Scenario: Register providing the refresh period
    When I run the command "totpass register google.fefas JDDK4U6G3BJLEZ7Y --refresh-period 45"
    #Then the exit status should be "0"
    And the following output should be seen:
      """
      The new TOT password with name 'google.fefas' was successfully registered.
      """
    And the following time-based one-time passwords should be registered:
      | TOT Password | Secret           | Refresh Period |
      | google.fefas | JDDK4U6G3BJLEZ7Y | 45             |
