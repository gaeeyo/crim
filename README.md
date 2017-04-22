# Adobe Camera Raw の Index.dat を書き換えるやつ

Adobe Camera Raw はいろんなカメラの RAW ファイルに対応していますが、Panasonicのカメラに関してはカメラプロファイルが「Adobe Standard」しか用意されておらず、ちょっと残念な思いをしていました。
ところが DC-GH5 から状況が変わり、風景やポートレート、シネライクDなどのカメラプロファイルが使えるようになりました。
このツールはプロファイルを他機種でも使えるように、ファイルを書き換えるツールです。
もちろん、他機種用のプロファイルを勝手に使うだけなので結果がどうなるかは知りません。

## 使い方

C:\ProgramData\Adobe\CameraRaw\CameraProfiles\Index.dat をスクリプトと同じディレクトリにコピーします。

コピーした Index.dat は安全のために Index.original.dat にリネームして、読み取り専用にすることをお勧めします。

Index.dat に登録されているモデルの一覧を確認します。

```
>php crim.php Index.original.dat -m
iPad6,3 back camera
iPad6,4 back camera
iPhone8,1 back camera
iPhone8,2 back camera
iPhone8,4 back camera
iPhone9,1 back camera
iPhone9,2 back camera
iPhone9,2 back telephoto camera
iPhone9,3 back camera
iPhone9,4 back camera
iPhone9,4 back telephoto camera
Canon EOS 1000D
Canon EOS 100D
Canon EOS 10D
Canon EOS 1100D
  :
```

コピー元とコピー先のモデル名を指定して、新しい Index.dat を生成します。
```
>php crim.php Index.original.dat -o Index.dat -c "Panasonic DC-GH5" "Panasonic DMC-GX85"
Panasonic DC-GH5 => Panasonic DMC-GX85
 /Library/Application Support/Adobe/CameraRaw/CameraProfiles/Adobe Standard/Panasonic DC-GH5 Adobe Standard.dcp
 /Library/Application Support/Adobe/CameraRaw/CameraProfiles/Camera/Panasonic DC-GH5/Panasonic DC-GH5 Camera Cinelike D.dcp
 /Library/Application Support/Adobe/CameraRaw/CameraProfiles/Camera/Panasonic DC-GH5/Panasonic DC-GH5 Camera Cinelike V.dcp
 /Library/Application Support/Adobe/CameraRaw/CameraProfiles/Camera/Panasonic DC-GH5/Panasonic DC-GH5 Camera L Monochrome.dcp
 /Library/Application Support/Adobe/CameraRaw/CameraProfiles/Camera/Panasonic DC-GH5/Panasonic DC-GH5 Camera Monochrome.dcp
 /Library/Application Support/Adobe/CameraRaw/CameraProfiles/Camera/Panasonic DC-GH5/Panasonic DC-GH5 Camera Natural.dcp
 /Library/Application Support/Adobe/CameraRaw/CameraProfiles/Camera/Panasonic DC-GH5/Panasonic DC-GH5 Camera Portrait.dcp
 /Library/Application Support/Adobe/CameraRaw/CameraProfiles/Camera/Panasonic DC-GH5/Panasonic DC-GH5 Camera Scenery.dcp
 /Library/Application Support/Adobe/CameraRaw/CameraProfiles/Camera/Panasonic DC-GH5/Panasonic DC-GH5 Camera Standard.dcp
 /Library/Application Support/Adobe/CameraRaw/CameraProfiles/Camera/Panasonic DC-GH5/Panasonic DC-GH5 Camera Vivid.dcp
```
生成された Index.dat を元の場所にコピーして上書きします。
