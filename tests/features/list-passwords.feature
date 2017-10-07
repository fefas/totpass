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
