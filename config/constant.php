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
    'verify_option' =>[
        '1' => 'Approve',
        '2' => 'Reject',
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
    'preferred_age' => [
        '1' =>'18-20',
        '2' =>'21-25',
        '3' =>'26-30',
        '4' =>'31-35',
        '5' =>'36-40',
        '6' =>'41-50',
        '7' =>'51-60',
        '8' =>'61-80',
    ],
    'ethnicity' => [
        '1' =>'Black/African Descent',
        '2' =>'Asian',
        '3' =>'Latin',
        '4' =>'Spanish',
        '5' =>'Middle Eastern',
        '6' =>'Indian',
        '7' =>'Mixed Race',
        '8' =>'White/Caucasian',
        '9' =>'Mediterranean',
        '10' =>'Other',
    ],
    'height'=>[
        '4.2'  => '127-129 cm 4.2 ft',
        '4.3'  => '130-132 cm 4.3 ft',
        '4.4'  => '133-135 cm 4.4 ft',
        '4.5'  => '136-138 cm 4.5 ft',
        '4.6'  => '139-141 cm 4.6 ft',
        '4.7'  => '142-144 cm 4.7 ft',
        '4.8'  => '145-147 cm 4.8 ft',
        '4.9'  => '148-150 cm 4.9 ft',
        '5.0'  => '151-153 cm 5.0 ft',
        '5.1'  => '154-156 cm 5.1 ft',
        '5.2'  => '157-159 cm 5.2 ft',
        '5.3'  => '160-162 cm 5.3 ft',
        '5.4'  => '163-165 cm 5.4 ft',
        '5.5'  => '166-168 cm 5.5 ft',
        '5.6'  => '169-171 cm 5.6 ft',
        '5.7'  => '172-173 cm 5.7 ft',
        '5.8'  => '174-176 cm 5.8 ft',
        '5.9'  => '177-179 cm 5.9 ft',
        '6.0'  => '180-182 cm 6.0 ft',
        '6.1'  => '183-185 cm 6.1 ft',
        '6.2'  => '187-189 cm 6.2 ft',
        '6.3'  => '190-192 cm 6.3 ft',
        '6.4'  => '193-195 cm 6.4 ft',
        '6.5'  => '196-198 cm 6.5 ft',
        '6.6'  => '199-201 cm 6.6 ft',
        '6.7'  => '202-204 cm 6.7 ft',
        '6.8'  => '205-207 cm 6.8 ft',
        '6.9'  => '208-210 cm 6.9 ft',
        '7.0'  => '211-213 cm 7.0 ft',
        '7.1'  => '212-214 cm 7.1 ft',
        '7.2'  => '215-217 cm 7.2 ft',
        '7.3'  => '218 + cm 7.3 + ft',
    ],
    'weight' =>[
        '1'  => 'Up to 40 kg',
        '2'  => '41 - 50 kg',
        '3'  => '51-60 kg',
        '4'  => '61-70 kg',
        '5'  => '71-80 kg',
        '6'  => '81-90 kg',
        '7'  => '91-100 kg',
        '8'  => '101-110 kg',
        '9'  => '111 -120 kg',
        '10'  => '121-130 kg',
        '11'  => '131-140 kg',
        '12'  => '141 -150 kg',
        '13'  => '150 + kg',
    ],
    'userInfo_field_list'=>[
        '1'=>'Phone Number',
        '2'=>'Relationship',
        '3'=>'Height',
        '4'=>'Weight',
        '5'=>'Living Arrangement',
        '6'=>'City',
        '7'=>'State/Province',
        '8'=>'Country',
        '9'=>'Favorite Sport',
        '10'=>'High School Attended',
        '11'=>'College/University Attended',
        '12'=>'Employment Status',
        '13'=>'Education',
        '14'=>'Do you have Children?',
        '15'=>'Describe the Perfect Date',
        '16'=>'Ethnicity',
        '17'=>'Build',
    ],
    'email_verification'=>25,
    'id_verification'=>25,
    'phone_verification'=>25,
    'profile_verification'=>25,
];
