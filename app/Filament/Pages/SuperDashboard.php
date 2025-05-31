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
use App\Models\TicketSource;


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

      // Fetch all departments and statuses with labels and names
$departments = \App\Models\Department::all();
$statuses = \App\Models\TicketStatus::all();

// Build counts matrix as before
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

// Filter departments with data (based on filtered statuses)
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

// Prepare arrays for labels and names separately for x-axis, y-axis, and tooltips
$statusesLabels1 = $filteredStatuses->pluck('label')->toArray();
$statusNames = $filteredStatuses->pluck('name')->toArray();

$departmentLabels = $filteredDepartments->pluck('label')->toArray();
$departmentNames = $filteredDepartments->pluck('name')->toArray();

// Build data series with full names for tooltips
$data = [];
foreach ($filteredDepartments as $department) {
    $series = [];
    foreach ($filteredStatuses as $status) {
        $series[] = [
            'x' => $status->label,     // x-axis uses label
            'y' => $countsMatrix[$status->id][$department->id] ?? 0,
            'name' => $status->name,   // store full name for tooltip
            'department' => $department->name // you can add if needed
        ];
    }
    $data[] = [
        'name' => $department->label,  // legend shows label
        'data' => array_map(fn($point) => $point['y'], $series),
        'customData' => $series,       // Pass custom data for tooltips
    ];
}

// Pass all data to JS
$this->statusesLabels1 = $statusesLabels1;
$this->statusesNames = $statusNames;
$this->departmentsLabels = $departmentLabels;
$this->departmentsNames = $departmentNames;
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

            // Graph 2: Ticket Status By Purposes
       // Get only parent purposes (parent_id == NULL)
$parentPurposes = Purpose::whereNull('parent_id')->get();
$statuses = TicketStatus::all();

$parentPurposeLabels = $parentPurposes->pluck('label')->toArray();
$statusesLabels = $statuses->pluck('label')->toArray();

// Step 1: Build counts matrix [status_id][parent_purpose_id]
$countsMatrix = [];
foreach ($statuses as $status) {
    foreach ($parentPurposes as $parentPurpose) {
        // Count tickets associated with this parent purpose id
        $count = Tickets::where('ticket_status_id', $status->id)
            ->whereJsonContains('purpose_type_id', $parentPurpose->id)  // assuming purpose_type_id stores purpose IDs as json
            ->count();
        $countsMatrix[$status->id][$parentPurpose->id] = $count;
    }
}

// Step 2: Find parent purpose IDs with non-zero ticket count
$nonZeroParentPurposeIds = [];
foreach ($parentPurposes as $parentPurpose) {
    $hasData = false;
    foreach ($statuses as $status) {
        if (($countsMatrix[$status->id][$parentPurpose->id] ?? 0) > 0) {
            $hasData = true;
            break;
        }
    }
    if ($hasData) {
        $nonZeroParentPurposeIds[] = $parentPurpose->id;
    }
}

// Step 3: Filter parent purposes to only those with tickets
$filteredParentPurposes = $parentPurposes->whereIn('id', $nonZeroParentPurposeIds)->values();
$filteredParentPurposeLabels = $filteredParentPurposes->pluck('label')->toArray();

// Step 4: Filter statuses to only those that have tickets for filtered parent purposes
$filteredStatuses = $statuses->filter(function ($status) use ($filteredParentPurposes, $countsMatrix) {
    foreach ($filteredParentPurposes as $parentPurpose) {
        if (($countsMatrix[$status->id][$parentPurpose->id] ?? 0) > 0) {
            return true;
        }
    }
    return false;
})->values();

// Step 5: Prepare chart data series
$chartData = [];
foreach ($filteredStatuses as $status) {
    $data = [];
    foreach ($filteredParentPurposes as $parentPurpose) {
        $data[] = $countsMatrix[$status->id][$parentPurpose->id] ?? 0;
    }
    $chartData[] = [
        'name' => $status->label, // Use label for better display
        'data' => $data,
    ];
}

$this->parentPurposeNames = $filteredParentPurposes->pluck('name')->toArray();   // full name for tooltips
$this->parentPurposeLabels = $filteredParentPurposes->pluck('label')->toArray(); // short label for x-axis
$this->statusesLabels = $filteredStatuses->pluck('label')->toArray();
$this->statusesNames = $filteredStatuses->pluck('name')->toArray();
$this->ticketsByPurposeStatus = $chartData;



                    // Chart 4: Ticket Status by Purpose Group

                // Get purposes with parent_id not null (child purposes only)
                $childPurposes = Purpose::whereNotNull('parent_id')->get();
                $allStatuses = TicketStatus::all();
                
                // Build counts matrix [status_id][purpose_id]
                $countsMatrix = [];
                foreach ($allStatuses as $status) {
                    foreach ($childPurposes as $purpose) {
                        $count = Tickets::where('ticket_status_id', $status->id)
                            ->whereJsonContains('purpose_type_id', $purpose->id)
                            ->count();
                        $countsMatrix[$status->id][$purpose->id] = $count;
                    }
                }
                
                // Filter purposes with any ticket data
                $nonZeroPurposeIds = [];
                foreach ($childPurposes as $purpose) {
                    foreach ($allStatuses as $status) {
                        if (($countsMatrix[$status->id][$purpose->id] ?? 0) > 0) {
                            $nonZeroPurposeIds[] = $purpose->id;
                            break;
                        }
                    }
                }
                $filteredChildPurposes = $childPurposes->whereIn('id', $nonZeroPurposeIds)->values();
                
                // Filter statuses with ticket data in filtered purposes
                $filteredStatuses = $allStatuses->filter(function ($status) use ($filteredChildPurposes, $countsMatrix) {
                    foreach ($filteredChildPurposes as $purpose) {
                        if (($countsMatrix[$status->id][$purpose->id] ?? 0) > 0) {
                            return true;
                        }
                    }
                    return false;
                })->values();
                
                // Prepare labels and names
                $childPurposeLabels = $filteredChildPurposes->pluck('label')->toArray();
                $childPurposeNames = $filteredChildPurposes->pluck('name')->toArray();
                $statusLabels3 = $filteredStatuses->pluck('label')->toArray();
                $statusNames3 = $filteredStatuses->pluck('name')->toArray();
                
                // Prepare series data for ApexCharts
                $ticketsByChildPurposeStatus = [];
                foreach ($filteredStatuses as $status) {
                    $data = [];
                    foreach ($filteredChildPurposes as $purpose) {
                        $data[] = $countsMatrix[$status->id][$purpose->id] ?? 0;
                    }
                    $ticketsByChildPurposeStatus[] = [
                        'name' => $status->label,
                        'data' => $data,
                    ];
                }
                
                // Pass these variables to frontend view
                $this->childPurposeLabels = $childPurposeLabels;
                $this->childPurposeNames = $childPurposeNames;
                $this->statusLabels3 = $statusLabels3;
                $this->statusNames3 = $statusNames3;
                $this->ticketsByChildPurposeStatus = $ticketsByChildPurposeStatus;
 

 


        // Chart 5: Tickets status by Manager
       // 1. Get all users with role 'Manager' and assigned_to_others = 1
            $managers = User::whereHas('role', function ($q) {
                $q->where('name', 'Manager');
            })
            ->where('assigned_to_others', true)
            ->get();

            // 2. Get all statuses
            $statuses = TicketStatus::all();

            // 3. Collect manager names
            $managerNames = $managers->pluck('name')->toArray();

            // 4. Fetch tickets assigned to managers
            $managerIds = $managers->pluck('id')->toArray();
            $tickets = Tickets::whereIn('assigned_to_id', $managerIds)->get();

            // 5. Prepare data for each status across managers
            $ticketsByManagerStatus = [];
            foreach ($statuses as $status) {
            $data = [];
            foreach ($managers as $manager) {
                $count = $tickets
                    ->where('assigned_to_id', $manager->id)
                    ->where('ticket_status_id', $status->id)
                    ->count();
                $data[] = $count;
            }
            $ticketsByManagerStatus[] = [
                'name' => $status->label,  // Use label for legend
                'data' => $data,
            ];
            }

            // Pass to frontend (e.g. Livewire or Controller view)
            $this->managerNames = $managerNames;
            $this->statusLabels5 = $statuses->pluck('label')->toArray();
            $this->statusNames5 = $statuses->pluck('name')->toArray();
            $this->ticketsByManagerStatus = $ticketsByManagerStatus;



             // Chart 6: Ticket Status by SLA
                // 1. Get all SLAs with tickets (filter out SLAs with no tickets)
                $slasWithTickets = SlaConfiguration::whereIn('id', function ($query) {
                    $query->select('SLA')->from('tickets')->whereNotNull('SLA');
                })->get();

                // 2. Get all ticket statuses with tickets having an SLA in above list
                $statusIdsWithTickets = Tickets::whereIn('SLA', $slasWithTickets->pluck('id')->toArray())
                    ->pluck('ticket_status_id')
                    ->unique()
                    ->toArray();

                $filteredStatuses = TicketStatus::whereIn('id', $statusIdsWithTickets)->get();

                // 3. Prepare counts matrix [status_id][sla_id]
                $countsMatrix = [];
                foreach ($filteredStatuses as $status) {
                    foreach ($slasWithTickets as $sla) {
                        $count = Tickets::where('ticket_status_id', $status->id)
                            ->where('SLA', $sla->id)
                            ->count();
                        $countsMatrix[$status->id][$sla->id] = $count;
                    }
                }

                // 4. Prepare chart data series for ApexCharts (series = statuses)
                $chartSeries = [];
                foreach ($filteredStatuses as $status) {
                    $data = [];
                    foreach ($slasWithTickets as $sla) {
                        $data[] = $countsMatrix[$status->id][$sla->id] ?? 0;
                    }
                    $chartSeries[] = [
                        'name' => $status->label,   // Legend label on chart
                        'data' => $data,
                    ];
                }

                // 5. Pass filtered SLA names (for x-axis), status labels and names, and chart data to view
                $this->slaNames = $slasWithTickets->pluck('name')->toArray();        // For tooltip title and x-axis
                $this->statusLabels6 = $filteredStatuses->pluck('label')->toArray();  // For y-axis legend labels
                $this->statusNames6 = $filteredStatuses->pluck('name')->toArray();    // For tooltip list labels
                $this->ticketsBySlaStatus = $chartSeries;


            // Graph: 7 Tickets status by Sources
            // 1. Fetch all sources that have tickets
                $sourcesWithTickets = TicketSource::whereIn('id', function ($query) {
                    $query->select('ticket_source_id')->from('tickets')->whereNotNull('ticket_source_id');
                })->get();

                // 2. Calculate ticket counts per source
                $ticketCounts = [];
                $totalTickets = Tickets::count();

                foreach ($sourcesWithTickets as $source) {
                    $count = Tickets::where('ticket_source_id', $source->id)->count();
                    $ticketCounts[] = $count;
                }

                // 3. Calculate percentages for tooltip and label display (optional, you can do in JS as well)
                $percentages = [];
                foreach ($ticketCounts as $count) {
                    $percentages[] = $totalTickets > 0 ? round(($count / $totalTickets) * 100, 1) : 0;
                }

                // 4. Prepare labels array for the chart (source names or labels)
                $sourceLabels = $sourcesWithTickets->pluck('name')->toArray();

                // 5. Prepare colors (choose palette or generate dynamically)
                $colors = [
                    '#f97316',
                    '#dc2626',
                    '#fb923c',
                    '#ef4444',
                    // add more if you have more sources
                ];

                // 6. Pass data to view
                $this->sourceLabels = $sourceLabels;
                $this->ticketCounts = $ticketCounts;
                $this->totalTickets = $totalTickets;
                $this->percentages = $percentages;
                $this->colors = array_slice($colors, 0, count($sourcesWithTickets));

            


                   // Graph: 8 Tickets status by Category
            $newStatus = TicketStatus::where('name', 'New')->first();
            $resolvedStatus = TicketStatus::all()->first(function($status) {
                return trim(strtolower($status->name)) === 'resolved';
            });

            $newTicketsCount = $newStatus ? Tickets::where('ticket_status_id', $newStatus->id)->count() : 0;
            $resolvedTicketsCount = $resolvedStatus ? Tickets::where('ticket_status_id', $resolvedStatus->id)->count() : 0;

            $totalCount = $newTicketsCount + $resolvedTicketsCount;
            $totalDots = min($totalCount, 98);  // limit max to 98 dots to keep UI manageable
            
            $newDotsCount = $totalCount > 0 ? round(($newTicketsCount / $totalCount) * $totalDots) : 0;
            $resolvedDotsCount = $totalCount > 0 ? round(($resolvedTicketsCount / $totalCount) * $totalDots) : 0;
            

            // Ensure total dots sum up exactly to totalDots
            $sumDots = $newDotsCount + $resolvedDotsCount;
            if ($sumDots !== $totalDots) {
                $difference = $totalDots - $sumDots;
                if ($newDotsCount > $resolvedDotsCount) {
                    $newDotsCount += $difference;
                } else {
                    $resolvedDotsCount += $difference;
                }
            }

            $this->newDotsCount = $newDotsCount;
            $this->resolvedDotsCount = $resolvedDotsCount;
            $this->newTicketsCount = $newTicketsCount;
            $this->resolvedTicketsCount = $resolvedTicketsCount;



           // Chart 9: Tickets Status by Priority
                
// 1. Get priorities with tickets
$priorityIds = Tickets::distinct()->pluck('priority_id')->toArray();
$priorities = Priority::whereIn('id', $priorityIds)->get();

// 2. Get ticket statuses linked with these tickets
$statusIds = Tickets::whereIn('priority_id', $priorityIds)->distinct()->pluck('ticket_status_id')->toArray();
$statuses = TicketStatus::whereIn('id', $statusIds)->get();

// 3. Prepare ticket counts by priority & status
$countsMatrix = [];
foreach ($statuses as $status) {
    foreach ($priorities as $priority) {
        $count = Tickets::where('priority_id', $priority->id)
                        ->where('ticket_status_id', $status->id)
                        ->count();
        $countsMatrix[$status->id][$priority->id] = $count;
    }
}

// 4. Prepare ApexCharts series
$chartSeries = [];
$colors = [
    '#dc2626', '#f97316', '#ef4444', '#fb923c', '#b91c1c', '#fbbf24', '#b45309', '#991b1b'
];

foreach ($statuses as $index => $status) {
    $data = [];
    foreach ($priorities as $priority) {
        $data[] = $countsMatrix[$status->id][$priority->id] ?? 0;
    }
    $chartSeries[] = [
        'name' => $status->label,   // status label for legend
        'data' => $data,
        'color' => $colors[$index % count($colors)],  // cycle colors
    ];
}

// Pass data to view
$this->statusNames9 = $statuses->pluck('name')->toArray(); // status names for tooltip
$this->priorityLabels = $priorities->pluck('label')->toArray();  // X-axis labels
$this->ticketStatusSeries = $chartSeries;                      // Chart series data


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
            //  'purposeNames' => $this->purposeNames,
             'ticketsByPurposeStatus' => $this->ticketsByPurposeStatus,

             
             'parentPurposeNames' => $this->parentPurposeNames,
             'parentPurposeLabels' => $this->parentPurposeLabels,
             'statusesNames' => $this->statusesNames,


             'statusesLabels1' => $this->statusesLabels1,

        


            'childPurposeLabels' => $this->childPurposeLabels,
            'childPurposeNames' => $this->childPurposeNames,
            'statusLabels3' => $this->statusLabels3,
            'statusNames3' => $this->statusNames3,
            'ticketsByChildPurposeStatus' => $this->ticketsByChildPurposeStatus,



             'managerNames' => $this->managerNames,
             'statusLabels5' => $this->statusLabels5,
             'statusNames5' => $this->statusNames5,
             'ticketsByManagerStatus' => $this->ticketsByManagerStatus,


             'statusNames6' => $this->statusNames6,
             'statusLabels6' => $this->statusLabels6,
             'slaNames' => $this->slaNames,
             'ticketsBySlaStatus' => $this->ticketsBySlaStatus,

             'sourceLabels' => $this->sourceLabels,
             'ticketCounts' => $this->ticketCounts,
             'totalTickets' => $this->totalTickets,
             'percentages' => $this->percentages,
             'colors' => $this->colors,



             'newDotsCount' => $this->newDotsCount,
             'resolvedDotsCount' => $this->resolvedDotsCount,
             'newTicketsCount' => $this->newTicketsCount,
             'resolvedTicketsCount' => $this->resolvedTicketsCount,


             'statusNames9' => $this->statusNames9,
             'priorityLabels' => $this->priorityLabels,
             'ticketStatusSeries' => $this->ticketStatusSeries,


         ];
     }
}
