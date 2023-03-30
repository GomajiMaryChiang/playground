<?php

namespace App\Services;

use Config;

class ProductService
{
    // 價格類型
    const ORIGINAL_PRICE = 'orgPrice'; // 原價
    const SELLING_PRICE = 'price'; // 售價

    /**
     * 取得檔次狀態
     * @param array $product 檔次資訊
     * @return array
     */
    public function getProductStatus($product = [])
    {
        $orderStatus = !empty($product['order_status']) ? $product['order_status'] : '';
        $expiryDate = !empty($product['expiry_date']) ? $product['expiry_date'] : '';
        $cityId = !empty($product['city_id']) ? $product['city_id'] : 0;

        // 判斷是否為已募集完的公益
        if ($orderStatus == 'END' && $cityId == Config::get('city.baseCityList.publicWelfare')) {
            return 'END_CHARITY';
        }

        // 判斷是否已過期
        if (time() >= strtotime($expiryDate)) {
            return 'END_TIMEOUT';
        }

        // 判斷是否已賣完
        if ($orderStatus == 'END') {
            return 'END_SOLDOUT';
        }

        // 判斷是否為公益
        if ($cityId == Config::get('city.baseCityList.publicWelfare')) {
            return 'BUY_CHARITY';
        }

        return 'BUY_NOW';
    }

    /**
     * 取得檔次連結
     * @param array $product 檔次資訊
     * @return string 檔次連結
     */
    public function getProductLink($product = [])
    {
        $productKind = $product['product_kind'] ?? 0;

        switch ($productKind) {
            case Config::get('product.kindId.rsGid'):
                if (empty($product['store_id'])) {
                    return '#';
                }
                return sprintf('/store/%s/pid/%s', $product['store_id'], $product['product_id']);

            case Config::get('product.kindId.coffee'):
                $groupId = $product['group_id'] ?? 0;
                $productId = $product['product_id'] ?? 0;
                return sprintf('/coffee/brand/%s/pid/%s', $groupId, $productId);

            case Config::get('product.kindId.buy123'):
                if (empty($product['mobile_url'])) {
                    return '#';
                }
                $link = str_replace('https://mbuy123.gomaji.com/', 'https://buy123.gomaji.com/', $product['mobile_url']);
                if (empty($_COOKIE['gmc_site_pay']) || $_COOKIE['gmc_site_pay'] != 'ref_457') {
                    return $link;
                }

                // 美安需加上 s_banner=85shop 參數
                $urlAry = parse_url($link);
                $queryAry = isset($urlAry['query']) ? split('&', $urlAry['query']) : [];
                $queryAry['s_banner'] = '85shop';
                $newLink = sprintf('%s://%s%s?%s', $urlAry['scheme'], $urlAry['host'], $urlAry['path'], http_build_query($queryAry));
                if (!empty($urlAry['fragment'])) {
                    $newLink .= '#' . $urlAry['fragment'];
                }
                return $newLink;

            case Config::get('product.kindId.esMarket'):
            case Config::get('product.kindId.shopify'):
                if (empty($product['mobile_url'])) {
                    return '#';
                }
                return $product['mobile_url'];

            default:
                if (empty($product['store_id'])) {
                    return '#';
                }
                $productId = $product['product_id'] ?? 0;
                return sprintf('/store/%s/pid/%s', $product['store_id'], $productId);
        }
    }

    /**
     * 取得檔次價格
     * @param array  $product 檔次資訊
     * @param string $type    價格類型
     * @return string 檔次連結
     */
    public function getProductPrice($product = [], $type = '')
    {
        $productKind = $product['product_kind'] ?? '';
        $chId = $product['ch_id'] ?? '';

        // 是否為生活市集的檔次
        $isBuy123 = ($productKind == Config::get('product.kindId.buy123'));

        // 是否為宅配的檔次
        $isSh = ($productKind == Config::get('product.kindId.rsPid') && $chId == Config::get('channel.id.sh'));

        switch ($type) {
            case self::ORIGINAL_PRICE:
                if ($isBuy123 || $isSh) {
                    return $product['display_org_price'] ?? '';
                }
                return $product['org_price'] ?? '';

            case self::SELLING_PRICE:
                if ($isBuy123 || $isSh) {
                    return $product['display_price'] ?? '';
                }
                return $product['price'] ?? '';

            default:
                return '';
        }
    }

    /**
     * 取得檔次份數文字
     * @param array $product 檔次資訊
     * @return string 檔次連結
     */
    public function getDisplayDesc($product = [])
    {
        $displayFlag = $product['display_flag'] ?? 0;
        $orderNo = $product['order_no'] ?? 0;
        $remainNo = $product['remain_no'] ?? 0;
        $cityId = $product['cityId'] ?? 0;

        // 判斷是否為公益
        if ($cityId == Config::get('city.baseCityList.publicWelfare') && $orderNo > 0) {
            return sprintf('%d人響應', $orderNo);
        }

        // 顯示銷售份數
        if ($displayFlag == Config::get('product.displayFlag.orderNo') && $orderNo > 0) {
            return sprintf('售%d份', $orderNo);
        }

        // 顯示剩餘份數
        if ($displayFlag == Config::get('product.displayFlag.remainNo') && $remainNo > 0) {
            return sprintf('剩%d份', $remainNo);
        }

        return '';
    }

    /**
     * 整理檔次資訊
     * @param array $productAry 檔次資訊
     * @return array 檔次資訊
     */
    public function handleProduct(&$promoAfterCount, &$promoIndex, &$promoList, $productAry = [])
    {
        if (empty($productAry) || !is_array($productAry)) {
            return [];
        }

        foreach ($productAry as $key => $value) {
            $promoData = $value['promo_data'] ?? [];
            $productKind = $value['product_kind'] ?? 0;
            $promoList = $value['promo_list'] ?? [];
            $storeRatingScore = $value['store_rating_score'] ?? 0;
            $tkType = $value['tk_type'] ?? 0;
            $expiryDate = $value['expiry_date'] ?? '';
            $extraLabels = $value['extra_labels'] ?? '';
            $cityId = $value['city_id'] ?? 0;
            $orderNo = $value['order_no'] ?? 0;
            $iconDisplayState = $value['icon_display_state'] ?? 0;

            // 廣告
            if (!empty($promoData) && $productKind == Config('product.kindId.ad')) {
                $productAry[$key]['link'] = $this->getBannerLink($promoData);
                $productAry[$key]['subject'] = $promoData['subject'] ?? '';
                continue;
            }

            // 特別企劃
            if (!empty($promoList) && $productKind == Config('product.kindId.carousel')) {
                $promoIndex = $key;
                $promoList = $value;
                continue;
            }

            // 大小 DD
            if ($promoIndex == -1 && $productKind == Config('product.kindId.dd')) {
                $promoAfterCount = !empty($value['today_special_list']) ? count($value['today_special_list']) : 0;
                if (empty($promoAfterCount)) {
                    $promoAfterCount = -1;
                }
                continue;
            }

            $productAry[$key]['link'] = $this->getProductLink($value); // 連結網址
            $productAry[$key]['status'] = $this->getProductStatus($value); // 銷售狀態
            $productAry[$key]['display_desc'] = $this->getDisplayDesc($value); // 份數文字
            $productAry[$key]['org_price'] = $this->getProductPrice($value, self::ORIGINAL_PRICE); // 原價
            $productAry[$key]['price'] = $this->getProductPrice($value, self::SELLING_PRICE); // 售價
            $productAry[$key]['icon_new'] = $orderNo < 1000 && ($iconDisplayState & 1) === 1; // 是否顯示“最新”標籤
            $productAry[$key]['icon_hot'] = ($iconDisplayState & 2) === 2; // 是否顯示“熱銷”標籤
            $productAry[$key]['is_available_info'] = !empty($value['available_info']['enable']) && $value['available_info']['enable'] == 1; // 是否為現有空
            $productAry[$key]['class_name'] = ($productKind == Config('product.kindId.buy123') || $productKind == Config('product.kindId.esMarket') || $productKind == Config('product.kindId.shopify')) ? 'buy123Mask' : ''; // 生活市集＆旅遊行程＆shopify的檔次增加class

            // 評價為整數時，加上小數點0
            if (strpos($storeRatingScore, '.') === false) {
                $storeRatingScore .= '.0';
            }

            // 因應視圖的評價分數大小，將字體拆分
            $productAry[$key]['store_rating_int'] = floor($storeRatingScore);
            $productAry[$key]['store_rating_dot'] = substr(strval($storeRatingScore), -2);

            // 販售期限/倒數
            $productAry[$key]['until_ts'] = 0;
            if ($tkType == Config::get('product.tkType.limit') && !empty($expiryDate)) {
                $productAry[$key]['until_ts'] = strtotime($expiryDate) - time();
            }

            // 不推薦
            if (!empty($value['bt_no_sale'])) {
                $productAry[$key]['bt_no_sale'] = str_replace('(', '</span><span class="t-08">(', $value['bt_no_sale']);
            }

            // 圖片下方的地區標籤＆說明標籤
            if ($productKind == Config('product.kindId.coffee')) {
                $productAry[$key]['spot_name'] = '';
                $productAry[$key]['extra_labels'] = '';
            } elseif ($extraLabels == '紙本票券寄送') {
                $productAry[$key]['spot_name'] = '';
            } elseif ($cityId == Config::get('city.baseCityList.publicWelfare')) {
                $productAry[$key]['spot_name'] = '公益';
            }

            // 商品名稱
            if ($productKind == Config('product.kindId.rsGid') && $cityId == Config::get('city.baseCityList.publicWelfare')) {
                $productAry[$key]['real_product_name'] = $value['group_name'];
            } elseif ($productKind == Config('product.kindId.coffee')) {
                $productAry[$key]['real_product_name'] = sprintf('【%s】%s', $value['store_name'], $value['product_name']);
            } else {
                $productAry[$key]['real_product_name'] = $value['store_name'];
            }

            // 商品副名稱
            if (!empty($value['app_sub_product_name'])) {
                $productAry[$key]['real_sub_product_name'] = $value['app_sub_product_name'];
            } elseif (!empty($value['rs_data'])) {
                $productAry[$key]['real_sub_product_name'] = $value['rs_data']['group_buy'] ?? '';
            } elseif (!empty($value['product_name'])) {
                $productAry[$key]['real_sub_product_name'] = $value['product_name'];
            }
        }

        return $productAry;
    }

    /**
     * 取得輪播連結
     * @param array $banner 輪播資訊
     * @return string 輪播連結
     */
    public function getBannerLink($banner)
    {
        switch ($banner['action']) {
            case 'url':
                $urlAry = parse_url($banner['link_url']);
                if ($urlAry['host'] == 'www.gomaji.com' && $urlAry['path'] == '/index.php') {
                    return sprintf('/ch/%s?city=%s&category=%s', $banner['ch_id'], $banner['city_id'], $banner['cat_id']);
                }

                // 美安需加上 s_banner=85shop 參數
                if (in_array($urlAry['host'], ['buy123.gomaji.com', 'mbuy123.gomaji.com', 'appbuy123.gomaji.com']) && !empty($_COOKIE['gmc_site_pay']) && $_COOKIE['gmc_site_pay'] == 'ref_457') {
                    $queryAry = isset($urlAry['query']) ? split('&', $urlAry['query']) : [];
                    $queryAry['s_banner'] = '85shop';
                    $newLink = sprintf('%s://%s%s?%s', $urlAry['scheme'], $urlAry['host'], $urlAry['path'], http_build_query($queryAry));
                    if (!empty($urlAry['fragment'])) {
                        $newLink .= '#' . $urlAry['fragment'];
                    }

                    return $newLink;
                }
               return $banner['link_url'];
            case 'ch':
                return sprintf('/category/%s?ch_id=%s&city_id=%s&bi_id=%s', $banner['cat_id'], $banner['ch_id'], $banner['city_id'], $banner['bi_id']);
            case 'product':
                return sprintf('/store/%s/pid/%s?gid=%s', $banner['sid'], $banner['pid'], $banner['gid']);
            case 'muti-products':
                return sprintf('/event_list/?channel_id=%s&city_id=%s&event_id=%s&bi_id=%s', $banner['ch_id'], $banner['city_id'], $banner['event_id'], $banner['bi_id']);
            default:
                return '/';
        }
    }

    /**
    * 取得Banner的頻道編號
    * @param array  $productInfo  商品資訊
    * @return int                 頻道編號
    */
    public function getBannerCh($productInfo = array())
    {
        $productKind = $productInfo['product_kind'] ?? 0;
        $chId        = $productInfo['ch_id'] ?? 0;
        $catId       = $productInfo['category_id'] ?? 0;
        $subCatId    = $productInfo['sub_category_ids'] ?? '';
        $catIdAry    = array_unique(array_merge(explode(',', $subCatId), array($catId)));

        /*
        config的channel尚未修改 先暫時註解

        // 麻吉咖啡
        if (CHANNEL_RS == $chId && PRODUCT_KIND_COFFEE == $productKind) {
            return CHANNEL_COFFEE;
        }

        // 海外旅遊
        if (CHANNEL_ESCAPES == $chId && array_intersect($catIdAry, CHANNEL_FOR_CATE)) {
            return CHANNEL_FOR;
        }

        // 情侶休息
        if (CHANNEL_ESCAPES == $chId && array_intersect($catIdAry, CHANNEL_QK_CATE)) {
            return CHANNEL_QK;
        }
        */
        return $chId;
    }

    // config 全域變數需再修正(publicWelfare先暫時寫死19)
    public function getProductName($product)
    {
        $storeName = empty($product['store_name']) ? '(無商家名稱)' : $product['store_name'];

        if (empty($product['group_name'])) {
            return $storeName;
        }

        // config PublicWelfare
        if ($product['city_id'] == 19) {
            return $storeName;
        }

        if (Config::get('product.kindId.rsGid') == $product['product_kind'] ||  Config::get('product.kindId.coffee') == $product['product_kind']) {
            return $product['group_name'];
        }

        return $storeName;
    }

    /**
    * 處理商品描述的跳窗
    * @param string  $description  商品描述
    * @return string               商品描述
    */
    public function handleProductDescription($description)
    {
        if (empty($description) || !is_string($description)) {
            return '';
        }

        $index = 0;
        $pos = true;
        $keyAry = [
            '<p>',
            '<p class="tooltiptext tooltiptexthidden" id="pcode_need_money">',
            '<p class="tooltiptext tooltiptexthidden" id="hint_service_fee">',
        ];

        while ($pos) {
            $pos = strrpos($description, '<span class="tooltip">', 0);
            if ($pos) {
                $pos2 = strrpos($description, '</span>', 0);
                $tooltip = substr($description, $pos, $pos2 - $pos + 7);

                // 搜尋跳窗裡的字是用什麼標籤開頭的
                $info = [];
                foreach ($keyAry as $value) {
                    if (strpos($tooltip, $value)) {
                        $info = explode($value, $tooltip);
                        break;
                    }
                }

                $title = strip_tags($info[0]);
                $note = empty($info[1]) ? '' : $info[1];
                $note = strip_tags($note);

                $newTooltip = '<button type="button" class="tag tag-explanation d-inline-block t-main" data-toggle="popover" data-content="' . htmlspecialchars($note) . '">' . $title . '</button>';
                $description = str_replace($tooltip, $newTooltip, $description);
            }

            $index++;

            if (5 < $index) {
                break;
            }
        }

        return $description;
    }

    /**
     * 取得檔次的頻道資訊
     * @param array $product 檔次資訊
     * @return array 頻道資訊
     */
    public function getBu($product = [])
    {
        $chId = $product['product']['ch_id'] ?? 0;
        $subChId = $product['product']['sub_channels'] ?? '';
        $catId = $product['product']['category_id'] ?? 0;
        $subChIdAry = explode(',', $subChId);

        // 判斷是否非紙本票券
        if ($chId != Config::get('channel.id.sh') || $catId != Config::get('product.categoryId.ticket')) {
            return [
                'id' => $chId,
                'name' => Config::get("channel.homeList.{$chId}.title"),
            ];
        }

        // 判斷是否借檔至旅遊頻道
        if (in_array(Config::get('channel.id.es'), $subChIdAry) || in_array(Config::get('channel.id.lf'), $subChIdAry)) {
            return [
                'id' => Config::get('channel.id.es'),
                'name' => '旅遊住宿',
            ];
        }

        // 判斷是否借檔至餐廳頻道
        if (in_array(Config::get('channel.id.rs'), $subChIdAry)) {
            return [
                'id' => Config::get('channel.id.rs'),
                'name' => '美食餐廳',
            ];
        }

        return [
            'id' => $chId,
            'name' => Config::get("channel.homeList.{$chId}.title"),
        ];
    }
}
