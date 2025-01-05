import { initializeApp } from "https://www.gstatic.com/firebasejs/11.1.0/firebase-app.js";
import { getFirestore, collection, addDoc, getDocs, serverTimestamp, } from "https://www.gstatic.com/firebasejs/11.1.0/firebase-firestore.js";
import { cloudVisionAPIkey, firebaseConfig } from "./apikey.js";

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const db = getFirestore(app);

// DOM
const notifDoc = document.getElementById("notification_document");
const preview = document.getElementById("preview");
const submit = document.getElementById("submit");
const displayResultHistory = document.getElementById("display_result_history");
const analysisResultText = document.getElementById("analysis_result_text");
const analysisResultTimestamp = document.getElementById("analysis_result_timestamp");

// イベントハンドラ
document.addEventListener("DOMContentLoaded", function () {
    let chosenFile = null;

    // ファイル入力（#notification_document）が変更されたとき
    notifDoc.addEventListener("change", function () {
        // ファイルが選択されていないときは何もしない
        if (this.files.length === 0) return;
        // 送信ボタンを有効化
        submit.disabled = false;

        // 選択された最初のファイルを取得
        chosenFile = this.files[0];
        const reader = new FileReader();
        reader.readAsDataURL(chosenFile);

        // FileReaderの読み込みが完了したとき、読み込んだファイルを画像プレビューに設定
        // e.target.resultはBase64エンコードされたデータURL(なんのこっちゃ)
        reader.onload = (e) => { preview.src = e.target.result };
    });
});

// // submitボタンがクリックされたときの処理(先にPHPで転送されてるため今は動作しない)
// submit.addEventListener("click", function () {
//     // 画像を送信
//     analysePicture(chosenFile).then((result) => {
//         console.log('Analysis Result:', result);
//         const analysisResult = result.responses[0].fullTextAnnotation.text;
//         // 結果を画面に表示
//         analysisResultText.textContent = analysisResult;
//         sendDataToFirebase(analysisResult);
//     });
// });

// 履歴表示ボタンがクリックされたときの処理
displayResultHistory.addEventListener("click", async function () {
    try {
        const history = []; // データを保存する配列

        // コレクションを参照
        const ocrDataCollection = collection(db, "OCRData");

        const querySnapshot = await getDocs(ocrDataCollection);
        // 取得したデータを配列に追加
        querySnapshot.forEach((doc) => { history.push(doc.data()); });
        // データをコンソールに表示
        console.log(history);
        // 必要ならデータを使ってUIを更新
        analysisResultText.innerHTML = historyElements(history);

    } catch (error) {
        console.error("データの取得中にエラーが発生しました:", error);
        alert("データの取得に失敗しました。");
    }
});

/** Cloud Vision APIを使用して画像を分析する関数 
 * @param {File} File 分析対象の画像ファイル
 * @returns {Promise<Object>} 分析結果
 */
async function analysePicture(File) {
    const API_URL = `https://vision.googleapis.com/v1/images:annotate?key=${cloudVisionAPIkey}`;

    // ファイルをBase64エンコード
    const base64EncodeFile = (File) => {
        return new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.onload = () => resolve(reader.result.split(',')[1]); // "data:image/jpeg;base64,"の部分を除去
            reader.onerror = (error) => reject(error);
            reader.readAsDataURL(File);
        });
    };

    try {
        const base64Image = await base64EncodeFile(File);

        // Cloud Vision APIに送信するリクエストボディ
        const requestBody = {
            requests: [{
                image: { content: base64Image },
                features: [{ type: 'TEXT_DETECTION', maxResults: 10 }]
            }]
        };

        // Vision APIへリクエストを送信
        const response = await fetch(API_URL, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(requestBody)
        });

        console.log(response);

        // 結果を取得して返す
        if (response.ok) {
            const data = await response.json();
            return data;
        } else {
            const error = await response.text();
            throw new Error(`API Error: ${error}`);
        }
    } catch (error) {
        console.error('Error in analysePicture:', error);
        throw error; // 呼び出し元でエラーをキャッチ
    }
}

function sendDataToFirebase(text) {
    const postData = {
        text: text,
        time: serverTimestamp(),
    };
    addDoc(collection(db, "OCRData"), postData);
    analysisResultTimestamp.text(postData.time);

}
// 「配列形式にした履歴データ」を入力して「表示用のタグにいれて」出力する関数
function historyElements(historyDocuments) {
    const elements = [];
    historyDocuments.forEach(function (document) {
        elements.push(
            `<li id="${document.id}">
                    <p>${document.text}</p>
                </li>`
        );
    });
    return elements;
}
