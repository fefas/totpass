Feature: List time-based one-time passwords
  In order to see the registered time-based one-time passwords
  As an user
  I want to list them by typing "totp list [prefix-filter] [--reveal-secret]"

  Scenario: List when none was registered
    When I run the command "totp list"
    Then the exit status should be "0"
    And the following output should be seen:
      """
      Nothing to show..
      """

  Scenario: List without arguments and options
    Given the following time-based one-time passwords were registered:
      | Password     | Created At          |
      | dropbox      | 2016-03-14 10:12:53 |
      | google.fefas | 2016-09-22 23:07:22 |
    When I run the command "totp list"
    Then the exit status should be "0"
    And the following output should be seen:
      """
      Password       Created At
      dropbox        2016-03-14 10:12:53
      google.fefas   2016-09-22 23:07:22
      """
