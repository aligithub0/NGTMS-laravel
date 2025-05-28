<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\User;
use App\Models\Company;
use App\Models\Department;
use App\Models\Designations;
use App\Models\Project;
use App\Models\Purpose;
use App\Models\Tickets;
use App\Models\TicketJourney;
use App\Models\TicketStatus;
use App\Models\SlaConfiguration;
use App\Models\Priority;


class SuperDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-s-home';
    protected static string $view = 'filament.pages.super-dashboard';
    protected static ?string $navigationLabel = 'Dashboard Cookies';
    protected static ?string $title = 'Dashboard Cookies';
    protected static ?string $navigationGroup = 'Dashboard';
    
    public array $departments = [];
    public array $statuses = [];
    public array $ticketsData = [];    



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

        //  Calculate Tickets Status By Department 

        $departments = \App\Models\Department::all();
        $statuses = \App\Models\TicketStatus::all();
        
        // 1. Build abbreviation function
        $abbreviate = function ($name) {
            $name = trim(preg_replace('/\s+/', ' ', $name));
            $words = explode(' ', $name);
            if (count($words) === 1) return strtoupper(substr($words[0], 0, 1));
            if (is_numeric($words[1])) return strtoupper(substr($words[0], 0, 1)) . $words[1];
            return strtoupper(implode('', array_map(fn($w) => $w[0], $words)));
        };
        
        // Build counts matrix
        $countsMatrix = [];
        foreach ($departments as $department) {
            foreach ($statuses as $status) {
                $userIds = \App\Models\User::where('department_id', $department->id)->pluck('id');
                $count = \App\Models\Tickets::where('ticket_status_id', $status->id)
                    ->whereIn('assigned_to_id', $userIds)
                    ->count();
                $countsMatrix[$status->id][$department->id] = $count;
            }
        }
        
        // Filter statuses with data
        $nonZeroStatusIds = [];
        foreach ($statuses as $status) {
            foreach ($departments as $department) {
                if (($countsMatrix[$status->id][$department->id] ?? 0) > 0) {
                    $nonZeroStatusIds[] = $status->id;
                    break;
                }
            }
        }
        $filteredStatuses = $statuses->whereIn('id', $nonZeroStatusIds)->values();
        $statusNames = $filteredStatuses->pluck('name')->map(function ($name) {
            if (strtolower($name) === 'on hold') return 'OH';
            if (str_contains($name, ' ')) {
                return collect(explode(' ', $name))->map(function ($w) { return strtoupper($w[0]); })->implode('');
            }
            return strtoupper(substr($name, 0, 1));
        })->toArray();
        
        // Filter departments with data (now based on filtered statuses)
        $nonZeroDepartmentIds = [];
        foreach ($departments as $department) {
            foreach ($filteredStatuses as $status) {
                if (($countsMatrix[$status->id][$department->id] ?? 0) > 0) {
                    $nonZeroDepartmentIds[] = $department->id;
                    break;
                }
            }
        }
        $filteredDepartments = $departments->whereIn('id', $nonZeroDepartmentIds)->values();
        $departmentNames = $filteredDepartments->pluck('name')->map($abbreviate)->toArray();
        
        // Build data series for only those departments
        $data = [];
        foreach ($filteredDepartments as $department) {
            $series = [];
            foreach ($filteredStatuses as $status) {
                $series[] = $countsMatrix[$status->id][$department->id] ?? 0;
            }
            $data[] = [
                'name' => $abbreviate($department->name),
                'data' => $series,
            ];
        }
        
        $this->statuses = $statusNames;
        $this->departments = $departmentNames;
        $this->ticketsData = $data;
        

        //  Calculate SLA compliance 
        $totalTicketsWithSLA = Tickets::whereNotNull('SLA')->count();
        $totalSLACompliant = Tickets::whereNotNull('SLA')
            ->whereColumn('resolution_time', '>=', 'SLA') // replace this with your actual compliance check
            ->count();

        $slaCompliance = $totalTicketsWithSLA > 0
            ? round(($totalSLACompliant / $totalTicketsWithSLA) * 100)
            : 0;

        $totalSLAs = SlaConfiguration::count();
        $totalPriorities = Priority::count();

        $this->slaCompliance = $slaCompliance;
        $this->totalSLAs = $totalSLAs;
        $this->totalPriorities = $totalPriorities;


        // Get all purposes and statuses
            $purposes = Purpose::all();
            $statuses = TicketStatus::all();

            $purposeNames = $purposes->pluck('name')->toArray();
            $statusNames = $statuses->pluck('name')->toArray();

            // Step 1: Build counts matrix [status_id][purpose_id]
            $countsMatrix = [];
            foreach ($statuses as $status) {
                foreach ($purposes as $purpose) {
                    $count = Tickets::where('ticket_status_id', $status->id)
                        ->whereJsonContains('purpose_type_id', $purpose->id) // if purpose_type_id is array/json
                        ->count();
                    $countsMatrix[$status->id][$purpose->id] = $count;
                }
            }

          // Filter purposes with data
                $nonZeroPurposeIds = [];
                foreach ($purposes as $purpose) {
                    foreach ($statuses as $status) {
                        if (($countsMatrix[$status->id][$purpose->id] ?? 0) > 0) {
                            $nonZeroPurposeIds[] = $purpose->id;
                            break;
                        }
                    }
                }
                $filteredPurposes = $purposes->whereIn('id', $nonZeroPurposeIds)->values();

                // Filter statuses with data
                $nonZeroStatusIds = [];
                foreach ($statuses as $status) {
                    foreach ($filteredPurposes as $purpose) {
                        if (($countsMatrix[$status->id][$purpose->id] ?? 0) > 0) {
                            $nonZeroStatusIds[] = $status->id;
                            break;
                        }
                    }
                }
                $filteredStatuses = $statuses->whereIn('id', $nonZeroStatusIds)->values();

                // Abbreviate filtered purpose names
                $filteredPurposeNames = $filteredPurposes->pluck('name')->map($abbreviate)->toArray();

                // Abbreviate filtered status names, with special handling (like 'On Hold' => 'OH')
                $abbreviateStatus = function($name) {
                    if (strtolower($name) === 'on hold') return 'OH';
                    if (str_contains($name, ' ')) {
                        return collect(explode(' ', $name))->map(fn($w) => strtoupper($w[0]))->implode('');
                    }
                    return strtoupper(substr($name, 0, 1));
                };
                $statusAbbreviations = $filteredStatuses->pluck('name')->map($abbreviateStatus)->toArray();

                // Build chart data only for filtered statuses and purposes
                $chartData = [];
                foreach ($filteredStatuses as $status) {
                    $data = [];
                    foreach ($filteredPurposes as $purpose) {
                        $data[] = $countsMatrix[$status->id][$purpose->id] ?? 0;
                    }
                    $chartData[] = [
                        'name' => $abbreviateStatus($status->name),
                        'data' => $data,
                    ];
                }

                $this->purposeNames = $filteredPurposeNames;
                $this->statuses = $statusAbbreviations;
                $this->ticketsByPurposeStatus = $chartData;



            // Get all agents (users who have tickets assigned)
           // 1. Get all unique agent IDs who have tickets assigned
            $agentIds = Tickets::whereNotNull('assigned_to_id')->pluck('assigned_to_id')->unique();
            // 2. Fetch User models for those agent IDs
            $agents = User::whereIn('id', $agentIds)->get();
            // 3. Fetch all ticket statuses
            $statuses = TicketStatus::all();

            $agentNames = $agents->pluck('name')->toArray();
            $statusNames = $statuses->pluck('name')->toArray();

            // 4. Fetch all tickets for these agents (single query)
            $tickets = Tickets::whereIn('assigned_to_id', $agentIds)->get();

            $data = [];
            foreach ($statuses as $status) {
                $counts = [];
                foreach ($agents as $agent) {
                    $count = $tickets
                        ->where('assigned_to_id', $agent->id)
                        ->where('ticket_status_id', $status->id)
                        ->count();
                    $counts[] = $count;
                }
                $data[] = [
                    'name' => $status->name,
                    'type' => 'bar',
                    'stack' => 'total',
                    'data' => $counts,
                ];
            }

            $this->agentNames = $agentNames;
            $this->statusNames = $statusNames;
            $this->ticketsByAgentStatus = $data;

            
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
             'statuses' => $this->statuses,
             'ticketsData' => $this->ticketsData,
             'departments' => $this->departments,
             'slaCompliance' => $this->slaCompliance,
             'totalSLAs' => $this->totalSLAs,
             'totalPriorities' => $this->totalPriorities,
             'purposeNames' => $this->purposeNames,
             'ticketsByPurposeStatus' => $this->ticketsByPurposeStatus,
             'agentNames' => $this->agentNames,
             'statusNames' => $this->statusNames,
             'ticketsByAgentStatus' => $this->ticketsByAgentStatus,

         ];
     }
}
