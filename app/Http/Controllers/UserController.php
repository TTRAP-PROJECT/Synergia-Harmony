<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserController extends Controller
{
    public function valideUser(Request $request)
    {

        $user = Utilisateur::where('EMAILUTILISATEUR', $request->email)->first();

        if (!$user) {
            return response()->json(false);
        }

        $isValidPassword = password_verify($request->password, $user->MOTDEPASSE);

        // Renvoyer true si le mot de passe est valide, sinon renvoyer false
        return response()->json($isValidPassword);
    }




    public function getUsers(Request $request)
    {
        $users = Utilisateur::all();
        return response()->json($users, 200, [], JSON_UNESCAPED_UNICODE);
    }


    public function getUsersWithoutPassword(Request $request)
    {
        $users = Utilisateur::select('IDUTILISATEUR', 'NOMUTILISATEUR', 'PRENOMUTILISATEUR', 'SOLDE', 'EMAILUTILISATEUR')
            ->get();
        return response()->json($users, 200, [], JSON_UNESCAPED_UNICODE);
    }


    public function getUserById(Request $request, $userId)
    {
        return response()->json(Utilisateur::find($userId));
    }


    public function addUser(Request $request)
    {
        $user = new Utilisateur();
        $user->NOMUTILISATEUR = $request->NOMUTILISATEUR;
        $user->PRENOMUTILISATEUR = $request->PRENOMUTILISATEUR;
        $user->MOTDEPASSE = bcrypt($request->MOTDEPASSE);
        $user->SOLDE = 10;
        $user->EMAILUTILISATEUR = $request->EMAILUTILISATEUR;
        $user->save();
        return response()->json($user);
    }


    public function modifyUser(Request $request, $userId)
    {

        $this->validate($request, [
            'NOMUTILISATEUR' => 'required|string',
            'PRENOMUTILISATEUR' => 'required|string',
            'MOTDEPASSE' => 'required|string',
            'EMAILUTILISATEUR' => 'required|email',
        ]);

        $user = Utilisateur::find($userId);

        if (!$user) {
            return response()->json(['message' => 'Utilisateur non trouvé'], 404);
        }

        $user->NOMUTILISATEUR = $request->NOMUTILISATEUR;
        $user->PRENOMUTILISATEUR = $request->PRENOMUTILISATEUR;
        $user->MOTDEPASSE = bcrypt($request->MOTDEPASSE);
        $user->EMAILUTILISATEUR = $request->EMAILUTILISATEUR;

        $user->save();

        return response()->json($user, 200, [], JSON_UNESCAPED_UNICODE);
    }

    public function deleteUser(Request $request, $userId)
    {
        $user = Utilisateur::find($userId);

        if (!$user) {
            return response()->json(['message' => 'Utilisateur non trouvé.'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'Utilisateur supprimé avec succès.']);
    }

    public function addMonnaie(Request $request, $userId)
    {
        $user = Utilisateur::find($userId);
        if (!$user) {
            return response()->json(['message' => 'Utilisateur non trouvé'], 404);
        }
        if($request->post("SOLDE", 0)<0 || $request->post("SOLDE", 0)>10000)
        {
            return response()->json(['message' => 'Borne dépassé'], 404);
        }

        $user->SOLDE +=  $request->post("SOLDE", 0);
        $user->save();

        return response()->json($user, 200, [], JSON_UNESCAPED_UNICODE);
    }

    public function removeMonnaie(Request $request, $userId)
    {
        $user = Utilisateur::find($userId);
        if (!$user) {
            return response()->json(['message' => 'Utilisateur non trouvé'], 404);
        }
        if($request->post("SOLDE", 0)<0 || $request->post("SOLDE", 0)>10000)
        {
            return response()->json(['message' => 'Borne dépassé'], 404);
        }

        $user->SOLDE -=  $request->post("SOLDE", 0);
        $user->save();

        return response()->json($user, 200, [], JSON_UNESCAPED_UNICODE);
    }

    public function getUserByEmail(Request $request, $email)
    {
        $user = Utilisateur::where('EMAILUTILISATEUR', $email)->first();
        return response()->json($user, 200, [], JSON_UNESCAPED_UNICODE);
    }




}
