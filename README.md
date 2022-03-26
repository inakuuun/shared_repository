## push先は「development」or「自分のブランチ」にする
共有ディレクトリを編集した場合には自分のブランチのままpushする(developmentに向けない)
<br>
自分のディレクトリのみの場合にはdevelopmentに向けてpushでOK！
<br>
masterブランチは触らずにdevelopmentからPull requestを出してマージする形にする。
<br>
こうしておくことで間違ってファイル上書きすることを避ける。

## commitメッセージは先頭に自分の名前を入れておく
「自分の名前: やったこと」のようなメッセージにする
