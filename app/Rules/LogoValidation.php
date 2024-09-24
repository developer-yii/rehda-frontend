<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\UploadedFile;

class LogoValidation implements Rule
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
        // $minWidth = 500;
        // $maxWidth = 600;
        // $minHeight = 250;
        // $maxHeight = 350;

        $minWidth = 200;
        $maxWidth = 1200;
        $minHeight = 200;
        $maxHeight = 1200;

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
        return 'The :attribute must be a valid Image File (JPEG, PNG, or JPG) and have correct dimensions (500x250, 600x350) for PNG and JPG.';
    }
}
