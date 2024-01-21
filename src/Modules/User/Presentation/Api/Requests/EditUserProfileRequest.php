<?php declare(strict_types=1);

namespace Modules\User\Presentation\Api\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;
use App\Models\User;

class EditUserProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nick' => ['string', 'max:255', 'nullable'],
            'bio' => ['string', 'nullable'],
            'picture' => ['file', 'mimes:jpeg,png,jpg', 'max:10240', 'nullable'],
        ];
    }
}
