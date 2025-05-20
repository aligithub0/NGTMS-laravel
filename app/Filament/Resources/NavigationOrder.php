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
        'ContactSegmentationResource.php' => 11,

        'MeneusResource.php'            => 12,
        'RoleResource.php'              => 13,
        'RolesMenuResource.php'         => 14,
        'RoleMenuPermissionResource.php'=> 15,
        'DepartmentResource.php'        => 16,
        'DesignationsResource.php'      => 17,
        'UserTypeResource.php'          => 18,
        'UserStatusResource.php'        => 19,
        'UserResource.php'              => 20,


        'ProjectTypesResource.php'      => 21,
        'ProjectResource.php'           => 22,


        'TicketSourceResource.php'      => 23,
        'TicketStatusResource.php'      => 24,
        'SlaConfigurationResource.php'  => 25,
        'NotificationTypeResource.php'  => 26,
        'TicketAttachmentResource.php'  => 27,
        'PriorityResource.php'          => 28,
        'TicketsResource.php'           => 29,
        'TicketRepliesResource.php'     => 30,
        'TicketJourneyResource.php'     => 31,
        'CommentsResource.php'          => 32,
        'ResponseTemplatesResource.php' => 33,
        'FieldVariablesResource.php'    => 34,
        'ActivityLogsResource.php'      => 35,


        'ShiftTypesResource.php'         => 36,
        'TimesheetStatusResource.php'    => 37,
        'TimesheetActivitiesResource.php'=> 38,
        'TimesheetResource.php'          => 39,

    
        'TasksResource.php'             => 40,
        'TaskStatusResource.php'        => 41,
        'TaskAttachmentsResource.php'   => 42,

     


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
        'ContactSegmentationResource.php' => 'Contact Management',

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
        'FieldVariablesResource.php'    => 'Tickets',
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