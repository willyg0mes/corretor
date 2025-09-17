<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Property;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            return $this->adminDashboard();
        } elseif ($user->isCorretor()) {
            return $this->corretorDashboard();
        } else {
            return $this->clienteDashboard();
        }
    }

    private function adminDashboard()
    {
        $stats = [
            'total_properties' => Property::count(),
            'active_properties' => Property::active()->count(),
            'total_users' => \App\Models\User::count(),
            'total_contacts' => Contact::count(),
            'total_visits' => Visit::count(),
            'recent_properties' => Property::with('user')->latest()->limit(5)->get(),
            'recent_contacts' => Contact::with(['property', 'sender'])->latest()->limit(5)->get(),
        ];

        return view('dashboard.admin', compact('stats'));
    }

    private function corretorDashboard()
    {
        $user = Auth::user();

        $stats = [
            'my_properties' => $user->properties()->count(),
            'total_properties' => Property::count(),
            'active_properties' => Property::active()->count(),
            'total_views' => Property::sum('views'),
            'unread_contacts' => $user->receivedContacts()->where('status', Contact::STATUS_SENT)->count(),
            // 'upcoming_visits' => $user->receivedVisits()->where('status', Visit::STATUS_CONFIRMED)->where('scheduled_at', '>', now())->count(), // Desabilitado temporariamente
            'recent_properties' => Property::latest()->limit(5)->get(),
            'recent_contacts' => $user->receivedContacts()->with('sender')->latest()->limit(5)->get(),
        ];

        return view('dashboard.corretor', compact('stats'));
    }

    private function clienteDashboard()
    {
        $user = Auth::user();

        $stats = [
            'favorite_properties' => $user->favorites()->count(),
            'sent_contacts' => $user->sentContacts()->count(),
            'scheduled_visits' => $user->scheduledVisits()->where('status', Visit::STATUS_CONFIRMED)->count(),
            'recent_favorites' => $user->favorites()->with('property.images')->latest()->limit(5)->get(),
            'recent_contacts' => $user->sentContacts()->with(['property', 'receiver'])->latest()->limit(5)->get(),
        ];

        return view('dashboard.cliente', compact('stats'));
    }

    /**
     * Página de relatórios para corretores
     */
    public function relatorios()
    {
        $user = Auth::user();

        // Estatísticas detalhadas para relatórios
        $stats = [
            'total_properties' => Property::count(),
            'my_properties' => $user->properties()->count(),
            'active_properties' => Property::active()->count(),
            'my_active_properties' => $user->properties()->active()->count(),
            'total_views' => Property::sum('views'),
            'my_views' => $user->properties()->sum('views'),
            'total_contacts' => Contact::count(),
            'my_contacts' => $user->receivedContacts()->count(),
            'unread_contacts' => $user->receivedContacts()->where('status', Contact::STATUS_SENT)->count(),
            // 'total_visits' => Visit::count(), // Desabilitado temporariamente
            // 'my_visits' => $user->receivedVisits()->count(), // Desabilitado temporariamente
            // 'confirmed_visits' => $user->receivedVisits()->where('status', Visit::STATUS_CONFIRMED)->count(), // Desabilitado temporariamente

            // Dados para gráficos (últimos 30 dias)
            'properties_last_30_days' => Property::where('created_at', '>=', now()->subDays(30))->count(),
            'contacts_last_30_days' => Contact::where('created_at', '>=', now()->subDays(30))->count(),
            // 'visits_last_30_days' => Visit::where('created_at', '>=', now()->subDays(30))->count(), // Desabilitado temporariamente

            // Propriedades por categoria
            'properties_by_category' => Property::selectRaw('categories.name as category_name, COUNT(*) as count')
                ->join('categories', 'properties.category_id', '=', 'categories.id')
                ->groupBy('categories.id', 'categories.name')
                ->get(),

            // Propriedades por status
            'properties_by_status' => Property::selectRaw('status, COUNT(*) as count')
                ->groupBy('status')
                ->get(),

            // Contatos por status
            'contacts_by_status' => Contact::selectRaw('status, COUNT(*) as count')
                ->groupBy('status')
                ->get(),
        ];

        return view('dashboard.relatorios', compact('stats'));
    }

    /**
     * Página de configurações para corretores
     */
    public function configuracoes()
    {
        $user = Auth::user();

        return view('dashboard.configuracoes', compact('user'));
    }
}
