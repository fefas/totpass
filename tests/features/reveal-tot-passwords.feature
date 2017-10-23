@reveal
Feature: Reveal time-based one-time passwords
  In order to see my registered time-based one-time passwords
  As an user
  I want to list them by typing "totpass reveal [prefix-filter] [--with-secret]"

  Scenario: List when none was registered
    When I run the command "totpass reveal"
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
    When I run the command "totpass reveal"
    Then the exit status should be "0"
    And the following output should be seen:
      """
       dropbox
       google.fefas
      """
