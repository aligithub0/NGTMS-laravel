<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\User;
use App\Models\Company;
use App\Models\Department;
use App\Models\Designations;
use App\Models\Project;
use App\Models\Tickets;
use App\Models\TicketJourney;


class SuperDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-s-home';
    protected static string $view = 'filament.pages.super-dashboard';
    protected static ?string $navigationLabel = 'Super Dashboard';
    protected static ?string $title = 'Super Dashboard';
    protected static ?string $navigationGroup = 'Dashboard';
    

    // Optional: restrict access by role
    public static function canAccess(): bool
    {
        $roleName = auth()->user()?->role?->name ?? null;
        return in_array($roleName, ['Admin']);
    }

    public array $openTicketsPerDay = [];
    public array $closedTicketsPerDay = [];
    public array $categories = [];

     // Add this to inject data into the blade view
     public function mount()
     {
         $this->totalTickets   = Tickets::count();
         $this->totalUsers     = User::count();
         $this->totalCompanies = Company::count();
         $this->totalDepartments = Department::count();
         $this->totalDesignations = Designations::count();
         $this->totalProjects = Project::count();

         $this->recentJourneys = TicketJourney::with(['ticket', 'toAgent', 'toStatus'])
         ->orderBy('logged_time', 'desc')
         ->limit(5)
         ->get();

         $user = auth()->user();


         if ($user->hasRole('Admin')) {
            $this->openTickets = Tickets::whereHas('ticketStatus', fn($q) => $q->where('id', 3))->count();
            $this->assignedTickets = Tickets::where('assigned_to_id', $user->id)->count();
            $this->newTickets = Tickets::whereHas('ticketStatus', fn($q) => $q->where('id', 2))->count();
            $this->overdueTickets = Tickets::whereNotNull('assigned_to_id')
                ->whereHas('ticketStatus', fn($q) => $q->where('id', 8))
                ->where('resolution_time', '>', now())
                ->count();
            $this->inProgressTickets = Tickets::whereHas('ticketStatus', fn($q) => $q->where('id', 4))->count();
            $this->onHoldTickets = Tickets::whereHas('ticketStatus', fn($q) => $q->where('id', 5))->count();
            $this->reopenedTickets = Tickets::whereHas('ticketStatus', fn($q) => $q->where('id', 9))->count();

        } elseif ($user->hasRole('Manager')) {
            $agentIds = User::where('manager_id', $user->id)->pluck('id');

            $this->openTickets = Tickets::whereHas('ticketStatus', fn($q) => $q->where('id', 3))
                ->where(function($query) use ($user, $agentIds) {
                    $query->where('assigned_to_id', $user->id)
                        ->orWhereIn('assigned_to_id', $agentIds);
                })->count();

            $this->assignedTickets = Tickets::where('assigned_to_id', $user->id)->count();

            $this->newTickets = Tickets::whereNull('assigned_to_id')
                ->whereHas('ticketStatus', fn($q) => $q->where('id', 2))
                ->count();

            $this->overdueTickets = Tickets::where(function($query) use ($user, $agentIds) {
                    $query->where('assigned_to_id', $user->id)
                        ->orWhereIn('assigned_to_id', $agentIds);
                })
                ->where('resolution_time', '>', now())
                ->count();

            $this->inProgressTickets = Tickets::whereHas('ticketStatus', fn($q) => $q->where('id', 4))
                ->where(function($query) use ($user, $agentIds) {
                    $query->where('assigned_to_id', $user->id)
                        ->orWhereIn('assigned_to_id', $agentIds);
                })->count();

            $this->onHoldTickets = Tickets::whereHas('ticketStatus', fn($q) => $q->where('id', 5))
                ->where(function($query) use ($user, $agentIds) {
                    $query->where('assigned_to_id', $user->id)
                        ->orWhereIn('assigned_to_id', $agentIds);
                })->count();

            $this->reopenedTickets = Tickets::whereHas('ticketStatus', fn($q) => $q->where('id', 9))
                ->where(function($query) use ($user, $agentIds) {
                    $query->where('assigned_to_id', $user->id)
                        ->orWhereIn('assigned_to_id', $agentIds);
                })->count();

        } else {
            $this->openTickets = Tickets::whereHas('ticketStatus', fn($q) => $q->where('id', 3))
                ->where('assigned_to_id', $user->id)
                ->count();

            $this->assignedTickets = Tickets::where('assigned_to_id', $user->id)->count();

            $this->newTickets = Tickets::whereNull('assigned_to_id')
                ->whereHas('ticketStatus', fn($q) => $q->where('id', 2))
                ->count();

            $this->overdueTickets = Tickets::where('assigned_to_id', $user->id)
                ->where('resolution_time', '>', now())
                ->count();

            $this->inProgressTickets = Tickets::whereHas('ticketStatus', fn($q) => $q->where('id', 4))
                ->where('assigned_to_id', $user->id)
                ->count();

            $this->onHoldTickets = Tickets::whereHas('ticketStatus', fn($q) => $q->where('id', 5))
                ->where('assigned_to_id', $user->id)
                ->count();

            $this->reopenedTickets = Tickets::whereHas('ticketStatus', fn($q) => $q->where('id', 9))
                ->where('assigned_to_id', $user->id)
                ->count();
        }
    }
 
     protected function getViewData(): array
     {
         return [
             'totalTickets'     => $this->totalTickets,
             'openTickets' => $this->openTickets,
             'assignedTickets' => $this->assignedTickets,
             'newTickets' => $this->newTickets,
             'overdueTickets' => $this->overdueTickets,
             'inProgressTickets' => $this->inProgressTickets,
             'onHoldTickets' => $this->onHoldTickets,
             'reopenedTickets' => $this->reopenedTickets,

         ];
     }
}
