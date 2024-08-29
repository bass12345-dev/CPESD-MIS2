<?php

return [

    'database' =>[
        'users'         => 'mysql_USERS',
        'lls_whip'      => 'mysql_LLS',
        'dts'           => 'mysql_DTS',
        'pmas'          => 'mysql_PMAS',
    ],
    
    'barangay' => [
        "Apil",
        "Binuangan",
        "Bolibol",
        "Buenavista",
        "Bunga",
        "Buntawan",
        "Burgos",
        "Canubay",
        "Clarin Settlement",
        "Dolipos Bajo",
        "Dolipos Alto",
        "Dulapo",
        "Dullan Norte",
        "Dullan Sur",
        "Lamac Lower",
        "Lamac Upper",
        "Langcangan Lower",
        "Langcangan Proper",
        "Langcangan Upper",
        "Layawan",
        "Loboc Lower",
        "Loboc Upper",
        "Rizal Lower",
        "Rizal Upper",
        "Malindang",
        "Mialen",
        "Mobod",
        "Ciriaco Pastrano",
        "Paypayan",
        "Pines",
        "Poblacion 1",
        "Poblacion 2",
        "San Vicente Alto",
        "San Vicente Bajo",
        "Sebucal",
        "Senote",
        "Taboc Norte",
        "Taboc Sur",
        "Talairon",
        "Talic",
        "Toliyok",
        "Tipan",
        "Transville",
        "Tuyabang Alto",
        "Tuyabang Bajo",
        "Tuyabang Proper",
        "Victoria",
        "Villaflor" 
    ],

    'lls_nature_of_employment' => [
        'permanent'=>'Permanent',
        'probationary'  => 'Probationary',
        'contractuals'  => 'Contractuals',
        'project_based' => 'Project Based',
        'seasonal'  => 'Seasonal',
        'job_order' => 'Job order',
        'mgt'   => 'Mgt'  
    ],


  

    'whip_nature_of_employment' => [
        'skilled',
        'unskilled',
    ],

    'level_of_employment' => [
        'rank_and_file',
        'managerial',
        'proprietor',
    ],
    'default_province' => 'Misamis Occidental',
    'default_city' => 'City of Oroquieta',

    '_systems' => [
        'pmas'          =>  'PMAS',
        'cso'          =>   'CSO\'s',
        'rfa'           =>  'RFA',
        'watchlisted'   =>  'Watchlisted',
        'dts'           =>  'Document Tracking System',
        'lls'           =>  'Labor Localization',
        'whip'          =>  'WHIP',
        
    ],
    'employment_status' => ['employed','self-employed','unemployed and actively looking for work', 'underemployed'],
    'type_of_transactions' => ['simple','complex'],
    

    'cso_type'  =>  ['PO', 'Coop','NSC'],
    'positions' => ['President/BOD Chairperson/BOT',
        'Vice President/BOD Vice Chairperson',
        'Secretary',
        'Treasurer',
        'Auditor',
        'Manager'],

    'folder_name' => [
        'cor_folder_name' => 'cor',
        'bylaws_folder_name' => 'bylaws', 
        'aoc_folder_name' => 'aoc' , 
        'other_docs_folder_name' => 'other_docs']
];

