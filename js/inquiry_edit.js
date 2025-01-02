const deadline = document.getElementById("deadline");

document.addEventListener('DOMContentLoaded', setMinimumDate);

//以下、function定義-----------------------------
//今日の日付以前は選択できないように設定する
function setMinimumDate() {
    const today = new Date().toISOString().split("T")[0];
    deadline.setAttribute("min", today);
}