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
    'ad_category' => [
      '1' => 'Retail',  
      '2' => 'Automotive',  
      '3' => 'Telecom',  
      '4' => 'Financial services',  
      '5' => 'Insurance',  
      '6' => 'Travel & tourism',  
      '7' => 'Restaurants',  
      '8' => 'Pharmaceuticals',  
      '9' => 'Media',  
      '10' => 'E-commerce',  
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
    'subscription_period_1' =>[
        '1' => 'Month',
        '2' => 'Quarter',
        '3' => 'Year',
    ],
    'subscription_period_2' =>[
        '1' => 'Mois',
        '2' => 'Trimestre',
        '3' => 'An',
    ],
    'subscription_currency' =>[
        '1' => 'USD',
        '2' => 'EUR',
        '3' => 'CAD',
        '4' => 'CFA',
    ],
     
];
