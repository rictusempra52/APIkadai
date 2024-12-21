// Import the functions you need from the SDKs you need
import { initializeApp } from "https://www.gstatic.com/firebasejs/11.1.0/firebase-app.js";
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries
import {
    getFirestore,
    collection,
    addDoc,
    getDocs,
    serverTimestamp,
} from "https://www.gstatic.com/firebasejs/11.1.0/firebase-firestore.js";

const app = initializeApp(firebaseConfig);
const db = getFirestore(app);

// DOM
const notificationDocument = $("#notification_document");
const preview = document.getElementById("preview");
const displayResultHistory = document.getElementById("display_result_history");
const analysisResultText = document.getElementById("analysis_result_text");
const analysisResultTimestamp = document.getElementById("analysis_result_timestamp");

$(function () {
    // ファイル入力（#notification_document）の変更イベントを監視
    notificationDocument.on("change", function () {
        // 選択された最初のファイルを取得
        const file = this.files[0];
        const reader = new FileReader();

        // FileReaderの読み込み完了イベント
        reader.onload = function (e) {
            // 読み込んだファイルを画像プレビューに設定
            // e.target.resultはBase64エンコードされたデータURL(なんのこっちゃ)
            preview.attr("src", e.target.result);
        };
        reader.readAsDataURL(file);

        // thenをつけるととりあえずうまくいった(なんのこっちゃ)
        analysePicture(file)
            .then((result) => {
                const analysisResult = result.responses[0].fullTextAnnotation.text;
                console.log('Analysis Result:', result);
                // 結果を画面に表示
                analysisResultText.text(analysisResult);
                sendDataToFirebase(analysisResult);
            })
    });

    // ボタンがクリックされたときの処理
    displayResultHistory.on("click", async function () {
        try {
            const history = []; // データを保存する配列

            // コレクションを参照
            const ocrDataCollection = collection(db, "OCRData");

            getDocs(ocrDataCollection)
                .then((querySnapshot) => {
                    // 取得したデータを配列に追加
                    querySnapshot.forEach((doc) => { history.push(doc.data()); })
                    // データをコンソールに表示
                    console.log(history);
                    // 必要ならデータを使ってUIを更新
                    analysisResultText.html(historyElements(history));
                });

        } catch (error) {
            console.error("データの取得中にエラーが発生しました:", error);
            alert("データの取得に失敗しました。");
        }
    });
    async function analysePicture(file) {
        const API_URL = `https://vision.googleapis.com/v1/images:annotate?key=${cloudVisionAPIkey}`;

        // ファイルをBase64エンコード
        const base64EncodeFile = (file) => {
            return new Promise((resolve, reject) => {
                const reader = new FileReader();
                reader.onload = () => resolve(reader.result.split(',')[1]); // "data:image/jpeg;base64,"の部分を除去
                reader.onerror = (error) => reject(error);
                reader.readAsDataURL(file);
            });
        };

        try {
            const base64Image = await base64EncodeFile(file);

            // Cloud Vision APIに送信するリクエストボディ
            const requestBody = {
                requests: [
                    {
                        image: { content: base64Image },
                        features: [{ type: 'TEXT_DETECTION', maxResults: 10 }] // 必要に応じて変更
                    }
                ]
            };

            // Vision APIへリクエストを送信
            const response = await fetch(API_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(requestBody)
            });

            // console.log(response);


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
            elements.push(`
        <li id="${document.id}">
        <p>${document.text}</p>
        </li>
      `);
        });
        return elements;
    }


});