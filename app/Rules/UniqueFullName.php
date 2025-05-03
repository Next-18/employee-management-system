<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Employee;

class UniqueFullName implements Rule
{
    protected $firstName;
    protected $lastName;
    protected $excludeId;

    /**
     * Constructor to initialize the rule with the first name, last name, and optional ID to exclude.
     */
    public function __construct($firstName, $lastName, $excludeId = null)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->excludeId = $excludeId;
    }

    /**
     * Check if the combination of FirstName and LastName is unique.
     */
    public function passes($attribute, $value)
    {
        $query = Employee::where('FirstName', $this->firstName)
            ->where('LastName', $this->lastName);

        if ($this->excludeId) {
            $query->where('id', '!=', $this->excludeId);
        }

        return !$query->exists();
    }

    /**
     * Error message for validation failure.
     */
    public function message()
    {
        return 'This employee already exists in the system. Please check the name and try again.';
    }
}