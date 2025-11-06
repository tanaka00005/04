<?php
// エラーを強制的に表示
ini_set("display_errors", "On");
error_reporting(E_ALL);

echo "<h1>権限チェック</h1>";

$data_file = 'data/todo.txt';
$compile_dir = 'templates_c';

// --- data/todo.txt の読み込みチェック ---
echo "<h3>1. '{$data_file}' の読み込みチェック</h3>";
if (is_readable($data_file)) {
    echo '<p style="color: green; font-weight: bold;">OK: data/todo.txt は読み込めます。</p>';
} else {
    echo '<p style="color: red; font-weight: bold;">エラー: data/todo.txt が読み込めません！</p>';
    echo "<p>フルパス: " . realpath($data_file) . "</p>";
}

// --- templates_c の書き込みチェック ---
echo "<h3>2. '{$compile_dir}' の書き込みチェック</h3>";
if (is_writable($compile_dir)) {
    echo '<p style="color: green; font-weight: bold;">OK: templates_c フォルダに書き込めます。</p>';
} else {
    echo '<p style="color: red; font-weight: bold;">エラー: templates_c フォルダに書き込めません！</p>';
    echo "<p>これが画面が真っ白になる原因である可能性が非常に高いです。</p>";
    echo "<p>フルパス: " . realpath($compile_dir) . "</p>";
}
?>