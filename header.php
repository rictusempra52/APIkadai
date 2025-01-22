<?php
// localhost かさくらサーバーかを判別して、パスを取得
$basePath = ($_SERVER['SERVER_NAME'] == 'localhost')
    ? 'https://localhost/Gsacademy/apiKadai/'
    : 'https://indigodingo.sakura.ne.jp/apiKadai/';

require_once __DIR__ . "/login/login_functions.php";// ユーザーが認証しているかを判別する処理
if (!isLogin()) {
    // 認証していない場合は、ログイン画面へリダイレクト
    echo "
        <script>
            alert('ログインしてください');
            location.href='./login/login.php';
        </script>";
    exit;
}

?>
<header class="header">

    <!-- SVGアイコン -->
    <a href="<?= $basePath; ?>index.php" class="icon-link">
        <img src="<?= $basePath; ?>img/logo.svg" alt="Logo" class="icon" width="20" height="20">
    </a>
    <!-- メニュー -->
    <div class="menu"></div>
    <div class="usericon">
        <img src="<?= $basePath; ?>img/usericon.png" alt="">
    </div>
    <!-- firebaseのapikey読み込み -->
    <!-- <script type="module" src="js/apikey.js"></script> -->

    <!-- usericonに、認証しているgoogleアカウントのアイコンを表示する処理 -->
    <!-- <script type="module">
        // firebase
        import { initializeApp }
            from "https://www.gstatic.com/firebasejs/11.0.2/firebase-app.js";
        import { getAuth, onAuthStateChanged } from "https://www.gstatic.com/firebasejs/11.0.2/firebase-auth.js";

        const firebaseConfig
            = json_decode(
                <?php
                // require_once "js/apikey.php";
                // echo json_encode(firebaseConfig()); 
                ?>
            );

        initializeApp(firebaseConfig);

        // usericonに、認証しているgoogleアカウントのアイコンを表示する処理
        const usericon = document.querySelector(".usericon");
        const auth = getAuth();
        console.log(auth);

        // img要素を作成
        const profileImage = document.createElement("img");
        // 認証状態をチェック
        onAuthStateChanged(auth, (user) => {
            // usericonにimgを追加
            usericon.appendChild(profileImage);
            if (user) {
                // 認証している場合
                // usericonに、認証しているgoogleアカウントのアイコンを表示する処理
                profileImage.src = user.photoURL;
                console.log("google認証済み");

            } else {
                profileImage.src = "img/usericon.png";
                console.log("google未認証");
            }
        });
    </script> -->
</header>
<script>
    // usericonをクリックしたときにログアウトするか聞く
    document.querySelector(".usericon")
        .addEventListener("click", () => {
            if (window.confirm("ログアウトしますか？")) {
                window.location.href = "<?= $basePath; ?>login/logout.php";
            }
        });
            }
        });
</script>
