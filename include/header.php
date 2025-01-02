<header class="header">
    <!-- SVGアイコン -->
    <a href="../index.php" class="icon-link">
        <img src="img/logo.svg" alt="Logo" class="icon" width="20" height="20">
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