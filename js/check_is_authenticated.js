// Google認証がされているかどうかチェックする
import { initializeApp }
    from "https://www.gstatic.com/firebasejs/11.0.2/firebase-app.js";
import { getAuth, onAuthStateChanged } from "https://www.gstatic.com/firebasejs/11.0.2/firebase-auth.js";



function IsAuthenticated() {
    // initialize firebase
    initializeApp(firebaseConfig);
    const auth = getAuth();
    onAuthStateChanged(auth, (user) => {
        if (user) {
            // User is signed in
            console.log('User is authenticated:', user);
        } else {
            // User is signed out
            console.log('No user is authenticated');
            // Redirect to login page or show login prompt
            window.location.href = './googleauth.php';
        }
        return user;
    });
}

IsAuthenticated();

