<?php

namespace Fefas\TotPass\TotPassword\Model;

interface TotPasswordRepository
{
    public function findAll(): array;
    public function register(TotPassword $totPassword): void;
}
