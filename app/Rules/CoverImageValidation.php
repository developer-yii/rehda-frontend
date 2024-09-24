<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\UploadedFile;

class CoverImageValidation implements Rule
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
        $minWidth = 940;
        $maxWidth = 1000;
        $minHeight = 1060;
        $maxHeight = 1100;

        if ($width >= $minWidth && $width <= $maxWidth && $height >= $minHeight && $height <= $maxHeight) {
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
        return 'The :attribute must be a valid Image File (JPEG, PNG, or JPG) and have correct dimensions (940x1060, 1000x1100) for PNG and JPG.';
    }
}
