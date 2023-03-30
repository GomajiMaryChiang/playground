<?php

return [
    /*
     * 參數相關錯誤代碼
     */
    /*
    'productIdEmpty' => 1001, // productId 為空值
    'productIdNumeric' => 1002, // productId 必須為數值
    'productIdGt' => 1003, // productId 數值需大於0 (不包含0)
    'branchIdNumeric' => 1004, // branchId 必須為數值
    'branchIdGte' => 1005, // branchId 數值需大於等於0
    'cEmpty' => 1006, // c 為空值
    'modEmpty' => 1007, // mod 為空值
    'modNumeric' => 1008, // mod 必須為數值
    'purchaseIdEmpty' => 1009, // purchaseId 為空值
    'purchaseIdNumeric' => 1010, // purchaseId 必須為數值
    'purchaseIdGt' => 1011, // purchaseId 數值需大於0 (不包含0)
    'ticketNoEmpty' => 1012, // ticketNo 為空值
    'transactionCatEmpty' => 1013, // transactionCat 為空值
    'sidEmpty' => 1014, // sid 為空值
    'previewNumeric' => 1015, // preview 必須為數值
    'groupIdNumeric' => 1016, // groupId 必須為數值
    'storeIdEmpty' => 1017, // storeId 為空值
    'storeIdNumeric' => 1018, // storeId 必須為數值
    'storeIdGt' => 1019, // storeId 數值需大於0 (不包含0)
    'cityIdNumeric' => 1020, // cityId 必須為數值
    'cityIdGt' => 1021, // cityId 數值需大於0 (不包含0)
    'mainRewardEmpty' => 1022, // mainReward 為空值
    'passingPageEmpty' => 1023, // passingPage 為空值
    'passingPageJson' => 1024, // passingPage 格式錯誤
    'pageNumeric' => 1025, // page 必須為數值
    'pageGt' => 1026, // page 數值需大於0 (不包含0)
    'spIdEmpty' => 1027, // spId 為空值
    'spIdNumeric' => 1028, // spId 必須為數值
    'spIdGt' => 1029, // spId 數值需大於0 (不包含0)
    'sortIdNumeric' => 1030, // sortId 必須為數值
    'distGroupIdNumeric' => 1031, // distGroupId 必須為數值
    'regionIdNumeric' => 1032, // regionId 必須為數值
    'spotIdNumeric' => 1033, // spotId 必須為數值
    'categoryIdEmpty' => 1034, // catId 為空值
    'categoryIdNumeric' => 1035, // catId 必須為數值
    'categoryIdGt' => 1036, // catId 數值需大於0 (不包含0)
    'biIdEmpty' => 1037, // biId 為空值
    'biIdNumeric' => 1038, // biId 必須為數值
    'biIdGt' => 1039, // biId 數值需大於0 (不包含0)
    'channelIdEmpty' => 1040, // channelId 為空值
    'channelIdNumeric' => 1041, // channelId 數值需大於0 (不包含0)
    'channelIdGt' => 1042, // channelId 數值需大於0 (不包含0)
    'channelIdGte' => 1043, // chId 數值需大於等於0
    'specialIdEmpty' => 1044, // specialId 為空值
    'specialIdNumeric' => 1045, // specialId 必須為數值
    'specialIdGt' => 1046, // specialId 數值需大於0 (不包含0)
    'topIdEmpty' => 1047, // topId 為空值
    'topIdNumeric' => 1048, // topId 必須為數值
    'topIdGt' => 1049, // topId 數值需大於0 (不包含0)
    'contactIdEmpty' => 1050, // contactId 為空值
    'contactIdNumeric' => 1051, // contactId 必須為數值
    'contactIdGt' => 1052, // contactId 數值需大於0 (不包含0)
    'eventIdEmpty' => 1053, // eventId 為空值
    'eventIdNumeric' => 1054, // eventId 必須為數值
    'eventIdGt' => 1055, // eventId 數值需大於0 (不包含0)
    'brandIdEmpty' => 1056, // brandId 為空值
    'brandIdNumeric' => 1057, // brandId 必須為數值
    'brandIdGt' => 1058, // brandId 數值需大於0 (不包含0)
    'groupIdEmpty' => 1059, // gid 為空值
    'groupIdNumeric' => 1060, // gid 必須為數值
    'groupIdGt' => 1061, // gid 數值需大於0 (不包含0)
    'statusCodeNumeric' => 1062, // statusCode 必須為數值
    'gmUidEmpty' => 1063, // gmUid 為空值
    'gmUidNumeric' => 1064, // gmUid 必須為數值
    'gmUidGt' => 1065, // gmUid 數值需大於0 (不包含0)
    'sessionEmpty' => 1066, // session 為空值
    'distGroupIdGte' => 1067, // distGroupId 數值需大於等於0
    'brandTypeIn' => 1068, // type 必須為指定的內容
    'dateDate' => 1069, // date 必須為日期格式
    'epaperNumeric' => 1070, // epaper 必須為數值
    'epaperGte' => 1071, // epaper 數值需大於等於0
    'refNumeric' => 1072, // ref 必須為數值
    'refGte' => 1073, // ref 數值需大於0 (不包含0)
    'refTypeString' => 1074, // ref_type 必須為字串
    'clickIdString' => 1075, // click_id 必須為字串
    'rIdString' => 1076, // RID 必須為字串
    'transactionIdString' => 1077, // transaction_id 必須為字串
    'ecidString' => 1078, // ecid 必須為字串
    'gidString' => 1079, // gid 必須為字串
    'storeIdGte' => 1080, // storeId 數值需大於等於0
    'productIdGte' => 1081, // productId 數值需大於等於0
    'fullNameString' => 1082, // fullName 必須為字串
    'emailEmail' => 1083, // email 必須為email格式
    'mobilePhoneNumeric' => 1084, // mobilePhone 必須為數值
    'contactContentString' => 1085, // contactContent 必須為字串
    'spFlagNumeric' => 1086, // spFlag 必須為數值
    'spFlagGte' => 1087, // spFlag 數值需大於等於0
    'spIdGte' => 1088, // spId 數值需大於等於0
    'webUrlString' => 1089, // webUrl 必須為字串
    'priceNumeric' => 1090, // price 必須為數值
    'priceGte' => 1091, // price 數值需大於等於0
    'reportTypeNumeric' => 1092, // reportType 必須為數值
    'reportTypeGte' => 1093, // reportType 數值需大於等於0
    'branchAddressString' => 1094, // branchAddress 必須為字串
    'branchBusinessHoursString' => 1095, // branchBusinessHours 必須為字串
    'crossNumeric' => 1096, // cross 必須為數值
    */
];
