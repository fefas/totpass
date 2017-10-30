@reveal
Feature: Reveal time-based one-time passwords
  In order to see my registered time-based one-time passwords
  As an user
  I want to list them by typing the following command:
    "totpass reveal [prefix-filter] [--with-secret] [--date-time='YYYY-MM-DD HH:mm:ss']"

  Scenario: When none was registered
    When I run the command "totpass reveal"
    Then the exit status should be "0"
    And the following output should be seen:
      """
      Nothing to show..
      """

  Scenario: Basic reveal without extra arguments or options
    Given the following time-based one-time passwords were registered:
      | TOTP Name | Secret           | Refresh Period |
      | dropbox   | JBSWY3DPEHPK3PXP | 30             |
      | google    | JDDK4U6G3BJLEZ7Y | 30             |
    When I run the command "totpass reveal --date-time='2017-11-02 09:10:00'"
    Then the exit status should be "0"
    And the following output should be seen:
      """
      Considered date time: 2017-11-02 09:10:00
       dropbox 462553
       google  634423
      """

  Scenario: Passing with-secret option that also reveals the secret
    Given the following time-based one-time passwords were registered:
      | TOTP Name | Secret           | Refresh Period |
      | dropbox   | JBSWY3DPEHPK3PXP | 30             |
      | google    | JDDK4U6G3BJLEZ7Y | 30             |
    When I run the command "totpass reveal --date-time='2017-11-02 09:10:00' --with-secret"
    Then the exit status should be "0"
    And the following output should be seen:
      """
      Considered date time: 2017-11-02 09:10:00
       dropbox 462553 JBSWY3DPEHPK3PXP
       google  634423 JDDK4U6G3BJLEZ7Y
      """
