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
        'PurposeResource.php'           => 3,
        'AgentPurposesResource.php'     => 4,

        'ContactTypeResource.php'         => 5,
        'ContactCompanyResource.php'      => 6,
        'ContactsResource.php'            => 7,
        'ContactsPhoneNumbersResource.php'=> 8,
        'ContactsPreferencesResource.php' => 9,
        'ContactsSocialLinksResource.php' => 10,

        'MeneusResource.php'            => 11,
        'RoleResource.php'              => 12,
        'RolesMenuResource.php'         => 13,
        'RoleMenuPermissionResource.php'=> 14,
        'DepartmentResource.php'        => 15,
        'DesignationsResource.php'      => 16,
        'UserTypeResource.php'          => 17,
        'UserStatusResource.php'        => 18,
        'UserResource.php'              => 19,


        'ProjectTypesResource.php'      => 20,
        'ProjectResource.php'           => 21,


        'TicketSourceResource.php'      => 22,
        'TicketStatusResource.php'      => 23,
        'SlaConfigurationResource.php'  => 24,
        'NotificationTypeResource.php'  => 25,
        'TicketAttachmentResource.php'  => 26,
        'PriorityResource.php'          => 27,
        'TicketsResource.php'           => 28,
        'TicketRepliesResource.php'     => 29,
        'TicketJourneyResource.php'     => 30,
        'CommentsResource.php'          => 31,
        'ResponseTemplatesResource.php' => 32,
        'ActivityLogsResource.php'      => 33,

        'ShiftTypesResource.php'         => 34,
        'TimesheetStatusResource.php'    => 35,
        'TimesheetActivitiesResource.php'=> 36,
        'TimesheetResource.php'          => 37,

    
        'TasksResource.php'             => 38,
        'TaskStatusResource.php'        => 39,
        'TaskAttachmentsResource.php'   => 40,

     


    ];

    public const FILE_GROUP_MAP = [

        
        'CompanyTypesResource.php'      => 'Company Management',
        'CompanyResource.php'           => 'Company Management',
        'PurposeResource.php'           => 'Company Management',
        'AgentPurposesResource.php'     => 'Company Management',

        'ContactTypeResource.php'         => 'Contact Management',
        'ContactCompanyResource.php'      => 'Contact Management',
        'ContactsResource.php'            => 'Contact Management',
        'ContactsPhoneNumbersResource.php'=> 'Contact Management',
        'ContactsPreferencesResource.php' => 'Contact Management',
        'ContactsSocialLinksResource.php' => 'Contact Management',

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
        'TicketRepliesResource.php'     => 'Tickets',
        'PriorityResource.php'          => 'Tickets',
        'TicketAttachmentResource.php'  => 'Tickets',
        'TicketStatusResource.php'      => 'Tickets',
        'TicketSourceResource.php'      => 'Tickets',
        'SlaConfigurationResource.php'  => 'Tickets',
        'NotificationTypeResource.php'  => 'Tickets',
        'CommentsResource.php'          => 'Tickets',
        'TicketJourneyResource.php'     => 'Tickets',
        'ResponseTemplatesResource.php' => 'Tickets',
        'ActivityLogsResource.php'      => 'Tickets',


        'TasksResource.php'             => 'Tasks',
        'TaskStatusResource.php'        => 'Tasks',
        'TaskAttachmentsResource.php'   => 'Tasks',


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