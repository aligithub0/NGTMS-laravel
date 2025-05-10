<?php

namespace App\Filament\Resources;

// app/Filament/Resources/NavigationOrder.php
class NavigationOrder
{
    /**
     * Map filenames to their sort orders.
     */
    public const FILE_SORT_MAP = [
        'CompanyTypesResource.php'      => 1,
        'CompanyResource.php'           => 2,
        'MeneusResource.php'            => 3,
        'RoleResource.php'              => 4,
        'RolesMenuResource.php'         => 5,
        'DepartmentResource.php'        => 6,
        'DesignationsResource.php'      => 7,
        'UserStatusResource.php'        => 8,
        'UserResource.php'              => 9,
        'ProjectTypesResource.php'      => 10,
        'ProjectResource.php'           => 11,
        'PurposeResource.php'           => 12,
        'AgentPurposesResource.php'     => 13,
        'TaskStatusResource.php'        => 14,
        'ShiftTypesResource.php'        => 15,
        'TimesheetResource.php'         => 16,
        'TimesheetStatusResource.php'   => 17,
        'TimesheetActivitiesResource.php'=>18,
        'SlaConfigurationResource.php'  => 19,
        'TicketSourceResource.php'      => 20,
        'TicketStatusResource.php'      => 21,
        'TicketsResource.php'           => 22,
        'NotificationTypeResource.php'  => 23,
    ];

    public const FILE_GROUP_MAP = [
        'UserResource.php'              => 'User Management',
        'MeneusResource.php'            => 'User Management',
        'RoleResource.php'              => 'User Management',
        'RolesMenuResource.php'         => 'User Management',
        'UserStatusResource.php'        => 'User Management',
        'DepartmentResource.php'        => 'User Management',
        'DesignationsResource.php'      => 'User Management',

        'ProjectResource.php'           => 'Projects',
        'ProjectTypesResource.php'      => 'Projects',

        'TimesheetResource.php'         => 'Timesheets',
        'TimesheetActivitiesResource.php'=> 'Timesheets',
        'TimesheetStatusResource.php'   => 'Timesheets',
        'ShiftTypesResource.php'        => 'Timesheets',

        'TicketsResource.php'           => 'Tickets',
        'TicketStatusResource.php'      => 'Tickets',
        'TicketSourceResource.php'      => 'Tickets',
        'SlaConfigurationResource.php'  => 'Tickets',
        'NotificationTypeResource.php'  => 'Tickets',

        'CompanyTypesResource.php'      => 'Company',
        'CompanyResource.php'           => 'Company',
            'PurposeResource.php'           => 'Company',
        'AgentPurposesResource.php'     => 'Company',
        'TaskStatusResource.php'        => 'Company',
    ];

    /**
     * Get the sort order for a given filename.
     */
    public static function getSortOrderByFilename(string $filename): ?int
    {
        return self::FILE_SORT_MAP[$filename] ?? null;
    }

    public static function getNavigationGroupByFilename(string $filename): ?string
    {
        return self::FILE_GROUP_MAP[$filename] ?? null;
    }
}