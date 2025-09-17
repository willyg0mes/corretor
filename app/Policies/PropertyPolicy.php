<?php

namespace App\Policies;

use App\Models\Property;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PropertyPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true; // Todos podem ver a listagem de imóveis
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Property $property): bool
    {
        // Todos podem ver imóveis publicados e ativos
        // Usuários logados também podem ver seus próprios imóveis ou (se admin) todos
        return $property->isAvailable() ||
               ($user && ($user->id === $property->user_id || $user->isAdmin()));
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Apenas corretores e admins podem criar imóveis
        return $user->isCorretor() || $user->isAdmin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Property $property): bool
    {
        // Todos os corretores e admins podem editar qualquer imóvel
        return $user->isCorretor() || $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Property $property): bool
    {
        // Todos os corretores e admins podem excluir qualquer imóvel
        return $user->isCorretor() || $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Property $property): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Property $property): bool
    {
        return false;
    }
}
