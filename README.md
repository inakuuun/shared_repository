## ブランチ名の決め方
基本的には実装したことをブランチ名に入れます
<br>
例)自己紹介HP作った=>create_hp
<br>
ただ、上記だと他の人と被る場合が出そうなのでcreate_hp_by_tokuyuuuuuuみたいにby_自分の名前を推奨します。

## push先は「development」or「自分で作ったブランチ」にする
共有ディレクトリを編集した場合には自分のブランチのままpushする(developmentに向けない)
<br>
自分のディレクトリのみの場合にはdevelopmentに向けてpushでOK！
<br>
masterブランチは触らずにdevelopmentからPull requestを出してマージする形にする。
<br>
こうしておくことで間違ってファイル上書きすることを避ける。

## commitメッセージは先頭に自分の名前を入れておく
「自分の名前: やったこと」のようなメッセージにする

