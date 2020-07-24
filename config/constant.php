<?php

return [

    'backend' => 'admin',
    'recordPerPage'=>50,
    'user_status' =>[
        '1' => 'Inactive',
        '2' => 'Active',
        '3' => 'Blacklisted',
    ],
    'gender' =>[
        '1' => 'Man',
        '2' => 'Woman',
    ],
    'verify_status' =>[
        '1' => 'Verified',
        '2' => 'Unverified',
    ],
    'language' => [
        '1' => 'English',
        '2' => 'French',
    ],
    'ad_type' => [
      '1' => 'type 1',  
      '2' => 'type 2',  
      '3' => 'type 3',  
      '4' => 'type 4',  
    ],
    'ad_status' =>[
        '1' => 'Active',
        '2' => 'Inactive',
    ],
    'status' =>[
        '1' => 'Enable',
        '2' => 'Disable',
    ],
    'recurring_payment_opt' =>[
        '1' => 'Allow Recurring Payment',
        '2' => 'Offer Recurring Payment by Default',
        '3' => 'Force Recurring Payment by Default',
    ],
    'subscription_feature' =>[
        '1' => 'Number of users they can swipe through (Like or Dislike)',
        '2' => 'Number of photo user can upload',
        '3' => 'Send Mail to other Members',
        '4' => 'Instant Messaging Capability',
        '5' => 'Live Video Cha',
        '6' => 'Coaching',
        '7' => 'Who viewed Me?',
    ],
];
