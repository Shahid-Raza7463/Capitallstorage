<?php

// Custom validation rule
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ExcelColumnHeading implements Rule
{
    protected $expectedHeadings;

    public function __construct(array $expectedHeadings)
    {
        $this->expectedHeadings = $expectedHeadings;
    }

    public function passes($attribute, $value)
    {
        $headings = \Excel::toArray([], $value)[0][0]; // Get headings from Excel file

        return count(array_diff($this->expectedHeadings, $headings)) === 0;
    }

    public function message()
    {
        return 'The Excel file should have the following columns: ' . implode(', ', $this->expectedHeadings);
    }
}
