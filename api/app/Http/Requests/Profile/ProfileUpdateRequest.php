<?php

namespace App\Http\Requests\Profile;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use OpenApi\Annotations as OA;

/**
 * Class ProfileUpdateRequest
 *
 * @OA\Schema(
 *     schema="ProfileUpdateRequest",
 *     type="object",
 *     description="Request schema for updating a user's profile",
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="The new name of the user",
 *         maxLength=255,
 *         nullable=true
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email",
 *         description="The new email address of the user",
 *         maxLength=255,
 *         nullable=true
 *     ),
 *     @OA\Property(
 *         property="password",
 *         type="string",
 *         description="The new password for the user",
 *         nullable=true
 *     )
 * )
 *
 * Handles validation and authorization for updating a user's profile.
 */
class ProfileUpdateRequest extends FormRequest
{
    /**
     * Defines the validation rules for the profile update request.
     *
     * @OA\Property(
     *     property="rules",
     *     type="object",
     *     description="Validation rules for the request",
     *     @OA\Property(
     *         property="name",
     *         type="string",
     *         description="The new name of the user",
     *         maxLength=255,
     *         nullable=true
     *     ),
     *     @OA\Property(
     *         property="email",
     *         type="string",
     *         format="email",
     *         description="The new email address of the user",
     *         maxLength=255,
     *         nullable=true
     *     ),
     *     @OA\Property(
     *         property="password",
     *         type="string",
     *         description="The new password for the user",
     *         nullable=true
     *     )
     * )
     *
     * @return array The array of validation rules.
     */
    public function rules(): array
    {
        return [
            'name' => ['string', 'max:255'],
            'email' => [
                'string',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore(auth()->id()),
            ],
            'password' => ['string', Password::default()],
        ];
    }
}
