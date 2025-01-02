const deadline = document.getElementById("deadline");

setMinimumDate();


//以下、function定義-----------------------------
//今日の日付以前は選択できないように設定する
function setMinimumDate() {
    const today = new Date().toISOString().split("T")[0];
    deadline.attr("min", today);
}