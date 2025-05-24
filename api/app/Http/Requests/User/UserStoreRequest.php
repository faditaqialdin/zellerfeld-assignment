<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use OpenApi\Annotations as OA;

/**
 * Class UserStoreRequest
 *
 * @OA\Schema(
 *     schema="UserStoreRequest",
 *     type="object",
 *     description="Request schema for creating a new user",
 *     required={"name", "email", "password"},
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="The name of the user",
 *         maxLength=255
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email",
 *         description="The email address of the user",
 *         maxLength=255
 *     ),
 *     @OA\Property(
 *         property="password",
 *         type="string",
 *         description="The password for the user"
 *     )
 * )
 *
 * Handles validation and authorization for storing a new user.
 */
class UserStoreRequest extends FormRequest
{
    /**
     * Determines if the user is authorized to make this request.
     *
     * @OA\Property(
     *     property="authorize",
     *     type="boolean",
     *     description="Indicates if the user is authorized to make this request"
     * )
     *
     * @return bool True if the user is authorized, false otherwise.
     */
    public function authorize(): bool
    {
        return true; // Adjust authorization logic as needed
    }

    /**
     * Defines the validation rules for the user store request.
     *
     * @OA\Property(
     *     property="rules",
     *     type="object",
     *     description="Validation rules for the request",
     *     @OA\Property(
     *         property="name",
     *         type="string",
     *         description="The name of the user",
     *         maxLength=255
     *     ),
     *     @OA\Property(
     *         property="email",
     *         type="string",
     *         format="email",
     *         description="The email address of the user",
     *         maxLength=255
     *     ),
     *     @OA\Property(
     *         property="password",
     *         type="string",
     *         description="The password for the user"
     *     )
     * )
     *
     * @return array The array of validation rules.
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => [
                'required',
                'string',
                Password::default(),
            ],
        ];
    }
}
