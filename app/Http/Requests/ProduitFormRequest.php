<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProduitFormRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'nom_produit' => 'required','regex:/^[A-Za-z0-9]+$/','unique:produits','min:3',
            'prix_unitaire_achat'=>'required','numeric','min:1',
            'prix_unitaire_vente' =>'required','numeric','min:1',
    
        ];
        
    }
    public function messages(): array
    {
        return [
            
            'nom_produit.required' => 'Le nom du produit est obligatoire.',
            'nom_produit.min' => 'Le nom du produit ne doit pas être inférieur à 3 caractères  .',
            'nom_produit.regex' => "Le nom du produit n'accepte que les caractères alphanumeriques.",

            'prix_unitaire_achat.required' => 'Le prix unitaire achat est obligatoire.',
            'prix_unitaire_achat.numeric' => 'Le prix unitaire achat doit être un nombre.',
            'prix_unitaire_achat.min' => 'Le prix unitaire achat ne peut pas 0.',

            'prix_unitaire_vente.required' => 'Le prix unitaire de vente est obligatoire.',
            'prix_unitaire_vente.numeric' => 'Le prix unitaire de vente doit être un nombre.',
            'prix_unitaire_vente.min' => 'Le prix unitaire de vente ne peut pas 0.',
            
        ];
    }
}
