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
   

        'ContactTypeResource.php'         => 3,
        'ContactCompanyResource.php'      => 4,
        'ContactsResource.php'            => 5,
        'ContactsPhoneNumbersResource.php'=> 6,
        'ContactsPreferencesResource.php' => 7,
        'ContactsSocialLinksResource.php' => 8,
        'ContactSegmentationResource.php' => 9,

        'MeneusResource.php'            => 10,
        'RoleResource.php'              => 11,
        'RolesMenuResource.php'         => 12,
        'RoleMenuPermissionResource.php'=> 13,
        'DepartmentResource.php'        => 14,
        'DesignationsResource.php'      => 15,
        'UserTypeResource.php'          => 16,
        'UserStatusResource.php'        => 17,
        'UserResource.php'              => 18,


        'ProjectTypesResource.php'      => 19,
        'ProjectResource.php'           => 20,


        'TicketSourceResource.php'      => 21,
        'TicketStatusResource.php'      => 22,
        'SlaConfigurationResource.php'  => 23,
        'PurposeResource.php'           => 24,
        'AgentPurposesResource.php'     => 25,
        'NotificationTypeResource.php'  => 26,
        'TicketAttachmentResource.php'  => 27,
        'PriorityResource.php'          => 28,
        'TicketsResource.php'           => 29,
        'TicketRepliesResource.php'     => 30,
        'TicketJourneyResource.php'     => 31,
        'StatusWorkflowResource.php'    => 32,
        'CommentsResource.php'          => 33,
        'ResponseTemplatesResource.php' => 34,
        'FieldVariablesResource.php'    => 35,
        'ActivityLogsResource.php'      => 36,


        'ShiftTypesResource.php'         => 37,
        'TimesheetStatusResource.php'    => 38,
        'TimesheetActivitiesResource.php'=> 39,
        'TimesheetResource.php'          => 40,

    
        'TasksResource.php'             => 41,
        'TaskStatusResource.php'        => 42,
        'TaskAttachmentsResource.php'   => 43,

     


    ];

    public const FILE_GROUP_MAP = [

        
        'CompanyTypesResource.php'      => 'Company Management',
        'CompanyResource.php'           => 'Company Management',
     

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
        'PurposeResource.php'           => 'Tickets',
        'AgentPurposesResource.php'     => 'Tickets',
        'NotificationTypeResource.php'  => 'Tickets',
        'CommentsResource.php'          => 'Tickets',
        'TicketJourneyResource.php'     => 'Tickets',
        'ResponseTemplatesResource.php' => 'Tickets',
        'FieldVariablesResource.php'    => 'Tickets',
        'ActivityLogsResource.php'      => 'Tickets',
        'StatusWorkflowResource.php'    => 'Tickets',


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