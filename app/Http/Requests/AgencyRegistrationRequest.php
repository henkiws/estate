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
            // Section 1: Agency Information
            'agency_name' => ['required', 'string', 'max:255', 'unique:agencies,agency_name'],
            'trading_name' => ['required', 'string', 'max:255'],
            'abn' => ['required', 'string', 'size:11', 'regex:/^[0-9]{11}$/', 'unique:agencies,abn'],
            'business_type' => ['required', 'in:sole_trader,partnership,company'],
            'acn' => ['nullable', 'string', 'size:9', 'regex:/^[0-9]{9}$/'],
            'license_number' => ['required', 'string', 'max:50', 'unique:agencies,license_number'],
            'license_holder' => ['required', 'string', 'max:255'],
            'business_address' => ['required', 'string', 'max:500'],
            'state' => ['required', 'in:NSW,VIC,QLD,WA,SA,TAS,ACT,NT'],
            'postcode' => ['required', 'string', 'size:4', 'regex:/^[0-9]{4}$/'],
            'business_phone' => ['required', 'string', 'max:20'],
            'business_email' => ['required', 'email', 'max:255', 'unique:agencies,business_email'],
            'website' => ['required', 'url', 'max:255'],
            
            // Section 2: Login Account
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)],
            'password_confirmation' => ['required'],
            
            // Terms
            'terms' => ['required', 'accepted'],
        ];
    }

    /**
     * Get custom error messages
     */
    public function messages(): array
    {
        return [
            // Agency Information
            'agency_name.required' => 'Agency name is required.',
            'agency_name.unique' => 'This agency name is already registered.',
            'trading_name.required' => 'Business trading name is required.',
            'abn.required' => 'ABN is required.',
            'abn.size' => 'ABN must be exactly 11 digits.',
            'abn.regex' => 'ABN must contain only numbers (no spaces).',
            'abn.unique' => 'This ABN is already registered.',
            'business_type.required' => 'Please select a business type.',
            'acn.size' => 'ACN must be exactly 9 digits.',
            'acn.regex' => 'ACN must contain only numbers.',
            'license_number.required' => 'Real estate license number is required.',
            'license_number.unique' => 'This license number is already registered.',
            'license_holder.required' => 'License holder name is required.',
            'business_address.required' => 'Business address is required.',
            'state.required' => 'Please select a state/territory.',
            'postcode.required' => 'Postcode is required.',
            'postcode.size' => 'Postcode must be 4 digits.',
            'postcode.regex' => 'Postcode must contain only numbers.',
            'business_phone.required' => 'Business phone number is required.',
            'business_email.required' => 'Business email is required.',
            'business_email.email' => 'Please provide a valid email address.',
            'business_email.unique' => 'This business email is already registered.',
            'website.required' => 'Website URL is required.',
            'website.url' => 'Please provide a valid website URL.',
            
            // Login Account
            'email.required' => 'Email address is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'This email is already registered.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
            'password_confirmation.required' => 'Please confirm your password.',
            
            // Terms
            'terms.required' => 'You must accept the terms and conditions.',
            'terms.accepted' => 'You must accept the terms and conditions.',
        ];
    }

    /**
     * Get custom attribute names
     */
    public function attributes(): array
    {
        return [
            'abn' => 'ABN',
            'acn' => 'ACN',
            'business_email' => 'business email',
            'license_holder' => 'license holder name',
        ];
    }

    /**
     * Prepare data for validation
     */
    protected function prepareForValidation(): void
    {
        // Remove spaces from ABN and ACN
        if ($this->has('abn')) {
            $this->merge([
                'abn' => str_replace(' ', '', $this->abn),
            ]);
        }

        if ($this->has('acn')) {
            $this->merge([
                'acn' => str_replace(' ', '', $this->acn),
            ]);
        }
    }
}