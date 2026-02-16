<?php

return [
    'singular' => 'Distribution Record',
    'plural' => 'Distribution Records',
    'status' => [
        'pending' => 'Pending',
        'verified' => 'Verified',
        'rejected' => 'Rejected',
    ],
    'fields' => [
        'id' => 'ID',
        'transaction_id' => 'Transaction ID',
        'transaction' => 'Transaction',
        'distribution_area' => 'Distribution Area',
        'beneficiaries_served' => 'Beneficiaries Served',
        'beneficiaries_helper' => 'Estimated or actual count of people served.',
        'photos' => 'Photo Evidence (Max 5)',
        'photo_gallery' => 'Photo Gallery',
        'notes' => 'Notes / Observations',
        'verified_by' => 'Verified By',
        'verified_at' => 'Verified At',
        'rejection_reason' => 'Rejection Reason',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
    ],
    'sections' => [
        'distribution_details' => 'Distribution Details',
        'evidence' => 'Evidence',
        'verification' => 'Verification',
        'record_information' => 'Record Information',
        'verification_details' => 'Verification Details',
    ],
    'actions' => [
        'verify' => 'Verify',
        'reject' => 'Reject',
    ],
    'placeholders' => [
        'no_photos' => 'No photos uploaded',
    ],
];
