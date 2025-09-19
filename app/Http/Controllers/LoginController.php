<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    /**
     * Afficher le formulaire de connexion
     */
    public function showLoginForm()
    {
        return view('login');
    }

    /**
     * Traiter la tentative de connexion
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            
            // Rediriger vers le bon tableau de bord selon le type d'utilisateur
            return $this->redirectToDashboard($user);
        }

        return back()->withErrors([
            'email' => 'Les informations de connexion ne correspondent pas à nos enregistrements.',
        ])->onlyInput('email');
    }

    /**
     * Déconnecter l'utilisateur
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('welcome');
    }

    /**
     * Rediriger vers le bon tableau de bord selon le type d'utilisateur
     */
    private function redirectToDashboard(User $user)
    {
        // Vérifier le type d'utilisateur selon le champ user_type
        switch ($user->user_type) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            
            case 'talent':
                return redirect()->route('talent.dashboard');
            
            case 'entreprise':
                return redirect()->route('entreprise.dashboard');
            
            default:
                // Par défaut, rediriger vers la page d'accueil si aucun type n'est défini
                return redirect()->route('welcome')->with('warning', 'Type d\'utilisateur non défini.');
        }
    }
}