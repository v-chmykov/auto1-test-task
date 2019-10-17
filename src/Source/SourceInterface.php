<?php

namespace App\Source;


interface SourceInterface
{
    public function fetchAll(): iterable;
}