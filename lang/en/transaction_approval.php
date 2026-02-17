<?php

return [
    'singular' => 'Transaction Approval',
    'plural' => 'Transaction Approvals',
    'status' => [
        'pending' => 'Pending',
        'approved' => 'Approved',
        'rejected' => 'Rejected',
    ],
    'roles' => [
        'receiver' => 'Receiver',
        'warehouse_manager' => 'Warehouse Manager',
        'compliance_officer' => 'Compliance Officer',
        'admin' => 'Admin',
    ],
    'fields' => [
        'transaction_id' => 'Transaction ID',
        'transaction' => 'Transaction',
        'approver_role' => 'Required Role',
        'approver_id' => 'Approver',
        'step' => 'Approval Step',
        'status' => 'Status',
        'comments' => 'Comments',
        'approved_at' => 'Decision Date',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
    ],
    'sections' => [
        'approval_details' => 'Approval Details',
        'comments' => 'Comments & Feedback',
    ],
    'actions' => [
        'approve' => 'Approve',
        'reject' => 'Reject',
    ],
    'messages' => [
        'approved_success' => 'Transaction approved successfully.',
        'rejected_success' => 'Transaction rejected successfully.',
    ],
    'placeholders' => [
        'comments' => 'Provide a reason for rejection or additional notes...',
    ],
];
