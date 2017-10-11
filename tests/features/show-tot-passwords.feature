Feature: List time-based one-time passwords
  In order to see the registered time-based one-time passwords
  As an user
  I want to list them by typing "totpass list [prefix-filter] [--reveal-secret]"

  Scenario: List when none was registered
    When I run the command "totpass show"
    Then the exit status should be "0"
    And the following output should be seen:
      """
      Nothing to show..
      """

  Scenario: List without arguments and options
    Given the following time-based one-time passwords were registered:
      | TOT Password | Secret | Refresh Period |
      | dropbox      | SECRET | 30             |
      | google.fefas | SECRET | 30             |
    When I run the command "totpass show"
    #Then the exit status should be "0"
    And the following output should be seen:
      """
      +-------------------------------+
      | Time-Based One-Time Passwords |
      +-------------------------------+
      | Name                          |
      +-------------------------------+
      | dropbox                       |
      | google.fefas                  |
      +-------------------------------+
      """
