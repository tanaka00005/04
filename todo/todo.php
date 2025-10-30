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

    list($todo_date_str, $todo_title) = explode("\t", $line); // タブで区切る
    $todo_date = date("Y/m/d", strtotime($todo_date_str));
    if ($todo_date < $today_date) {
        $todo_over_list[] = array("title" => $todo_title, "date" => $todo_date);
    } else {
        $todo_upcoming_list[] = array("title" => $todo_title, "date" => $todo_date);
    }
}
require_once("smarty/Smarty.class.php");
$smarty = new Smarty(); // Smartyインスタンス ($smartyオブジェクト)を作成
$smarty->template_dir = "templates"; // テンプレートディレクトリの指定
$smarty->compile_dir = "templates_c"; // コンパイルディレクトリの指定
$smarty->assign("todo_over_list", $todo_over_list); // テンプレート変数に割り当て
$smarty->assign("todo_upcoming_list", $todo_upcoming_list);
$smarty->display("todo.html"); // テンプレートを表示