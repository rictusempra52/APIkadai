<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <!-- ログインボタン -->
    <main>
        <div class="login-container">
            <button id="google-login-btn" class="btn btn-primary">
                <img src="./img/google.webp" alt="Google Icon" class="google-icon"> Googleでログイン
            </button>
        </div>
    </main>

    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Firebase Config -->
    <script src="./js/apikey.js"></script>

    <!-- Firebase Authentication Script -->
    <script type="module">
        // 必要なFirebaseライブラリを読み込み
        import { initializeApp }
            from "https://www.gstatic.com/firebasejs/11.0.2/firebase-app.js";
        import { getAuth, signInWithPopup, GoogleAuthProvider }
            from "https://www.gstatic.com/firebasejs/11.0.2/firebase-auth.js";

        // FirebaseConfig
        const app = initializeApp(firebaseConfig);

        // Google Auth 認証
        const provider = new GoogleAuthProvider();
        const auth = getAuth();

        // ログインボタンのクリックイベント
        $("#google-login-btn").on("click", function () {
            signInWithPopup(auth, provider)
                .then((result) => {
                    // ユーザー情報取得
                    const user = result.user;
                    alert(`ようこそ、${user.displayName}さん！`);
                    // 遷移先
                    location.href = "./index.php";
                })
                .catch((error) => {
                    // Handle Errors here.
                    const errorCode = error.code;
                    const errorMessage = error.message;
                    // The email of the user's account used.
                    const email = error.email;
                    // The AuthCredential type that was used.
                    const credential = GoogleAuthProvider.credentialFromError(error);

                    alert("ログインに失敗しました。再試行してください。");
                });
        });
    </script>

</body>

</html>