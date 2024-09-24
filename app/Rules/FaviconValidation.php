<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\UploadedFile;

class FaviconValidation implements Rule
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
        if (!in_array($extension, ['png', 'gif', 'ico'])) {
            return false;
        }

        // Skip dimension check for .ico files
        if ($extension === 'ico') {
            return true;
        }

        // Check dimensions for other types
        list($width, $height) = getimagesize($value);
        $allowedDimensions = [[16, 16], [32, 32], [48, 48]];

        foreach ($allowedDimensions as $dimension) {
            if ($width === $dimension[0] && $height === $dimension[1]) {
                return true;
            }
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
        return 'The :attribute must be a valid favicon (ICO, PNG, or GIF) and have correct dimensions (16x16, 32x32, etc.) for PNG and GIF.';
    }
}
