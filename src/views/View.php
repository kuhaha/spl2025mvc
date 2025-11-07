<?php
namespace spl2025\views; 

// ビュー(View)　
class View
{
    protected $shared = [];
    static $url_base = null;
    static $VIEW_DIR = "src/views/templates";

    public function __construct($url_base)
    {
        self::$url_base = rtrim($url_base, '/');
        $this->shared['_url_base_'] = self::$url_base;
    }
    
    static function setViewDir($dir)
    {
        self::$VIEW_DIR = rtrim($dir, '/');
    }

    public function share($name, $value)
    {
        $this->shared[$name] = $value;
    }
    
    /**
     * render(): テンプレート$tplを基に$paramsに含まれる変数が使って、画面を描画する。
     */
    public function render($tpl, $params=[])
    {
        ob_start(); //バッファをオンにして出力をせず保存する(複数のファイルによる出力途中でエラーにならないように)

        extract($this->shared);
        extract($params);
        // extract(): キーを変数名、値を変数の値として、配列の要素を変数に変換する 
        // 例：$arr=['foo'=>1,'bar=>'hello']）; 
        // extract($arr); 
        // これによって$foo, $barという変数が使える（値がそれぞれ1と'hello')
        include self::$VIEW_DIR . "/pg_header.php";
        include self::$VIEW_DIR . "/{$tpl}.php";
        include self::$VIEW_DIR . "/pg_footer.php"; 
        ob_end_flush(); //アクティブな出力用バッファをフラッシュ(送信)する
    }

    /**
     * redirect($url): $urlへ画面遷移する
     * $urlはRouterパターンの書き方に従うURL。例: '/u/auth', `/u/detail/s0001`
     */ 
    public function redirect($url)
    {
        $real_url = self::$url_base. $url;
        header("Location:{$real_url}");
    }
}