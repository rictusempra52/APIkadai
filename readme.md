# マンション管理員用アプリ(結合集計実装ver)

`readme.md` の修正：2025 年 1 月 15 日追加分から、日付を明記するようにしました。

# 制作サイトの説明

お客様からの問い合わせを登録できるようにしました。  
MySQL への接続ができるようになりました。
これまでは部屋番号と問い合わせ内容のみでしたが、対応期日も保存するようになりました。

## 2025 年 1 月 22 日追記

- ログイン、ログアウト、ユーザー登録を実装した！

## 2025 年 1 月 28 日追記

- ユーザーを管理員アカウントと居住者アカウントに分け、問い合わせ履歴画面には居住者ごとの問い合わせ件数を表示するようにした。
  ※「管理員用アプリ」であれば関係ない機能(=部屋番号は管理員が入力する)ですが、卒業制作は、居住者が自分でログインするアプリに切り替えようかなと思ったので追加しました。

# DEMO

- [デプロイ済みのサイト](https://indigodingo.sakura.ne.jp/apiKadai/)
  - 開くとまず「ログインしてください」の案内が出て、ログインページに飛びます。
  - ログアウトの際は、ログイン後に右上のユーザーアイコンをクリックしてください。
- [GitHub](https://github.com/rictusempra52/APIkadai)

## IDPW

- ID(メールアドレス): r@r
- PW: edm456

# 工夫した点・こだわった点

- 複数行入力を適切に保存するために URL エンコードを使用したこと
- `/functions.php` に関数を集約し、コードを整理したこと
- 事業企画プレゼンなどを `presentation/` に集約した！
- 問い合わせ内容が空欄の時の処理を CSS で記述した。結構わかりやすい UI になったはず
- .env を使って環境変数を管理、したかったができなかったので env.php を作って管理した

### 2025 年 1 月 15 日追加

- 下記「難しかった点」記載の通り、自分でもミスに気付かなかったため、編集結果をアラートするようにしました。

### 2025 年 1 月 21 日追加

- `header.php` を `require_once` で共通化したことを利用し、`header.php`でログイン状態を確認するようにしました。→ 色んなページに記載しなくてよくなった！はず！

### 2025 年 1 月 28 日追加

- current_timestamp()という phpmyadmin 側の設定を活用した。(問い合わせ履歴画面に反映されない新しいテーブルへの活用ですが。。)

# 難しかった点・次回トライしたいこと（または機能）

## 難しかった点

- そもそもデプロイが訳わからなさ過ぎて半日はつぶした・・・

### 2025 年 1 月 15 日追加

- 更新が更新になっていなく、追加になっていたことに全然気づきませんでした。わかりやすいように修正したほうがよさそう。

### 2025 年 1 月 18 日追加

→ アラート追加に苦戦。やっとできた。

### 2025 年 1 月 22 日追加(ログイン・ログアウト実装課題)

- `header.php`を`require_once`で共通化していましたが、それによりファイルパスの記述方法に問題が生じました。
  → やっと解決。PHP では`__DIR__`などを使い、HTML では`$bathPath` を使いました。何が違うのかよくわからない
  [chappy](https://chatgpt.com/share/67907df8-b090-800b-904a-ad1136136b1d)

```
$basePath = ($_SERVER['SERVER_NAME'] == 'localhost')
    ? 'https://localhost/Gsacademy/apiKadai/'
    : 'https://indigodingo.sakura.ne.jp/apiKadai/';
```

### 2025 年 1 月 28 日追加

- 結合等の処理を考えるのには想像力が必要だった。講義の内容で何を実装できるかを考えるのも大変。
- 年明け、仕事の本格化に伴い、とにかく課題要件を満たすことしかできませんでした。少しでも隙間時間を作らないと...

## 追加したい機能

- 問い合わせ対応の修正、更新 → 完了。削除を追加したい

### 2025 年 1 月 15 日追加

- 論理削除完了！
- 対応期限が近づいていたら目立たせる機能を追加したい → 全然手がついてない

### 2025 年 1 月 21 日追加

- 過去に実装していた google ログインとの連携方法が思いつかず、一旦コメントアウトしてしまいました。
  →googleID からメールアドレスを取得して DB に保管？PW はどうしているのだろう？？

  ### 2025 年 1 月 28 日追加

- 卒制は一から作り直し！defy を大いに活用した制作にしたい！！

# 備考（感想、シェアしたいこと等なんでも）

- vscode のショートカットキーを意識して覚えるようにしました。
  Alt+上下でカーソルのある行をそのまま上下に移動 https://qiita.com/12345/items/64f4372fbca041e949d0
- `require_once` を使うと、header や footer ,function をサイト内で共通化できる！

## デプロイ時に困ったことメモ

- filezilla で UP した後でも、デプロイされたものを確認しようとする古いファイルが開いてしまう。→ キャッシュ削除 or SuperReload`ctrl+shift+r` で解決した
- `{"database error":"SQLSTATE[HY000] [2002] No such file or directory"}` のエラーが出る。localhost では問題ない → 未解決
  [ﾁｬｯﾋﾟｰ](https://chatgpt.com/share/67723b87-6614-800b-96c6-604060d1be42)
  「接続先ホスト名が間違っている場合（例: localhost vs 127.0.0.1）、接続に失敗します。」を試したら、
  今度は`{"database error":"SQLSTATE[HY000] [2002] Connection refused"}`のエラーになった。
- → ホスト名は localhost でも 127.0.0.1 でも一緒で、いずれも localhost を指すことが分かった。
- → そもそも mysql の正しいホスト名や id を入れる必要があった。

## 2025 年 1 月 15 日追加

- 「更新された」「追加された」はわかるように `alert` を出したほうが良い。
- `alert` を出す処理は、`session` を使うとよい。

## 2025 年 1 月 22 日追加

- `login_functions.php` にログイン関係の関数を集約しましたが、`○○_post.php` に個別に書いたほうが楽かも、と思いました。
- localhost とさくらサーバー上のデータテーブルは、エクスポートした sql ファイルを使うと簡単

### 2025 年 1 月 28 日追加

- CLINE という拡張機能がすごい。(たまに明後日の方向へどんどんコードを変更していきますが)内容を復習しないと勉強にならなさそうです。
- `current_timestamp()`はちょっと便利かも。
