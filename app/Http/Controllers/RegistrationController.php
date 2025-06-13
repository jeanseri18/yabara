<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Talent;
use App\Models\Entreprise;
use App\Models\Pole;
use App\Models\FamilleMetier;

class RegistrationController extends Controller
{
    public function showRegistrationForm()
    {
        $poles = Pole::orderBy('ordre_affichage')->get();
        return view('auth.register', compact('poles'));
    }

    public function showTalentForm()
    {
        $poles = Pole::orderBy('ordre_affichage')->get();
        $famillesMetiers = FamilleMetier::orderBy('ordre_affichage')->get();
        return view('auth.register-talent', compact('poles', 'famillesMetiers'));
    }

    public function showEntrepriseForm()
    {
        $poles = Pole::orderBy('ordre_affichage')->get();
        return view('auth.register-entreprise', compact('poles'));
    }

    public function registerTalent(Request $request)
    {
        // Validation complète pour inscription
        $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'pole_id' => 'nullable|exists:poles,id',
            'famille_metier_id' => 'nullable|exists:familles_metiers,id',
            'niveau_etude' => 'nullable|in:BAC,BAC+1,BAC+2,BAC+3,BAC+4,BAC+5,BAC+6,BAC+7,BAC+8',
            'avatar_type' => 'nullable|string|max:50'
        ]);

        DB::beginTransaction();
        try {
            // Créer l'utilisateur
            $name = trim($request->first_name . ' ' . $request->last_name);
            
            $user = User::create([
                'name' => $name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'user_type' => 'talent',
                'status' => 'active'
            ]);

            // Générer une référence CV unique
            $cvReference = 'CV' . str_pad($user->id, 6, '0', STR_PAD_LEFT);

            // Créer le profil talent complet
            Talent::create([
                'user_id' => $user->id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'pole_id' => $request->pole_id,
                'famille_metier_id' => $request->famille_metier_id,
                'niveau_etude' => $request->niveau_etude,
                'cv_reference' => $cvReference,
                'avatar_type' => $request->avatar_type,
                'profile_completion_percentage' => 60.00 // 60% pour les informations de base
            ]);

            DB::commit();
            return redirect()->route('registration.success', ['type' => 'talent', 'user' => $user->id]);
        } catch (\Exception $e) {
            DB::rollback();
            // Log the detailed error message for debugging
            \Illuminate\Support\Facades\Log::error('Talent Registration Error: ' . $e->getMessage() . '\n' . $e->getTraceAsString());
            return back()->withErrors(['error' => 'Une erreur est survenue lors de la création du compte: ' . $e->getMessage()])->withInput();
        }
    }

    public function registerEntreprise(Request $request)
    {
        // Validation complète pour inscription
        $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'nom_entreprise' => 'required|string|max:255',
            'pole_activite_id' => 'nullable|exists:poles,id',
            'numero_legal' => 'nullable|string|max:100',
            'effectif' => 'nullable|in:<50,50-100,100-500,>500',
            'responsable_rh_nom' => 'nullable|string|max:255',
            'responsable_rh_prenom' => 'nullable|string|max:255'
        ]);

        DB::beginTransaction();
        try {
            // Créer l'utilisateur
            $user = User::create([
                'name' => $request->nom_entreprise,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'user_type' => 'entreprise',
                'status' => 'pending'
            ]);

            // Créer le profil entreprise complet
            Entreprise::create([
                'user_id' => $user->id,
                'nom_entreprise' => $request->nom_entreprise,
                'pole_activite_id' => $request->pole_activite_id,
                'numero_legal' => $request->numero_legal,
                'effectif' => $request->effectif,
                'responsable_rh_nom' => $request->responsable_rh_nom,
                'responsable_rh_prenom' => $request->responsable_rh_prenom,
                'is_verified' => false
            ]);

            DB::commit();
            return redirect()->route('registration.success', ['type' => 'entreprise', 'user' => $user->id]);
        } catch (\Exception $e) {
            DB::rollback();
            // Log the detailed error message for debugging
            \Illuminate\Support\Facades\Log::error('Entreprise Registration Error: ' . $e->getMessage() . '\n' . $e->getTraceAsString());
            return back()->withErrors(['error' => 'Une erreur est survenue lors de la création du compte: ' . $e->getMessage()])->withInput();
        }
    }

    public function getFamillesMetiers($poleId)
    {
        $famillesMetiers = FamilleMetier::where('pole_id', $poleId)
            ->orderBy('ordre_affichage')
            ->get(['id', 'nom']);
        
        return response()->json($famillesMetiers);
    }

    public function showRegistrationSuccess(Request $request)
    {
        $userType = $request->get('type');
        $userId = $request->get('user');
        
        if (!in_array($userType, ['talent', 'entreprise']) || !$userId) {
            return redirect()->route('welcome');
        }
        
        $user = User::with([$userType])->find($userId);
        
        if (!$user) {
            return redirect()->route('welcome');
        }
        
        // Charger les relations nécessaires selon le type d'utilisateur
        if ($userType === 'talent') {
            $user->load('talent.pole', 'talent.familleMetier');
        } else {
            $user->load('entreprise.pole');
        }
        
        return view('auth.registration-success', compact('user', 'userType'));
    }

}