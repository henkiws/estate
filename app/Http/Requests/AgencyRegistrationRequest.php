<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class AgencyRegistrationRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            // Agency Information (Section 1)
            'agency_name' => ['required', 'string', 'max:255'],
            'trading_name' => ['nullable', 'string', 'max:255'],
            'abn' => [
                'required',
                'string',
                'regex:/^[0-9\s]{11,14}$/',
                'unique:agencies,abn'
            ],
            'acn' => [
                'nullable',
                'string',
                'regex:/^[0-9\s]{9,11}$/'
            ],
            'business_type' => ['required', 'in:sole_trader,partnership,company'],
            'license_number' => [
                'required',
                'string',
                'max:50',
                'unique:agencies,license_number'
            ],
            'license_holder' => ['required', 'string', 'max:255'],
            'license_expiry_date' => ['nullable', 'date', 'after:today'],
            
            // Address Information
            'business_address' => ['required', 'string', 'max:500'],
            'state' => ['required', 'in:NSW,VIC,QLD,WA,SA,TAS,ACT,NT'],
            'postcode' => ['required', 'string', 'regex:/^[0-9]{4}$/'],
            
            // Contact Information
            'business_phone' => ['required', 'string', 'max:20'],
            'business_email' => [
                'required',
                'email',
                'max:255',
                'unique:agencies,business_email'
            ],
            'website' => ['nullable', 'url', 'max:255'],
            
            // Login Account (Section 3)
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email'
            ],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ],
            'password_confirmation' => ['required'],
            
            // Terms (Section 8)
            'terms' => ['required', 'accepted'],
        ];
    }

    /**
     * Get custom validation messages
     */
    public function messages(): array
    {
        return [
            'agency_name.required' => 'Agency name is required.',
            'abn.required' => 'ABN is required.',
            'abn.regex' => 'ABN must be 11 digits.',
            'abn.unique' => 'This ABN is already registered.',
            'acn.regex' => 'ACN must be 9 digits.',
            'license_number.required' => 'Real Estate License Number is required.',
            'license_number.unique' => 'This license number is already registered.',
            'license_holder.required' => 'License holder name is required.',
            'business_address.required' => 'Business address is required.',
            'state.required' => 'State/Territory is required.',
            'state.in' => 'Please select a valid Australian state or territory.',
            'postcode.required' => 'Postcode is required.',
            'postcode.regex' => 'Postcode must be 4 digits.',
            'business_phone.required' => 'Business phone number is required.',
            'business_email.required' => 'Business email is required.',
            'business_email.unique' => 'This business email is already registered.',
            'email.required' => 'Email address is required.',
            'email.unique' => 'This email is already registered.',
            'password.required' => 'Password is required.',
            'password.confirmed' => 'Password confirmation does not match.',
            'terms.accepted' => 'You must accept the terms and conditions.',
        ];
    }

    /**
     * Get custom attribute names
     */
    public function attributes(): array
    {
        return [
            'agency_name' => 'agency name',
            'trading_name' => 'business trading name',
            'abn' => 'ABN',
            'acn' => 'ACN',
            'license_number' => 'license number',
            'license_holder' => 'license holder name',
            'business_address' => 'business address',
            'state' => 'state/territory',
            'postcode' => 'postcode',
            'business_phone' => 'business phone',
            'business_email' => 'business email',
            'website' => 'website URL',
            'email' => 'email address',
            'password' => 'password',
        ];
    }

    /**
     * Prepare data for validation
     */
    protected function prepareForValidation(): void
    {
        // Clean ABN and ACN (remove spaces for storage)
        if ($this->has('abn')) {
            $this->merge([
                'abn' => preg_replace('/\s+/', '', $this->abn)
            ]);
        }

        if ($this->has('acn')) {
            $this->merge([
                'acn' => preg_replace('/\s+/', '', $this->acn)
            ]);
        }
    }
}