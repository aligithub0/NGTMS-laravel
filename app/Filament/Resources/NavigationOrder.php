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
        'RoleMenuPermissionResource.php'=> 6,
        'DepartmentResource.php'        => 7,
        'DesignationsResource.php'      => 8,
        'UserTypeResource.php'          => 9,
        'UserStatusResource.php'        => 10,
        'UserResource.php'              => 11,
        'ProjectTypesResource.php'      => 12,
        'ProjectResource.php'           => 13,
        'PurposeResource.php'           => 14,
        'AgentPurposesResource.php'     => 15,
        'TaskStatusResource.php'        => 16,
        'ShiftTypesResource.php'        => 17,
        'TimesheetStatusResource.php'   => 18,
        'TimesheetActivitiesResource.php'=>19,
        'TimesheetResource.php'         => 20,
        'TicketSourceResource.php'      => 21,
        'TicketStatusResource.php'      => 22,
        'SlaConfigurationResource.php'  => 23,
        'NotificationTypeResource.php'  => 24,
        'TicketAttachmentResource.php'  => 25,
        'TicketsResource.php'           => 26,
        'TasksResource.php'             => 27,

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
        'RoleMenuPermissionResource.php'=> 'User Management',
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