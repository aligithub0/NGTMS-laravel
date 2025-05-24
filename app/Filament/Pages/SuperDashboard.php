<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\User;
use App\Models\Company;
use App\Models\Department;
use App\Models\Designations;
use App\Models\Project;
use App\Models\Tickets;

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

     // Add this to inject data into the blade view
     public function mount()
     {
         $this->totalTickets   = Tickets::count();
         $this->totalUsers     = User::count();
         $this->totalCompanies = Company::count();
         $this->totalDepartments = Department::count();
         $this->totalDesignations = Designations::count();
         $this->totalProjects = Project::count();
     }
 
     protected function getViewData(): array
     {
         return [
             'totalTickets'     => $this->totalTickets,
             'totalUsers'       => $this->totalUsers,
             'totalCompanies'   => $this->totalCompanies,
             'totalDepartments' => $this->totalDepartments,
             'totalDesignations'=> $this->totalDesignations,
             'totalProjects'    => $this->totalProjects,
         ];
     }
}
