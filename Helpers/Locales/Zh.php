<?php

namespace Helpers\Locales;

class Zh extends AbstractLanguage {

    public static int $id = 356;
    
    public string
        $active            = '活躍的',
        $addLevel          = '添加等級',
        $addPlan           = '添加計劃',
        $addProject        = '新增專案',
        $after             = '後',
        $availableValues   = '可用值',
        $badPassword       = '密碼無效',
        $chat              = '聊天室',
        $check             = '簽出',
        $dateStart         = '推出日期',
        $deposit           = '入金',
        $description       = '內容描述',
        $enter             = '登入',
        $error             = '失誤',
        $exit              = '外出',
        $expectedNumber    = '預期人數',
        $fileNotFound      = '找不到文件 %s',
        $fixedLength       = '固定長度',
        $free              = '免費的',
        $freeForAddProject = '將項目完全添加到數據庫',
        $from              = '來自',
        $guest             = '來賓',
        $headKeywords      = '炒作監測2020年，高利潤項目，在互聯網上賺錢，投資項目，金字塔',
        $headDescription   = '2020年高利潤投資項目',
        $headTitle         = '投資市場',
        $invalidDateFormat = '日期格式無效',
        $languages         = '網站語言',
        $level             = '等級',
        $login             = '用戶名',
        $loginIsBusy       = '此登錄名已被註冊。 輸入另一個',
        $maxLength         = '最大字符數:',
        $maxValue          = '最大值:',
        $minLength         = '最少字符數:',
        $minValue          = '最小值:',
        $menu              = '菜單',
        $name              = '名',
        $needAuthorization = '您需要登錄',
        $no                = '沒有啦',
        $noAccess          = '無法進入',
        $noLanguage        = '找不到語言',
        $noUser            = '找不到使用者',
        $noPage            = '找不到頁面',
        $noProject         = '找不到專案',
        $notPublished      = '未發表',
        $options           = '選件',
        $password          = '密碼',
        $paymentSystem     = '付款系統',
        $period            = '期間',
        $plans             = '關稅計劃',
        $profit            = '獲利',
        $projectName       = '項目名稱',
        $projectIsAdded    = '項目已添加',
        $projectUrl        = '鏈接到項目(或引薦鏈接)',
        $prohibitedChars   = '輸入了非法字符',
        $refProgram        = '推薦程序',
        $registration      = '報名',
        $remember          = '記住我',
        $remove            = '刪掉',
        $repeatPassword    = '重新輸入密碼',
//        $selectFile        = '選擇檔案',
        $sendForm          = '提交表格',
        $showAllLangs      = '顯示所有語言',
        $siteExists        = '該站點已經在數據庫中',
        $siteIsFree        = '網站不在數據庫中',
        $startDate         = '項目開始日期',
        $success           = '成功的',
        $userRegistered    = '用戶註冊',
        $userRegistration  = '用戶註冊',
        $writeMessage      = '寫留言...',
        $wrongUrl          = '無效的網站地址',
        $wrongValue        = '無效值',
        $yes               = '是的',
        $youAreAuthorized  = '您已登錄';

    public array
        $paymentType       = ['付款類型', '說明書', '即時(即時)', '自動的'],
        $periodName        = ['', '分鐘', '小時', '天', '週', '個月', '年'],
        $currency          = ['美元', '歐元', '比特幣', '盧布', '磅', '日元', '韓元', '盧比'];

    public function getPeriodName(int $i, int $k): string {
        return ['分鐘', '小時', '天', '週', '個月', '年'][$i-1];
    }
}