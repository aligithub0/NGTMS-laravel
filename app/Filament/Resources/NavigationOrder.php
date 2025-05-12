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
        'UserTypeResource.php'          => 8,
        'UserStatusResource.php'        => 9,
        'UserResource.php'              => 10,
        'ProjectTypesResource.php'      => 11,
        'ProjectResource.php'           => 12,
        'PurposeResource.php'           => 13,
        'AgentPurposesResource.php'     => 14,
        'TaskStatusResource.php'        => 15,
        'ShiftTypesResource.php'        => 16,
        'TimesheetStatusResource.php'   => 17,
        'TimesheetActivitiesResource.php'=>18,
        'TimesheetResource.php'         => 19,
        'TicketSourceResource.php'      => 20,
        'TicketStatusResource.php'      => 21,
        'SlaConfigurationResource.php'  => 22,
        'NotificationTypeResource.php'  => 23,
        'TicketAttachmentResource.php'  => 24,
        'TicketsResource.php'           => 25,
        'TasksResource.php'           => 26,

    ];

    public const FILE_GROUP_MAP = [

        
        'CompanyTypesResource.php'      => 'Company Management',
        'CompanyResource.php'           => 'Company Management',
        'PurposeResource.php'           => 'Company Management',
        'AgentPurposesResource.php'     => 'Company Management',
        'TaskStatusResource.php'        => 'Company Management',

        'UserResource.php'              => 'User Management',
        'UserTypeResource.php'          => 'User Management',
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
        'TasksResource.php'           =>   'Tickets',
        'TicketAttachmentResource.php'  => 'Tickets',
        'TicketStatusResource.php'      => 'Tickets',
        'TicketSourceResource.php'      => 'Tickets',
        'SlaConfigurationResource.php'  => 'Tickets',
        'NotificationTypeResource.php'  => 'Tickets',

    ];

    /**
     * Get the sort order for a given filename.
     */
    public static function getSortOrderByFilename(string $filename): ?int
    {
        return self::FILE_SORT_MAP[$filename] ?? null;
        return self::FILE_GROUP_MAP[$filename] ?? null;
    }

    public static function getNavigationGroupByFilename(string $filename): ?string
    {
        return self::FILE_GROUP_MAP[$filename] ?? null;
    }
}