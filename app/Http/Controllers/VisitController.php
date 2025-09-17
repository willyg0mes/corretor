<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Visit;
use App\Services\VisitService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VisitController extends Controller
{
    protected $visitService;

    public function __construct(VisitService $visitService)
    {
        $this->visitService = $visitService;
    }

    /**
     * Show the form for creating a new visit
     */
    public function create(Property $property)
    {
        return view('visits.create', compact('property'));
    }

    /**
     * Display a listing of visits for the authenticated user
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->isCorretor()) {
            $visits = $user->receivedVisits()->with(['property', 'client'])->paginate(15);
        } else {
            $visits = $user->scheduledVisits()->with(['property', 'agent'])->paginate(15);
        }

        return view('visits.index', compact('visits'));
    }

    /**
     * Store a new visit request
     */
    public function store(Request $request, Property $property)
    {
        $validated = $request->validate([
            'scheduled_at' => 'required|date|after:now',
            'notes' => 'nullable|string|max:500',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
        ]);

        $visit = $this->visitService->scheduleVisit(
            Auth::user(),
            $property->user,
            $property,
            $validated['scheduled_at'],
            $validated
        );

        return redirect()->back()->with('success', 'Visita agendada com sucesso!');
    }

    /**
     * Display the specified visit
     */
    public function show(Visit $visit)
    {
        $this->authorize('view', $visit);

        return view('visits.show', compact('visit'));
    }

    /**
     * Confirm a visit (agent only)
     */
    public function confirm(Visit $visit)
    {
        $this->authorize('update', $visit);

        $visit->confirm();

        return redirect()->back()->with('success', 'Visita confirmada');
    }

    /**
     * Complete a visit (agent only)
     */
    public function complete(Visit $visit)
    {
        $this->authorize('update', $visit);

        $visit->complete();

        return redirect()->back()->with('success', 'Visita concluída');
    }

    /**
     * Cancel a visit
     */
    public function cancel(Request $request, Visit $visit)
    {
        $this->authorize('update', $visit);

        $request->validate([
            'reason' => 'nullable|string|max:255',
        ]);

        $visit->cancel($request->reason);

        return redirect()->back()->with('success', 'Visita cancelada');
    }
}
