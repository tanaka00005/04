<?php
error_reporting(E_ALL);
ini_set("display_errors", "On"); // 画面上にエラー出力を表示する設定にします
// エラー出力のレベルを設定します
$file_contents = @file("data/todo.txt"); // data\todo.txtファイルを読み込む
// file関数は読み込みに失敗したら
if ($file_contents === false) {
    echo ("data/todo.txtを読み込めませんでした");
    exit(); // プログラム終了
    // FALSEを返す
}

$todo_over_list = array(); // 過去のTODO情報を格納するための配列
$todo_upcoming_list = array(); // 現在のTODO情報を格納するための配列
$today_date = date("Y/m/d");

foreach ($file_contents as $line) {

    $line = mb_convert_encoding($line, "UTF-8", "utf-8, sjis"); // 文字コードを UTF-8に変換
    
    // ↓↓↓ 修正点1：行の前後にある空白や改行を削除する ↓↓↓
    $trimmed_line = trim($line); 
    
    // ↓↓↓ 修正点2：もし空行だったら、このループをスキップする ↓↓↓
    if (empty($trimmed_line)) {
        continue; 
    }

    // タブで区切る
    $parts = explode("\t", $trimmed_line);

    // ↓↓↓ 修正点3：タブで区切って2つの要素がある場合のみ処理する ↓↓↓
    if (count($parts) == 2) {
        $todo_date_str = $parts[0];
        $todo_title = $parts[1];
        
        $todo_date = date("Y/m/d", strtotime($todo_date_str));

        if ($todo_date < $today_date) {
            $todo_over_list[] = array("title" => $todo_title, "date" => $todo_date);
        } else {
            $todo_upcoming_list[] = array("title" => $todo_title, "date" => $todo_date);
        }
    }
    // ↑↑↑ 修正はここまで ↑↑↑
}
require_once("smarty/Smarty.class.php");
$smarty = new Smarty(); // Smartyインスタンス ($smartyオブジェクト)を作成
$smarty->template_dir = "templates"; // テンプレートディレクトリの指定
$smarty->compile_dir = "templates_c"; // コンパイルディレクトリの指定
$smarty->assign("todo_over_list", $todo_over_list); // テンプレート変数に割り当て
$smarty->assign("todo_upcoming_list", $todo_upcoming_list);
$smarty->display("todo.html"); // テンプレートを表示