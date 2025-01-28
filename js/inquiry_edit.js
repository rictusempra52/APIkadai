// DOM
const room_id = document.getElementById("room_id");
const inquiry = document.getElementById("inquiry");
const deadline = document.getElementById("deadline");
const button1 = document.getElementById("button1");

// イベントハンドラ

// 読み込み完了時
document.addEventListener('DOMContentLoaded', () => {
    setMinimumDate();
    enableButton1();
});
// room_id, inquiry, deadlineの内容が変更されたとき
// button1の有効/無効を切り替え
room_id.addEventListener("input", enableButton1);
inquiry.addEventListener("input", enableButton1);
deadline.addEventListener("input", enableButton1);

//function定義

//今日の日付以前は選択できないように設定する
function setMinimumDate() {
    const today = new Date().toISOString().split("T")[0];
    deadline.setAttribute("min", today);
}

// button1の有効・無効を切り替える関数
function enableButton1() {
    // 必要な入力フィールドを配列に格納
    const fields = [room_id, inquiry, deadline];
    // いずれかのフィールドが空の場合、ボタンを無効化
    button1.disabled = fields.some(field => !field.value);
}

