<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\UploadedFile;

class BackgroundImageValidation implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (!$value instanceof UploadedFile || !$value->isValid()) {
            return false;
        }

        // Check for file extension
        $extension = strtolower($value->getClientOriginalExtension());
        if (!in_array($extension, ['jpeg', 'jpg', 'png'])) {
            return false;
        }

        // Check dimensions
        list($width, $height) = getimagesize($value);

        // Define the acceptable range for width and height
        $minWidth = 1920;
        $minHeight = 1080;

        if ($width === $minWidth && $height === $minHeight) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be a valid Image File (JPEG, PNG, or JPG) and have correct dimensions (1920x1080) for PNG and JPG.';
    }
}
