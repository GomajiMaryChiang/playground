@extends('modules.common')

@section('content')
    <div class="product-head-wrapper help-wrapper help-contact theme-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <h1 class="theme-header text-center">{{ $bannerTitle }}</h1>
                </div>
            </div>
        </div>
    </div>
    <main class="main main-contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    @if ($isShowLightHeader)
                    <!--使用APP瀏覽，Header不顯示，麵包屑也不顯示 -->
                        <nav aria-label="breadcrumb mt-2">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('') }}">首頁</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $chTitle }}</li>
                            </ol>
                        </nav>
                    @endif
                    <!-- End:breadcrumb -->
                    <div class="row no-gutters help-faq-wrapper">
                        <div class="col-lg-3 col-md-3 col-sm-12">
                            <div class="sticky-top">
                                <div id="faq" class="list-group faq">
                                    <a class="list-group-item list-group-item-action active" href="#PrivacyTerm-1">GOMAJI 夠麻吉</a>
                                    @if ($date < '2023-04-01 00:00:00')
                                        <a class="list-group-item list-group-item-action" href="#PrivacyTerm-2">宅配購物+ 頻道</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-12">
                            <div class="help-faq-content PrivacyTerm">
                                <h2 id="PrivacyTerm-1" class="t-main">GOMAJI 夠麻吉「個人資料蒐集告知 & 隱私權保護政策」</h2>
                                <div class="TermBox">
                                    <p class="text-right t-gray t-09">更新日期：2022年03月10日</p>
                                    <p>歡迎您使用「GOMAJI APP」、及「GOMAJI 吃喝玩樂平台(Web、MWeb)」
                                        (<a class="underline" href="{{ url('') }}">https://www.gomaji.com</a>),
                                        本平台係由『夠麻吉股份有限公司』(下稱 本公司)所建置、經營,提供『優惠兌換券』銷售及預約系統(包含關係企業一起旅行社股份有限公司(旅遊、旅宿業相關))、自營宅配商品(含紙本票券、商品相關) 等(以下合稱 本服務)。本公司非常重視您個人資訊的保護，為了提供您安心消費的環境，本公司對於客戶資料的蒐集、處理、利用、保護均遵守中華民國政府的「個人資料保護法」特定目的及相關法令規範，並制定「個人資料蒐集告知 & 隱私權保護政策」(下稱 本政策)及以維護您個人資料及隱私權。</p>
                                    <h3>【個人資料蒐集告知】</h3>
                                    <ul>
                                        <li>
                                            <h4>一、何謂個人資料蒐集告知</h4>
                                            <p>依我國個人資料保護法第八條規定，經由各項服務所取得您的個人資料時，需依法向您踐行告知
                                                義務，使您知悉本服務蒐集您個人資料的目的、類別、利用期間、地區、對象、方式等內容，並
                                                於同意後方能使用本服務所提供之服務。</p>
                                        </li>
                                        <li>
                                            <h4>二、蒐集之目的</h4>
                                            <p>依據法務部頒佈之「個人資料保護法之特定目的及個人資料之類別」，本公司蒐集、處理、利用及保有您個人資料之特定目的列示如下:</p>
                                            <ul>
                                                <li>•○四○ 行銷(包含金控共同行銷業務)</li>
                                                <li>•○五八 社會服務或社會工作</li>
                                                <li>•○六三 非公務機關依法定義務所進行個人資料之蒐集處理及利用</li>
                                                <li>•○六七 信用卡、現金卡、轉帳卡或電子票證業務</li>
                                                <li>•○七七 訂位、住宿登記與購票業務</li>
                                                <li>•○八一 個人資料之合法交易業務</li>
                                                <li>•○九○ 消費者、客戶管理與服務</li>
                                                <li>•○九一 消費者保護</li>
                                                <li>•○九八 商業與技術資訊</li>
                                                <li>•一一一 票券業務</li>
                                                <li>•一二四 鄉鎮市調解</li>
                                                <li>•一二七 募款(包含公益勸募)</li>
                                                <li>•一二九 會計與相關服務</li>
                                                <li>•一三五 資(通)訊服務</li>
                                                <li>•一三六 資(通)訊與資料庫管理</li>
                                                <li>•一三七 資通安全與管理</li>
                                                <li>•一三八 農產品交易</li>
                                                <li>•一四三 運動休閒業務</li>
                                                <li>•一四八 網路購物及其他電子商務服務</li>
                                                <li>•一五二 廣告或商業行為管理</li>
                                                <li>•一五七 調查、統計與研究分析</li>
                                                <li>•一七○ 觀光行政、觀光旅館業、旅館業、旅行業、觀光遊樂業及民宿經營管理業務</li>
                                                <li>•一七三 其他公務機關對目的事業之監督管理</li>
                                                <li>•一七六 其他自然人基於正當性目的所進行個人資料之蒐集處理及利用
                                                    (蒐集方式將透過加入會員、線上訂購、線上留言、來信客服信箱方式進行個人資料之蒐集。)
                                                </li>
                                                <li>•一八一 其他經營合於營業登記項目或組織章程所定之業務</li>
                                            </ul>
                                        </li>
                                        <li>
                                            <h4>三、個人資料之類別</h4>
                                            <P>本公司或本服務將蒐集您的個人資料計有：</P>
                                            <ul>
                                                <li>•C○○一 辨識個人者(姓名、電子郵件地址、行動電話、商品或發票寄送地址、居住地、訂單/憑證序號、提供網路身分認證或申辦查詢服務之紀錄、及其他任何可辨識資料本人者等（含間接辨識之 IP 網路位置、GPS 定位地址、Cookie 及類似的追蹤技術以蒐集個人資料)</li>
                                                <li>•C○○二 辨識財務者(金融機構帳戶之號碼與姓名、信用卡前六及後四碼、個人之其他號碼或帳戶等)</li>
                                                <li>•C○一一 個人描述(年齡、性別、出生年月日、聲音(客服電話)等)</li>
                                                <li>•C○二一 家庭情形(結婚有無、子女有無或人數等)</li>
                                                <li>•C○三六 生活格調(使用消費品之種類及服務之細節、個人之消費模式等)</li>
                                                <li>•C○九三 財務交易(收付金額、支付方式、往來紀錄等)</li>
                                                <li>•C一○二 約定或契約(關於交易、商業、法律或其他契約、代理等)</li>
                                            </ul>
                                            <P>除上述類別外，本公司如有新增類別，將另行提供資料欄位、申請書、同意書、文件等，並以不限書面方式補充之。</P>
                                        </li>
                                        <li>
                                            <h4>四、個人資料利用之期間、地區、對象及方式</h4>
                                            <ul>
                                                <li>1、期間、地區:<br>除法令另有規定外，原則上我們僅會基於您授權的範圍，依法令或於本業務及各項個資蒐集目的存續期間及服務所能到達地區內，依照特定目的明定內容使用必要的使用者資料。
                                                </li>
                                                <li>2、對象、方式:<br>
                                                    (1) 當您在本服務登錄個人資料以進行相關交易、瀏覽本服務時,我們會蒐集您的個人資料作
                                                    為商品或服務預約、金融交易及信用卡授權、使用者管理與客服服務、行銷(含抽獎活動及以電
                                                    子、書面、電話、電信、網際網路及其他方式於蒐集之特定目的範圍內處理並利用消費者個資進
                                                    行合作廠商商品之宣傳行銷)、公益勸募、市場調查、消費者消費習慣調查及其他合於營業登記
                                                    項目業務的經營需要，或觀察您瀏覽行為的特徵、蒐集消費記錄，進行使用者分群與瀏覽模式分
                                                    析,提供專屬您的個人化服務，並將資料提供給本公司(『優惠兌換券』銷售服務相關)、一起旅
                                                    行社股份有限公司(旅遊、旅宿業相關)、自營宅配(含紙本票券、商品相關)、社團法人台灣一起
                                                    夢想公益協會(公益勸募相關)及所委任處理營業相關事務之第三人(例如:合作店家/廠商、信用
                                                    卡收單銀行、付款信用卡發卡銀行、公益勸募團體等)，依照前述服務目的明定內容使用或揭露
                                                    客戶基本資料、帳務資料或其他資料。除非另有法令規範，或另行取得您的同意，否則我們不會
                                                    向前述以外之第三人揭露您個人資料。<br>
                                                    (2) 合法提供資料情形<br>
                                                    您同意如經本公司判斷有下列的情況者，本公司可查看或提供您的個人資料給法院、主管機關、
                                                    或提出適當證明主張其權利受侵害的第三人:<br>
                                                    • 因處理消費爭議或法律另有規定:檢警調查、訴訟、傳票、法院命令、或依司法行政機關的命
                                                    令，作出回應、取得或行使法律權利，或對訴訟上之請求提出防禦。依法有必要分享您的個人資
                                                    料時，將於要求資料機關以正式公文，敘明理由後方提供之。<br>
                                                    • 為執行本公司條款的需要、或維護本服務或本服務的正常運作與安全、對本公司條款的違反，或為了對上述情形採取應對措施。<br>
                                                    • 為了調查和防止非法活動、涉嫌詐欺、對人身安全有潛在威脅的狀況。<br>
                                                    • 為保護其他使用者或其他第三人的合法權益。
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <h4>五、當事人依個人資料保護法第三條規定得行使之權利及方式</h4>
                                            <p>1、您可以檢具身份證明資料等文件，向本公司行使以下權利:</p>
                                            <ul class="ml-4">
                                                <li>○ 查詢或請求閱覽。</li>
                                                <li>○ 請求製給複製本。</li>
                                                <li>○ 請求補充或更正。</li>
                                                <li>○ 請求停止蒐集、處理或利用。</li>
                                                <li>○ 請求刪除。</li>
                                                <li class="mb-2">但多次查詢或請求閱覽個人資料或製給複製本者，本公司得酌收必要成本費用每件 NT50 元。如
                                                    因法律有特別規定或為本公司執行業務所必須者、爭議帳戶或其行為將影響第三人者，本公司得
                                                    不依申請為之。
                                                </li>
                                            </ul>
                                            <p>2、惟當您要求刪除個人資料時，需經核對資料後由本人填寫【當事人權利行使單】，本公司將先凍結遮蔽該資料與其歷史訂單紀錄，並禁止本公司員工對該資料進行因行銷目的之蒐集、處理、利用，並於「法令規定之保存期間屆滿」後進行刪除。</p>
                                            <p>3、如不欲填寫【當事人權利行使單】，應提供可辨識本人之資料供核對，並做成客服記錄註記。</p>
                                        </li>
                                        <li>
                                            <h4>六、拒絕或提供不正確資料之影響</h4>
                                            <p>
                                                您如果拒絕或提供不正確之個人資料給本服務，特別是手機電話號碼、電子郵件地址或信用卡資料，將可能無法使用或影響到本服務對您服務的權益，如:商品或服務電子序號寄送、本公司相關優惠、商品資訊及購買權利等。</p>
                                        </li>
                                    </ul>
                                    <h3>【隱私權保護政策】</h3>
                                    <ul>
                                        <li>
                                            <h4>一、何謂隱私權政策</h4>
                                            <p>本政策保障及適用範圍包括您因使用本各項服務時所提供的個人資料，含本公司因與商業夥伴合
                                                作或共享所取得的任何個人資料(例如第三方廣告)，對於此等實質不屬於本服務之網站或網頁,
                                                不論其內容或隱私權政策，均與本公司無關。本政策旨在規範您使用本服務時或本公司取得使用
                                                者個人資料時的處理方針。</p>
                                        </li>
                                        <li>
                                            <h4>二、使用者個人資料保護</h4>
                                            <p>本公司會盡力保護所有使用者的個人資料與隱私，您所留的資料本公司，依據商品或服務的需要，
                                                評估必要性提供給合作店家/廠商(含其委外託運公司)、信用卡收單銀行、付款信用卡發卡銀行，
                                                您須知悉本公司蒐集您的資料，是為了協助本公司提供您本服務的目的。除了可能涉及違法、侵
                                                權、違反服務條款或經您同意以外，本公司不會無正當理由任意將個人資料內容交予無須知悉的
                                                人或單位;另，本公司所有信用卡交易均係通過安全認證且主機上未留存使用者信用卡完整卡號
                                                (僅前六後四碼)。如您遇到有個人資料洩漏狀況，請您備妥證明，盡快告知本公司處理 GOMAJI
                                                客服中心客服電話(02)2711-1758(上班時間)處理。(『宅配購物+頻道』亦適用此條)。</p>
                                        </li>
                                        <li>
                                            <h4>三、本服務個人資料的蒐集及使用</h4>
                                            <p>當您在本服務登錄個人資料以進行付款時:</p>
                                            <p>(一) 『優惠兌換券』(含預約系統) 、自營宅配(含紙本票券、商品相關) 等銷售服務<br>
                                                我們會蒐集您所留下的姓名、電子郵件地址、手機號碼、IP 網路位置及 GPS 定位地址、消費記
                                                錄、收藏店家、商品或發票寄送地址等個人資料、部分遮蔽之信用卡卡號、有效日期及檢查碼、
                                                瀏覽行為的特徵等資料、設定與存取 Cookie 或與其類似機制、您安裝本服務相關設備及軟體、
                                                及其他因您參加活動使用本服務而主動提供之資料。</p>
                                            <p>以上是為了驗證您的身份，及提供您客製化服務、付款服務及其相關爭議處理、各項優惠措施、
                                                廣告、行銷、市場調查、避免詐騙、防止惡意程式及其他合於營業登記項目業務的經營需要。所
                                                有使用者資料將在由本公司妥當的保存，本公司只會為您進行付款相關程序，才會基於本公司與
                                                銀行、合作店家/廠商的契約關係，依「個人資料保護法」的規定將您的資料轉給信用卡收單銀
                                                行、付款信用卡之發卡銀行及其他廠商，除此之外絶不將您的資料揭露給他人。(『宅配購物+頻
                                                道』亦適用此條)</p>
                                            <p>(二)本服務因提供服務所蒐集、使用的相關資訊,主要例示如下:</p>
                                            <ul class="ml-4">
                                                <li>1、使用者主動提供的資訊。</li>
                                                <li>2、因利用本服務服務所取得的資訊:
                                                    <p class="ml-3">a.本服務因提供本服務服務，為付款、參加贈獎活動或申請其他交易時的客戶識別資訊及其相對
                                                        應的交易資訊。</p>
                                                    <p class="ml-3">b.為本服務或本公司廣告或行銷，使用定位服務或收藏店家服務的相關資訊 或 訂購「優惠訊息
                                                        電子報」、「活動訊息」、麻吉券或其他兌換券分享等相關資訊。</p>
                                                    <p class="ml-3">c.以電話、電子郵件或其他方法，向本服務或本公司提出問題、參與問卷或活動、留言、或進行
                                                        服務評價時,其發言或記載內容之相關資訊。</p>
                                                    <p class="ml-3">d.將使用者交易資訊及實際支付購買的金額，提供給銀行進行付款等相關的業務之相關資訊。</p>
                                                </li>
                                                <li>3、因下載或使用本服務而自動取得之資訊。</li>
                                                <li>4、其他:提供個別服務時，亦可能於上述規定的目的以外，利用個人資料，將依該個別服務之頁面載明其要旨。</li>
                                            </ul>
                                        </li>
                                        <li>
                                            <h4>四、資訊安全</h4>
                                            <p>本服務確保其與消費者交易之電腦系統具有符合一般可合理期待之安全性。本服務所蒐集個人資料或信用卡資訊，本公司將依法採取相關措施,如:</p>
                                            <p>1、安全機制 SSL(Secure Sockets Layer)憑證加密機制(256bit)進行資料傳輸加密。</p>
                                            <p>2、驗證通過並持續導入 PCI DSS 支付卡產業資料安全標準之流程。</p>
                                            <p>3、GOMAJI APP 通過「行動應用資安聯盟」檢測,並取得「行動應用 App 基本資安檢測合格證明書」。</p>
                                            <p>4、資料隱私保護標章(dp.mark) 驗證通過並持續導入「臺灣個人資料保護與管理制度(TPIPAS)」
                                                之流程;公司員工取得「TPIPAS 專業人員資格管理」之個資內評師、管理師證照(個資培訓課程，
                                                係使學員能學習「臺灣個人資料保護與管理制度」相關規範及操作流程，強化企業內部個人資料
                                                管理能量，協助企業自行建置其內部個人資料管理制度)。</p>
                                            <p>5、公司內控措施、資料庫設有防火牆、防毒等各種資訊安全措施，並定期檢查防火牆規則適用
                                                性,並依權責控管存取權限。</p>
                                            <p>6、作業程序面、技術面及本公司人員的個資保護教育訓練、相關處理人員皆簽有保密及個資保
                                                護合約。</p>
                                            <p>7、每季定期對金流系統作弱點掃描、系統滲透測試、資安升級。</p>
                                        </li>
                                        <li>
                                            <h4>五、使用者可選擇個人資料蒐集和使用服務</h4>
                                            <p>(一) 『優惠兌換券』(含預約系統)、自營宅配(含紙本票券、商品相關) 等銷售服務<br>
                                                凡購買經本服務提供的服務或產品，我們將傳送 GOMAJI 網站電子郵件及宣傳電子郵件、
                                                GOMAJI APP 推播予您,建議您必須接收 GOMAJI 網站電子郵件、APP 推播資訊、或主動進行
                                                查詢,因它紀錄了您每日於 GOMAJI 網站的活動，包括您的帳戶、聯絡或查詢及購買優惠。您
                                                可選擇不接收宣傳電子郵件或 APP 推播資訊，我們將於宣傳產品和服務廣告，包括獨家銷售或
                                                其他優惠,或其他由廣告商或附屬公司提供的產品和服務宣傳。假如您不想收到此類宣傳
                                                GOMAJI 相關電子郵件，您可至 GOMAJI 網站、於宣傳電子郵件上方點擊「取消訂閱」連結或
                                                關閉推播提醒。如傳送電子郵件予我們,請註明您的姓名、電子郵件地址。(『宅配購物+頻道』
                                                亦適用此條)。</p>
                                            <p>(二) 個人化服務<br>
                                                您為取得本服務或本服務自行提供的個人資料(例如消費記錄、手機號碼、付款信用卡資料、瀏
                                                覽行為的特徵及定位地址等)，本公司本於後續客服的目的，及使用者與本公司及合作店家/廠商
                                                的契約關係，得依個人資料保護法的特定目的蒐集或處理個人資料。另您同意您本公司可發送「優
                                                惠訊息電子報」、「活動訊息」、「優惠兌換券」(含『宅配購物+頻道』:「商品交易完成通知」)、「法
                                                令宣導」至您的電子郵件信箱、手機簡訊或 APP。您同意本公司得發送之優惠資訊至所使用手機，
                                                並同意接收到本公司所發出之包括但不限於:合作店家/廠商優惠訊息、優惠券銷售服務、及與
                                                其他公司之合作活動、廠商廣告等活動訊息、廣告及文字。如您開啟本服務之移動定位服務
                                                (Location Based Service;下稱 LBS)或收藏店家服務，本公司將分別依據您的定位地址及喜愛店
                                                家狀況，不定時額外推播優惠訊息至所使用手機,提供專屬您的個人化服務。</p>
                                        </li>
                                        <li>
                                            <h4>六、個人資料提供-合作店家/廠商、行銷活動廣告</h4>
                                            <p>本服務若有本公司因客戶服務或行銷活動蒐集、或部分廣告服務由本公司與其他合作/廠商或夥伴所共同經營者，如果您不願將自身個人資料揭露給本公司、其他合作/廠商或夥伴，您可以選擇不使用這些特定服務，但如您開始使用這些特定服務或主動進行資料填寫，即表示您同意將個人資料提供給該特定服務的合作/廠商或夥伴。</p>
                                        </li>
                                        <li>
                                            <h4>七、例外個人資料移轉的情形</h4>
                                            <p>如本服務、本公司、本公司關係企業與其他第三者進行購併或收購資產、營業、股權或其他經營
                                                權變更情事時，本公司會事前將相關細節公告於本服務，本服務及本公司相關網站所擁有的全部
                                                或部分使用者個人資料及相關資訊也可能事前提供給該第三人或相關專業機構進行實地查核，也
                                                可能在前述的狀況下移轉給第三人。</p>
                                        </li>
                                        <li>
                                            <h4>八、準據法及管轄法院</h4>
                                            <p>本政策解釋、補充及適用均以中華民國法令為準據法。因本政策所發生的訴訟，除法律另有規定
                                                外，雙方合意以臺灣臺北地方法院為第一審管轄法院。</p>
                                        </li>
                                    </ul>
                                </div>
                                <!-- End:TermBox GOMAJI -->
                                @if ($date < '2023-04-01 00:00:00')
                                    <h2 id="PrivacyTerm-2" class="t-main mt-4">GOMAJI 宅配購物+頻道 「個人資料蒐集告知 & 隱私權保護政策」</h2>
                                    <div class="TermBox">
                                        <p class="text-right t-gray t-09">更新日期：2020年01月07日</p>
                                        <p>歡迎您使用『宅配購物+』。</p>
                                        <p>本服務系由夠麻吉股份有限公司(以下簡稱 GOMAJI)進行客戶導流、與創業家兄弟股份有限公司(以下簡稱創業家)共同合作營運，商品與服務由創業家經營之【生活市集】提供宅配到府購物服務(以下簡稱本服務)。為提供您安心的購物環境，客戶資料的蒐集、處理、利用、保護均遵守中華民國政府「個人資料保護法」特定目的及相關法令規範，並制定「個人資料蒐集告知 & 隱私權保護政策」(以下簡稱本政策) 用以維護您個人資料及隱私權。若您不同意本政策之全部或部分者,請您停止使用本服務。</p>
                                        <ul>
                                            <li>
                                                <h4>一、適用範圍：</h4>
                                                <p>本政策及其所包含之告知事項,僅適用於本服務。本服務內可能包含許多連結或本服務以外之GOMAJI 或其他合作夥伴所提供的服務，關於上述服務之隱私權聲明及與個人資料保護有關之告知事項，請參閱該服務或與其服務提供者連絡。</p>
                                            </li>
                                            <li>
                                                <h4>二、個人資料保護法應告知事項：</h4>
                                                <p>1. 蒐集機關名稱: GOMAJI、創業家</p>
                                                <p>2. 蒐集目的:<br>
                                                    提供本服務相關服務、行銷、契約、類似契約或其他法律關係事務、客戶管理與服務、網路購物及其他電子商務服務、廣告和商業行為管理業務、以及經營合於營業登記項目或組織章程所定之業務。
                                                </p>
                                                <p>3. 個人資料類別:<br>
                                                    識別類(姓名、職稱、地址、聯絡電話、電子郵件信箱)、特徵類(年齡、性別、出生年月日等)、社會情況類(興趣、休閒、生活格調、消費模式等)、教育、技術或其他專業類(學歷)、受僱情形類(任職公司、職務等)、其他(為完成收款或付款所需之資料、往來電子郵件、網站留言、系統自動紀錄之軌跡資訊及其他得以直接或間接識別使用者身分之個人資料等)，惟將以實際本服務取得之個人資料為限。
                                                </p>
                                                <p>4. 個人資料利用:<br>
                                                    本服務所蒐集的足以識別使用者身分的個人資料，都僅供本服務於其內部、依照蒐集之目的進行處理和利用，除非事先說明、或為完成提供服務或提供優惠訊息或履行合約義務之必要、或依照相關法令規定或有權主管機關之命令或要求，否則本服務不會將足以識別使用者身分的個人資料提供給第三人(包括境內及境外)、或移作蒐集目的以外之使用。<br>
                                                    在會員有效期間內，以及法令所定應保存之期間內，本服務會持續保管、處理及利用相關資料。</p>
                                                <p>5. 個人資料利用對象:<br>
                                                    GOMAJI、創業家或委外之協力廠商(例如:商品供應商、提供物流、金流或活動贈品、展示品之廠商)。</p>
                                                <p>6. 行使個人資料權利方式:<br>
                                                    依個人資料保護法第 3 條規定，就您的個人資料享有查詢或請求閱覽、請求製給複製本、請求補充或更正、請求停止蒐集、處理或利用、請求刪除之權利。您可以透過寄送電子郵件至本服務信箱(<a class="underline" href="mailto:service@buy123.gomaji.com">service@buy123.gomaji.com</a>)方式行使上開權利，本服務於收悉您的請求後，儘速處理。唯因本服務執行職務或業務所必須者,不再此限。
                                                </p>
                                            </li>
                                            <li>
                                                <h4>三、個人資料蒐集、處理及利用說明：</h4>
                                                <p>1. 本服務將在取得您同意後，針對本服務之行銷活動或社群廣告曝光得進行資訊發佈;若您不同意請勿點選同意鍵，或於事後透過各社群服務之會員機制移除相關資訊或拒絕本服務繼續發布相關訊息。若有任何問題，仍可透過寄送電子郵件至本服務信箱(<a class="underline" href="mailto:service@buy123.gomaji.com">service@buy123.gomaji.com</a>)，本服務將協助您確認、處理相關問題。
                                                </p>
                                                <p>2. 若您所填寫之送貨地址、聯絡人、聯絡方式等非您本人之個人資料而下訂單購買即代表您已經當事人同意提供。</p>
                                                <p>3. 除依法應提供予司法、檢調機關、相關主管機關，或與本網站協力廠商為執行相關活動必要範圍之利用外，本服務將不會任意將您的個人資料提供予第三人。</p>
                                            </li>
                                            <li>
                                                <h4>四、安全與保密：</h4>
                                                <p>1. 本服務為保障消費者交易安全，GOMAJI 與創業家均設有相應之資訊管控機制。</p>
                                                <p>2. 當您使用本網站服務時，將會在您的電腦或手機上設定與存取 Cookie 或與其類似機制;您可以透過設定您的瀏覽器，決定是否允許 Cookie 技術的使用，若您關閉 Cookie 時，可能會造成您使用本頻道服務時之不便利或部分功能限制。此外，若您透過 APP 使用本服務，系統將可能於 APP內記錄您的個人資訊。</p>
                                                <p>3. GOMAJI 及創業家僅限於本服務業務所必需才有權限接觸到您的個人資料。</p>
                                                <p>4. 為了保護您個人資料安全，請您不要任意將個人資訊及交易資料揭露或提供予第三人，允許第三人以您的個人資料進行消費行為。若您發現有資料外洩之虞，請立即通知本服務暫停交易權限。</p>
                                            </li>
                                            <li>
                                                <h4>五、例外個人資料移轉或保留之情形：</h4>
                                                <p>當本服務全部或部分終止、分割、獨立公司經營、被其他第三者購併或收購資產，導致經營權轉換或消滅時,本服務有義務於事前公告說明，且本服務所擁有之全部或部分使用者資訊亦可能在經營權轉換的狀況下移轉給第三人或終止後由本服務經營者保留之情形，惟限於與該經營權轉換或後續服務範圍內相關之個人資料。若本服務部分營運移轉予第三人，您仍為本服務之會員，若您不希望本服務後續於經營權轉換利用或終止後由本服務經營者保留您的個人資料，您可以依本隱私權政策行使您的權利。</p>
                                            </li>
                                            <li>
                                                <h4>六、準據法及管轄法院：</h4>
                                                <p>本政策解釋、補充及適用均以中華民國法令為準據法。因本政策所發生的訴訟,除法律另有規定外，雙方合意以臺灣臺北地方法院為第一審管轄法院。</p>
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- End:TermBox 宅配購物 -->
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('script')
    <script>
        // 滾動監控
        $('body').scrollspy({ target: '#faq' })
        $(document).ready(function () {
            $("#faq").sticky({ topSpacing: 0 });
            $(window).scrollTop(0);
        });
    </script>
@endsection
