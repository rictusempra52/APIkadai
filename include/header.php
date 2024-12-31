<header class="header">
    <!-- SVGアイコン -->
    <a href="../index.php" class="icon-link">
        <svg class="icon" width="20" height="20" viewBox="0 0 64.81481481481481 292.23323636475305">
            <g transform="translate(-10.453328190887945, -125.88725048922286) scale(20.90665638177589)" fill="#f6f5f5">
                <path
                    d="M0.93238 19.99939454 l-0.43238 0 l0 -13.978 l0.43238 0 l0 13.978 z M1.6003 19.99939454 l-0.43238 0 l0 -13.978 l0.43238 0 l0 13.978 z M2.2664 19.99939454 l-0.43238 0 l0 -13.978 l0.43238 0 l0 13.978 z M2.9342 19.99939454 l-0.43238 0 l0 -13.978 l0.43238 0 l0 13.978 z M3.6002 19.99939454 l-0.43238 0 l0 -13.978 l0.43238 0 l0 13.978 z">
                </path>
            </g>
        </svg>
    </a>
    <!-- メニュー -->
    <div class="menu"></div>
    <div class="usericon"> <!-- googleアイコン --> </div>
    <!-- firebaseのapikey読み込み -->
    <script src="../js/apikey.js"></script>

    <!-- usericonに、認証しているgoogleアカウントのアイコンを表示する処理 -->
    <script type="module">
        // firebase
        import { initializeApp }
            from "https://www.gstatic.com/firebasejs/11.0.2/firebase-app.js";
        import { getAuth, onAuthStateChanged } from "https://www.gstatic.com/firebasejs/11.0.2/firebase-auth.js";
        initializeApp(firebaseConfig);

        // usericonに、認証しているgoogleアカウントのアイコンを表示する処理
        const usericon = document.querySelector(".usericon");
        const auth = getAuth();
        // 認証状態をチェック
        onAuthStateChanged(auth, (user) => {
            // 認証している場合
            if (user) {
                const profileImage = document.createElement("img");
                // imgを50x50にする
                profileImage.width = 50;
                profileImage.height = 50;
                // imgにアイコンを表示
                profileImage.src = user.photoURL;
                profileImage.alt = user.displayName;
                // iconを丸くする
                usericon.style.borderRadius = "50%";
                // imgが丸くならない場合、はみ出た部分を隠す
                usericon.style.overflow = "hidden";

                // usericonにimgを追加
                usericon.appendChild(profileImage);
            }
            // 認証していない場合
            else {
                usericon.innerHTML = "未認証";
                console.log("認証していません");

            }
        });

    </script>
</header>