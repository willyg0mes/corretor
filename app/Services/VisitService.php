<?php

namespace App\Services;

use App\Models\Property;
use App\Models\User;
use App\Models\Visit;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class VisitService
{
    /**
     * Schedule a new visit
     */
    public function scheduleVisit(User $client, User $agent, Property $property, string $scheduledAt, array $visitInfo = []): Visit
    {
        $scheduledDateTime = Carbon::parse($scheduledAt);

        $visit = Visit::create([
            'property_id' => $property->id,
            'client_id' => $client->id,
            'agent_id' => $agent->id,
            'scheduled_at' => $scheduledDateTime,
            'status' => Visit::STATUS_PENDING,
            'notes' => $visitInfo['notes'] ?? null,
            'client_info' => [
                'phone' => $visitInfo['phone'] ?? $client->phone,
                'email' => $visitInfo['email'] ?? $client->email,
            ],
        ]);

        // Send notification email
        $this->sendVisitNotification($visit);

        return $visit;
    }

    /**
     * Send visit notification email
     */
    private function sendVisitNotification(Visit $visit): void
    {
        try {
            // In a real application, you'd send an email here
            // Mail::to($visit->agent->email)->send(new VisitScheduledNotification($visit));

            // For now, just log it
            \Log::info('Visit notification would be sent', [
                'visit_id' => $visit->id,
                'agent_email' => $visit->agent->email,
                'client_name' => $visit->client->name,
                'property_title' => $visit->property->title,
                'scheduled_at' => $visit->scheduled_at->format('d/m/Y H:i'),
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to send visit notification: ' . $e->getMessage());
        }
    }

    /**
     * Confirm a visit
     */
    public function confirmVisit(Visit $visit): void
    {
        $visit->confirm();

        // Send confirmation email to client
        $this->sendVisitConfirmation($visit);
    }

    /**
     * Send visit confirmation email
     */
    private function sendVisitConfirmation(Visit $visit): void
    {
        try {
            // Mail::to($visit->client->email)->send(new VisitConfirmedNotification($visit));

            \Log::info('Visit confirmation would be sent', [
                'visit_id' => $visit->id,
                'client_email' => $visit->client->email,
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to send visit confirmation: ' . $e->getMessage());
        }
    }

    /**
     * Complete a visit
     */
    public function completeVisit(Visit $visit): void
    {
        $visit->complete();

        // Could send feedback request email here
    }

    /**
     * Cancel a visit
     */
    public function cancelVisit(Visit $visit, ?string $reason = null): void
    {
        $visit->cancel($reason);

        // Send cancellation notification
        $this->sendVisitCancellation($visit);
    }

    /**
     * Send visit cancellation email
     */
    private function sendVisitCancellation(Visit $visit): void
    {
        try {
            // Send to both client and agent
            // Mail::to($visit->client->email)->send(new VisitCancelledNotification($visit, 'client'));
            // Mail::to($visit->agent->email)->send(new VisitCancelledNotification($visit, 'agent'));

            \Log::info('Visit cancellation would be sent', [
                'visit_id' => $visit->id,
                'reason' => $visit->cancellation_reason,
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to send visit cancellation: ' . $e->getMessage());
        }
    }

    /**
     * Get upcoming visits for user
     */
    public function getUpcomingVisits(User $user, int $limit = null): \Illuminate\Database\Eloquent\Collection
    {
        $query = $user->isCorretor()
            ? $user->receivedVisits()
            : $user->scheduledVisits();

        $query->where('status', Visit::STATUS_CONFIRMED)
            ->where('scheduled_at', '>', now())
            ->with(['property', 'client', 'agent'])
            ->orderBy('scheduled_at');

        if ($limit) {
            $query->limit($limit);
        }

        return $query->get();
    }

    /**
     * Get visit statistics for user
     */
    public function getVisitStats(User $user): array
    {
        if ($user->isCorretor()) {
            $visits = $user->receivedVisits();
        } else {
            $visits = $user->scheduledVisits();
        }

        return [
            'total' => $visits->count(),
            'pending' => (clone $visits)->where('status', Visit::STATUS_PENDING)->count(),
            'confirmed' => (clone $visits)->where('status', Visit::STATUS_CONFIRMED)->count(),
            'completed' => (clone $visits)->where('status', Visit::STATUS_COMPLETED)->count(),
            'cancelled' => (clone $visits)->where('status', Visit::STATUS_CANCELLED)->count(),
            'upcoming' => (clone $visits)->where('status', Visit::STATUS_CONFIRMED)
                ->where('scheduled_at', '>', now())->count(),
        ];
    }

    /**
     * Check if user can schedule visit for property
     */
    public function canScheduleVisit(User $user, Property $property): bool
    {
        // User cannot schedule visit for their own property
        if ($property->user_id === $user->id) {
            return false;
        }

        // Check if user already has a pending or confirmed visit for this property
        return !$user->scheduledVisits()
            ->where('property_id', $property->id)
            ->whereIn('status', [Visit::STATUS_PENDING, Visit::STATUS_CONFIRMED])
            ->exists();
    }
}
