<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Annotations as OA;

/**
 * Class LogoutRequest
 *
 * Handles validation rules for user logout requests.
 *
 * @OA\Schema(
 *     schema="LogoutRequest",
 *     type="object",
 *     description="Schema for logout request"
 * )
 */
class LogoutRequest extends FormRequest
{
    /**
     * Defines the validation rules for the logout request.
     *
     * @return array The array of validation rules.
     */
    public function rules(): array
    {
        return [
            // No specific validation rules are defined for logout requests.
        ];
    }
}
