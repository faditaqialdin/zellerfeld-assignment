<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Annotations as OA;

/**
 * Class PostStoreRequest
 *
 * @OA\Schema(
 *     schema="PostStoreRequest",
 *     type="object",
 *     required={"content"},
 *     @OA\Property(
 *         property="content",
 *         type="string",
 *         description="The content of the post",
 *         maxLength=280
 *     )
 * )
 *
 * Handles validation and authorization for storing a new post.
 */
class PostStoreRequest extends FormRequest
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
        return $this->route('user')?->is($this->user());
    }

    /**
     * Defines the validation rules for the post store request.
     *
     * @OA\Property(
     *     property="rules",
     *     type="object",
     *     description="Validation rules for the request",
     *     @OA\Property(
     *         property="content",
     *         type="string",
     *         description="The content of the post",
     *         maxLength=280
     *     )
     * )
     *
     * @return array The array of validation rules.
     */
    public function rules(): array
    {
        return [
            'content' => ['required', 'string', 'max:280'],
        ];
    }
}
