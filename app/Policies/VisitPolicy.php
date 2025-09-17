<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Visit;
use Illuminate\Auth\Access\Response;

class VisitPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true; // Todos os usuários podem ver suas visitas
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Visit $visit): bool
    {
        // Usuário pode ver se é o cliente ou agente da visita
        return $user->id === $visit->client_id ||
               $user->id === $visit->agent_id ||
               $user->isAdmin();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true; // Todos os usuários podem agendar visitas
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Visit $visit): bool
    {
        // Cliente pode cancelar suas próprias visitas
        // Agente pode confirmar/completar/cancelar visitas que recebeu
        // Admin pode fazer tudo
        if ($user->isAdmin()) {
            return true;
        }

        $isClient = $user->id === $visit->client_id;
        $isAgent = $user->id === $visit->agent_id;

        // Cliente só pode cancelar se a visita não foi confirmada ainda
        if ($isClient && in_array($visit->status, [Visit::STATUS_PENDING])) {
            return true;
        }

        // Agente pode confirmar, completar ou cancelar visitas
        if ($isAgent && $visit->canBeModified()) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Visit $visit): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Visit $visit): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Visit $visit): bool
    {
        return false;
    }
}
