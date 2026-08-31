# Ubuntu(win)からVPSへSSH

## 概要

パスワード認証 -> 鍵認証へ

## Step1: VPS用鍵を作る(Ubuntu側)

```bash
ssh-keygen -t ed25519 -f ~/.ssh/id_ed25519_vps
```

- `-t`: 鍵の種類(type)
- `-f`: 保存場所・名前を指定(filename)

今回は既存の鍵(GitHub用)とは別で用意する。

鍵の名前もVPS用に分かりやすくする。

今回はパスフレーズも設定。

## Step2: VPSで公開鍵の登録(VPS側)

VPS側の`~/.ssh/authorized_keys`にUbuntu側で作成した`~/.ssh/id_ed25519_vps.pub`の中身をコピペ。

## Step3: SSHログインテスト

```bash
ssh -i ~/.ssh/id_ed25519_vps ユーザ名@VPSのIP
```

=> パスフレーズ聞かれたので入力

### -i

`-i`はidentity file(認証に使う秘密鍵ファイル)を指定するオプション。

Ubuntuにはすでに`~/.ssh/id_rsa`があるので、使用する鍵を明示してあげる。

## Step4: config(Ubuntu側)

`~/.ssh/config`がまだなかったので新規作成。

```bash
Host 任意の名前
    HostName VPSのIPアドレス
    User ユーザー名
    IdentityFile ~/.ssh/id_ed25519_vps
```

- Host ... : 自分で決める接続名
- HostName ... : 実際に接続するVPSのIP
- User ... : VPSでログインするLinuxユーザー
- IdentityFIle ... : 使用する秘密鍵の指定

```
ssh 任意の名前
```

でSSHログインできるようになる。(ただし、パスフレーズは聞かれる)

## Step5: ssh-agent(パスフレーズの省略)

`ssh-agent`は秘密鍵のパスフレーズを、毎回入力しなくて済むように一時的に管理してくれるプログラム。


`ssh-agent`を起動する:

```bash
eval "$(ssh-agent -s)"
```

=> ssh-agentを起動して、このシェルからagentを利用できるように環境変数を設定した

登録:

```bash
ssh-add ~/.ssh/id_ed25519_vps
```

=> パスフレーズを聞かれるので入力

確認:

```bash
ssh-add -l
```

`ssh-add`は魔法の常駐サービスではなく、基本的にはその環境、セッションで動いているプロセス。

