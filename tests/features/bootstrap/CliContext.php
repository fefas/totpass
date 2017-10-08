<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;

class CliContext implements Context
{
    private $workDir;
    private $output;
    private $exitStatus;

    public function __construct(string $workDir)
    {
        $this->workDir = rtrim($workDir, '/');
    }

    /**
     * @When I run the command :command
     */
    public function iRunTheCommand(string $command)
    {
        $output = [];
        $exitStatus = null;

        exec("{$this->workDir}/$command", $output, $exitStatus);

        $this->output = $output;
        $this->exitStatus = $exitStatus;
    }

    /**
     * @Then the exit status should be :expectedExitStatus
     */
    public function theExitStatusShouldBe($expectedExitStatus)
    {
        assertEquals($expectedExitStatus, $this->exitStatus);
    }

    /**
     * @Then the following output should be seen:
     */
    public function theFollowingOutputShouldBeSeen(PyStringNode $expectedOutput)
    {
        $expectedOutput = $expectedOutput->getStrings();

        foreach ($expectedOutput as $i => $line) {
            $expectedOutput[$i] = preg_replace('/\s+/', ' ', $line);
        }
        foreach ($this->output as $i => $line) {
            $this->output[$i] = preg_replace('/\s+/', ' ', $line);
        }

        assertEquals($expectedOutput, $this->output);
    }
}
