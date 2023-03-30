<?php

namespace App\Services;

use Config;

class JsonldService
{
    /**
     * 取得jsonld資訊(提升SEO)
     * @return array
     */
    public function getJsonldData($type, $data)
    {
        $result['type'] = $type;  // 主類型

        // 檔次頁
        if ($type == 'Product') {
            // ===== Porduct start =====//
            $result['product']['jsonldType'] = 'Product';  // 類型
            $result['product']['name'] = mb_substr($data['product']['store_name'], 0, 150, 'utf-8');  // 商品名稱(Text)

            // 商品圖片(URL、ImageObject)
            $result['product']['imgArray'] = '';
            for ($i = 0; $i < count($data['product']['img']); $i++) {
                if ($i == count($data['product']['img']) - 1) {
                    $result['product']['imgArray'] .= '"' . $data['product']['img'][$i] . '"';
                } else {
                    $result['product']['imgArray'] .= '"' . $data['product']['img'][$i] . '",';
                }
            }
            $result['product']['description'] = $data['product']['real_product_name'];  // 商品描述
            $result['product']['sku'] = $data['product']['product_id'];  // 商品專屬ID
            $result['product']['brandName'] = $data['product']['store_name'] . ' | GOMAJI夠麻吉';  // 品牌名稱
            $result['product']['ratingValue'] = trim(explode("</span>", $data['product']['store_rating_score'])[0] . explode(">", explode(" ", $data['product']['store_rating_score'])[3])[1]);  // 評價分數
            $result['product']['reviewCount'] = $data['product']['store_rating_people'];  // 總評分數量
            $result['product']['offerUrl'] = Config::get('setting.usagiDomain') . '/store/' . $data['product']['store_id'] . '/pid/' . $data['product']['product_id'];  // 商品url
            $result['product']['priceCurrency'] = 'TWD';  // 價格單位
            $result['product']['price'] = $data['product']['price'];  // 價格費用
            $result['product']['priceValidUntil'] = explode("T", $data['product']['expiry_date'])[0];  // 商品期限
            // ===== Porduct end =====//

            // ===== BreadcrumbList start =====//
            $result['breadCrumbList']['jsonldType'] = 'BreadcrumbList';  // 類型
            $result['breadCrumbList']['nameSec'] = $data['resDetail']['sub_name']; // 麵包穴第2項名稱
            $result['breadCrumbList']['itemSec'] = Config::get('setting.usagiDomain') . $data['resDetail']['sub_link']; // 麵包穴第2項網址
            $result['breadCrumbList']['nameThi'] = $data['product']['store_name']; // 麵包穴第3項名稱
            $result['breadCrumbList']['itemThi'] = Config::get('setting.usagiDomain') . $data['resDetail']['sub_child_link']; // 麵包穴第3項網址
            // ===== BreadcrumbList end =====//
        }

        // 首頁
        if ($type == 'Index') {
            $result['itemList']['jsonldType'] = 'ItemList';
            $result['itemList']['list'] = '';
            $link_array = [];
            $linkMatch = '';

            $j = 1;
            // 大 DD
            foreach ($data['todaySpecialList'] as $product) {
                if (!empty($product['link']) && $product['product_kind'] != 4) {
                    $url = (substr($product['link'], 0, 4) == 'http')
                        ? $product['link']
                        : Config::get('setting.usagiDomain') . $product['link'];
                    // 作為連結重複性比對使用
                    $link_array[] = $url;
                    $result['itemList']['list'] .= '
                        {
                            "@type":"ListItem",
                            "position":' . $j . ',
                            "url":"' . $url . '"
                        },';
                    $j++;
                }
            }
            // 小 DD
            foreach ($data['todaySubSpecialList'] as $product) {
                if (!empty($product['link']) && $product['product_kind'] != 4) {
                    $url = (substr($product['link'], 0, 4) == 'http')
                        ? $product['link']
                        : Config::get('setting.usagiDomain') . $product['link'];
                    if (!empty($link_array)) {
                        // 比對連結是否有重複性
                        $linkMatch = in_array($url, $link_array);
                    }
                    // 連結尚未重複
                    if ($linkMatch == false) {
                        $result['itemList']['list'] .= '
                            {
                                "@type":"ListItem",
                                "position":' . $j . ',
                                "url":"' . $url . '"
                            },';
                        $j++;
                        // 將尚未重複的連結寫入陣列中
                        if (empty($link_array)) {
                            $link_array[] = $url;
                        } else {
                            array_push($link_array, $url);
                        }
                    }
                }
            }
            // 今日上架
            foreach ($data['recommendList'] as $product) {
                if (!empty($product['link']) && $product['product_kind'] != 4) {
                    $url = (substr($product['link'], 0, 4) == 'http')
                        ? $product['link']
                        : Config::get('setting.usagiDomain') . $product['link'];

                    if (!in_array($url, $link_array)) {
                        $result['itemList']['list'] .= '
                            {
                                "@type":"ListItem",
                                "position":' . $j . ',
                                "url":"' . $url . '"
                            },';
                        $j++;
                    }
                }
            }
            // 將最後逗號符號去除
            $result['itemList']['list'] = substr($result['itemList']['list'], 0, -1);
        }

        // 店家頁
        if ($type == 'Store') {
            // ===== Restaurant start =====//
            $result['restaurant']['jsonldType'] = 'Restaurant';  // 類型
            $result['restaurant']['image'] = $data['store']['store_img_url'];  //店家圖片
            $result['restaurant']['id'] = 'https://www.gomaji.com/store/' . $data['store']['store_id'];  // 店家網址(不對外開放)
            $result['restaurant']['name'] = $data['store']['store_name'];  // 店家名稱
            $result['restaurant']['streetAddress'] = $data['store']['store_address'];  // 店家地址
            $result['restaurant']['addressLocality'] = mb_substr($data['store']['store_address'], 0, 3);  // 區域
            $result['restaurant']['addressRegion'] = '台灣';  //地 區
            $result['restaurant']['addressCountry'] = 'Taiwan';
            $result['restaurant']['ratingValue'] = $data['store']['rating']['avg_rating']; // 平均評價分
            $result['restaurant']['bestRating'] = ''; // 最高評價分
            $result['restaurant']['latitude'] = ''; // 店家緯度
            $result['restaurant']['longitude'] = ''; // 店家經度
            $result['restaurant']['url'] = Config::get('setting.usagiDomain') . '/store/' . $data['store']['store_id']; // 店家網址(對外開放)
            $result['restaurant']['telephone'] = $data['store']['store_tel']; // 店家電話

            $priceArray = [];
            foreach ($data['store']['products'] as $val) {
                $priceArray[] = $val['price'];
            }
            if (count($priceArray) > 1) {
                $result['restaurant']['priceRange'] = '$' . min($priceArray) . '-' . '$' . max($priceArray); // 價格範圍
            } else {
                $result['restaurant']['priceRange'] = '$' . ($priceArray[0] ?? '');
            }

            $result['restaurant']['menu'] = Config::get('setting.usagiDomain') . '/store/' . $data['store']['store_id']; // 店家檔次（菜單）
            //===== Restaruant end =====//

            // ===== BreadcrumbList start =====//
            $result['breadCrumbList']['jsonldType'] = 'BreadcrumbList';  // 類型
            $result['breadCrumbList']['nameSec'] = $data['breadcrumb']['title']; // 麵包穴第2項名稱
            $result['breadCrumbList']['itemSec'] = Config::get('setting.usagiDomain') . $data['breadcrumb']['link']; // 麵包穴第2項網址
            $result['breadCrumbList']['nameThi'] = $data['breadcrumb']['subTitle']; // 麵包穴第3項名稱
            $result['breadCrumbList']['itemThi'] = Config::get('setting.usagiDomain') . '/store/' . $data['store']['store_id']; // 麵包穴第3項網址
            // ===== BreadcrumbList end =====//

            // ===== ItemList start =====//
            $result['itemList']['jsonldType'] = 'ItemList';
            $result['itemList']['list'] = '';

            $j = 1;
            foreach ($data['productList'] as $product) {
                $result['itemList']['list'] .= '
                    {
                        "@type":"ListItem",
                        "position":' . $j . ',
                        "url":"' . Config::get('setting.usagiDomain') . $product['link'] . '"
                    },';
                $j++;
            }
            // 將最後逗號符號去除
            $result['itemList']['list'] = substr($result['itemList']['list'], 0, -1);
            //===== ItemList end =====//
        }

        // 頻道頁
        if ($type == 'Channel') {
            // ===== ItemList start =====//
            $result['itemList']['jsonldType'] = 'ItemList';
            $result['itemList']['list'] = '';

            $j = 1;
            foreach ($data['products'] as $product) {
                if (!empty($product['link']) && $product['product_kind'] != 4) {
                    $result['itemList']['list'] .= '
                        {
                            "@type":"ListItem",
                            "position":' . $j . ',
                            "url":"' . Config::get('setting.usagiDomain') . $product['link'] . '"
                        },';
                    $j++;
                }
            }
            // 將最後逗號符號去除
            $result['itemList']['list'] = substr($result['itemList']['list'], 0, -1);
            //===== ItemList end =====//

            // ===== BreadcrumbList start =====//
            $result['breadCrumbList']['jsonldType'] = 'BreadcrumbList';  // 類型
            $result['breadCrumbList']['nameSec'] = $data['chTitle']; // 麵包穴第2項名稱
            $result['breadCrumbList']['itemSec'] = $data['meta']['canonicalUrl'] ?? ''; // 麵包穴第2項網址
            // ===== BreadcrumbList end =====//
        }

        // 咖啡品牌＆熱銷宅配美食(/es_foreign)檔次列表
        if ($type == 'Coffee' || $type == 'EsForeign') {
            // ===== ItemList start =====//
            $result['itemList']['jsonldType'] = 'ItemList';
            $result['itemList']['list'] = '';

            $j = 1;
            if (isset($data['products'])) {
                foreach ($data['products'] as $product) {
                    if (!empty($product['link']) && $product['product_kind'] != 4) {
                        $result['itemList']['list'] .= '
                            {
                                "@type":"ListItem",
                                "position":' . $j . ',
                                "url":"' . Config::get('setting.usagiDomain') . $product['link'] . '"
                            },';
                        $j++;
                    }
                }
            }

            // 將最後逗號符號去除
            $result['itemList']['list'] = substr($result['itemList']['list'], 0, -1);
            //===== ItemList end =====//

            // ===== BreadcrumbList start =====//
            $result['breadCrumbList']['jsonldType'] = 'BreadcrumbList';  // 類型
            $result['breadCrumbList']['nameSec'] = $data['title']; // 麵包穴第2項名稱
            $result['breadCrumbList']['itemSec'] = $data['meta']['canonicalUrl'] ?? ''; // 麵包穴第2項網址
            // ===== BreadcrumbList end =====//
        }

        // 星級飯店品牌餐廳、名店美食
        if ($type == 'Brand') {
            // ===== ItemList start =====//
            $result['itemList']['jsonldType'] = 'ItemList';
            $result['itemList']['list'] = '';

            $j = 1;
            foreach ($data['brandList'] as $value) {
                foreach ($value as $key => $brand) {
                    $result['itemList']['list'] .= '
                        {
                            "@type":"ListItem",
                            "position":' . $j . ',
                            "url":"' . Config::get('setting.usagiDomain') . '/brand/' . $brand['pa_id'] . '?type=RS"
                        },';
                    $j++;
                }
            }
            // 將最後逗號符號去除
            $result['itemList']['list'] = substr($result['itemList']['list'], 0, -1);
            //===== ItemList end =====//

            // ===== BreadcrumbList start =====//
            $result['breadCrumbList']['jsonldType'] = 'BreadcrumbList';  // 類型
            $result['breadCrumbList']['nameSec'] = $data['title']; // 麵包穴第2項名稱
            $result['breadCrumbList']['itemSec'] = $data['meta']['canonicalUrl'] ?? ''; // 麵包穴第2項網址
            // ===== BreadcrumbList end =====//
        }

        // 星級飯店品牌餐廳 檔次列表
        if ($type == 'BrandList') {
            // ===== ItemList start =====//
            $result['itemList']['jsonldType'] = 'ItemList';
            $result['itemList']['list'] = '';

            $j = 1;
            foreach ($data['products'] as $product) {
                if (!empty($product['link']) && $product['product_kind'] != 4) {
                    $result['itemList']['list'] .= '
                        {
                            "@type":"ListItem",
                            "position":' . $j . ',
                            "url":"' . Config::get('setting.usagiDomain') . $product['link'] . '"
                        },';
                    $j++;
                }
            }
            // 將最後逗號符號去除
            $result['itemList']['list'] = substr($result['itemList']['list'], 0, -1);
            //===== ItemList end =====//

            // ===== BreadcrumbList start =====//
            $result['breadCrumbList']['jsonldType'] = 'BreadcrumbList';  // 類型
            $result['breadCrumbList']['nameSec'] = $data['breadcrumbList'][1]['title'] ?? ''; // 麵包穴第2項名稱
            $result['breadCrumbList']['itemSec'] = Config::get('setting.usagiDomain') . $data['breadcrumbList'][1]['link'] ?? ''; // 麵包穴第2項網址

            $result['breadCrumbList']['nameThi'] = $data['breadcrumbList'][2]['title'] ?? ''; // 麵包穴第3項名稱
            $result['breadCrumbList']['itemThi'] = $data['meta']['canonicalUrl'] ?? ''; // 麵包穴第3項網址
            if (count($data['breadcrumbList']) > 3) {
                $result['breadCrumbList']['itemThi'] = Config::get('setting.usagiDomain') . $data['breadcrumbList'][2]['link'] ?? ''; // 麵包穴第3項網址

                $result['breadCrumbList']['nameFor'] = $data['breadcrumbList'][3]['title'] ?? ''; // 麵包穴第4項名稱
                $result['breadCrumbList']['itemFor'] = $data['meta']['canonicalUrl'] ?? ''; // 麵包穴第4項網址
            }
            // ===== BreadcrumbList end =====//
        }

        // 主題頁&活動頁、特別企劃、排行榜 檔次列表頁
        if ($type == 'Category' || $type == 'Special' || $type == '510' || $type == 'ChSpecial') {
            // ===== ItemList start =====//
            $result['itemList']['jsonldType'] = 'ItemList';
            $result['itemList']['list'] = '';

            $j = 1;
            foreach ($data['products'] as $product) {
                if (!empty($product['link']) && $product['product_kind'] != 4) {
                    $result['itemList']['list'] .= '
                        {
                            "@type":"ListItem",
                            "position":' . $j . ',
                            "url":"' . Config::get('setting.usagiDomain') . $product['link'] . '"
                        },';
                    $j++;
                }
            }
            // 將最後逗號符號去除
            $result['itemList']['list'] = substr($result['itemList']['list'], 0, -1);
            //===== ItemList end =====//

            // ===== BreadcrumbList start =====//
            $result['breadCrumbList']['jsonldType'] = 'BreadcrumbList';  // 類型
            $result['breadCrumbList']['nameSec'] = $data['chTitle'] ?? ''; // 麵包穴第2項名稱
            $result['breadCrumbList']['itemSec'] = ($type != '510') // 麵包穴第2項網址
                ? Config::get('setting.usagiDomain') . $data['chTitleUrl']  ?? ''
                : $result['breadCrumbList']['itemThi'] = $data['meta']['canonicalUrl'] ?? '';
            if ($type != '510') {
                $result['breadCrumbList']['nameThi'] = $data['subChTitle'] ?? ''; // 麵包穴第3項名稱
                $result['breadCrumbList']['itemThi'] = $data['meta']['canonicalUrl'] ?? ''; // 麵包穴第3項網址
            }
            // ===== BreadcrumbList end =====//
        }

        // 特別企劃、排行榜
        if ($type == 'SpecialList') {
             // ===== ItemList start =====//
            $result['itemList']['jsonldType'] = 'ItemList';
            $result['itemList']['list'] = '';

            $j = 1;
            foreach ($data['specialList'] as $specialList) {
                if (!empty($specialList['id'])) {
                    $specialListUrl = sprintf('%s/%s/%s?city=%s', Config::get('setting.usagiDomain'), $data['type'], $specialList['id'], $specialList['city_id'] ?? 1);
                    $result['itemList']['list'] .= '
                        {
                            "@type":"ListItem",
                            "position":' . $j . ',
                            "url":"' . $specialListUrl . '"
                        },';
                    $j++;
                }
            }
            // 將最後逗號符號去除
            $result['itemList']['list'] = substr($result['itemList']['list'], 0, -1);
            //===== ItemList end =====//

            // ===== BreadcrumbList start =====//
            $result['breadCrumbList']['jsonldType'] = 'BreadcrumbList';  // 類型
            $result['breadCrumbList']['nameSec'] = $data['title'] ?? ''; // 麵包穴第2項名稱
            $result['breadCrumbList']['itemSec'] = $data['meta']['canonicalUrl'] ?? ''; // 麵包穴第2項網址
            // ===== BreadcrumbList end =====//
        }

        // 搜尋結果頁
        if ($type == 'Search') {
            // ===== ItemList start =====//
            $result['itemList']['jsonldType'] = 'ItemList';
            $result['itemList']['list'] = '';

            $j = 1;
            foreach ($data['products'] as $product) {
                if (!empty($product['link']) && $product['product_kind'] != 4) {
                    $result['itemList']['list'] .= '
                        {
                            "@type":"ListItem",
                            "position":' . $j . ',
                            "url":"' . Config::get('setting.usagiDomain') . $product['link'] . '"
                        },';
                    $j++;
                }
            }
            // 將最後逗號符號去除
            $result['itemList']['list'] = substr($result['itemList']['list'], 0, -1);
            //===== ItemList end =====//

            // ===== BreadcrumbList start =====//
            $result['breadCrumbList']['jsonldType'] = 'BreadcrumbList';  // 類型
            $result['breadCrumbList']['nameSec'] = $data['title'] ?? ''; // 麵包穴第2項名稱
            $result['breadCrumbList']['itemSec'] = $data['meta']['canonicalUrl']; // 麵包穴第2項網址
            // ===== BreadcrumbList end =====//
        }

        // 關於我們、公司記事、媒體報導、隱私權保護政策、服務條款、客服中心
        if ($type == 'About' || $type == 'Privacy' || $type == 'Terms' || $type == 'Help') {
            // ===== BreadcrumbList start =====//
            $result['breadCrumbList']['jsonldType'] = 'BreadcrumbList';  // 類型
            $result['breadCrumbList']['nameSec'] = $data['pageTitle']; // 麵包穴第2項名稱
            $result['breadCrumbList']['itemSec'] = $data['meta']['canonicalUrl'] ?? ''; // 麵包穴第2項網址
            // ===== BreadcrumbList end =====//
        }

        // 聯絡我們
        if ($type == 'Contact') {
            // ===== BreadcrumbList start =====//
            $result['breadCrumbList']['jsonldType'] = 'BreadcrumbList';  // 類型
            $result['breadCrumbList']['nameSec'] = '客服中心'; // 麵包穴第2項名稱
            $result['breadCrumbList']['itemSec'] = Config::get('setting.usagiDomain') . '/help'; // 麵包穴第2項網址
            $result['breadCrumbList']['nameThi'] = $data['chTitle']; // 麵包穴第3項名稱
            $result['breadCrumbList']['itemThi'] = $data['meta']['canonicalUrl'] ?? ''; // 麵包穴第3項網址
            // ===== BreadcrumbList end =====//
        }

        // 客服中心
        if ($type == 'Help') {
            // ===== ItemList start =====//
            $result['mainEntity']['list'] = '';

            $listNum = !empty($data['faqLists']['question']) ? count($data['faqLists']['question']) : 0;
            for ($i = 0; $i < $listNum; $i++) {
                foreach ($data['faqLists']['question'][$i]['question_list'] as $info) {
                    $result['mainEntity']['list'] .= '
                    {
                        "@type": "Question",
                        "name": "' . $info['question'] . '",
                        "acceptedAnswer": {
                            "@type": "Answer",
                            "text": "' . str_replace("\"", "'", $info['answer']) . '"
                        }
                    },';
                }
            }
            // 將最後逗號符號去除
            $result['mainEntity']['list'] = substr($result['mainEntity']['list'], 0, -1);
            //===== ItemList end =====//
        }

        // 網紅頁、APP 下載頁
        if (in_array($type, ['Kol', 'App'])) {
            // ===== BreadcrumbList start =====//
            $result['breadCrumbList']['jsonldType'] = 'BreadcrumbList'; // 類型
            $result['breadCrumbList']['nameSec'] = $data['pageTitle'] ?? ''; // 麵包穴第2項名稱
            $result['breadCrumbList']['itemSec'] = $data['pageUrl'] ?? ''; // 麵包穴第2項網址
            // ===== BreadcrumbList end =====//
        }

        // 聰明賺點列表
        if ($type == 'Earnpoint') {
            // ===== ItemList start =====//
            $result['itemList']['jsonldType'] = 'ItemList';
            $result['itemList']['list'] = '';

            if (!empty($data['products'])) {
                foreach ($data['products'] as $key => $product) {
                    $result['itemList']['list'] .= '
                        {
                            "@type":"ListItem",
                            "position":' . ($key + 1) . ',
                            "url":"' . Config::get('setting.usagiDomain') . ($product['link'] ?? '') . '"
                        },';
                }
            }

            $result['itemList']['list'] = substr($result['itemList']['list'], 0, -1); // 將最後逗號符號去除
            //===== ItemList end =====//


            // ===== BreadcrumbList start =====//
            $result['breadCrumbList']['jsonldType'] = 'BreadcrumbList'; // 類型
            $result['breadCrumbList']['nameSec'] = $data['pageTitle'] ?? ''; // 麵包穴第2項名稱
            $result['breadCrumbList']['itemSec'] = $data['pageUrl'] ?? ''; // 麵包穴第2項網址
            // ===== BreadcrumbList end =====//
        }

        // 聰明賺點詳細頁
        if ($type == 'EarnpointDetail') {
            // ===== BreadcrumbList start =====//
            $result['breadCrumbList']['jsonldType'] = 'BreadcrumbList'; // 類型
            $result['breadCrumbList']['nameSec'] = '聰明賺點'; // 麵包穴第2項名稱
            $result['breadCrumbList']['itemSec'] = sprintf('%s%s', Config::get('setting.usagiDomain'), '/earnpoint'); // 麵包穴第2項網址
            $result['breadCrumbList']['nameThi'] = $data['pageTitle'] ?? ''; // 麵包穴第3項名稱
            $result['breadCrumbList']['itemThi'] = $data['pageUrl'] ?? ''; // 麵包穴第3項網址
            // ===== BreadcrumbList end =====//
        }

        return $result;
    }
}
