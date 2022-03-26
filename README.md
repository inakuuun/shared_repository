## push先は「development」or「自分のブランチ」にする
共有ディレクトリを編集した場合には自分のブランチのままpushする(developmentに向けない)
<br>
自分のディレクトリのみの場合にはdevelopmentに向けてpushでOK！
<br>
masterブランチは触らずにdevelopmentからPull requestを出してマージする形にする。
<br>
こうしておくことで間違ってファイル上書きすることを避ける。

## メンバーの共有ディレクトリは「member_share」ディレクトリにする
上記ディレクトリ内には直接hoge.htmlのようなファイルを置かない。
<br>
hoge_fugaのようにディレクトリを作ってその中にファイルを配置する。

## commitメッセージは先頭に自分の名前を入れておく
「自分の名前: やったこと」のようなメッセージにする
